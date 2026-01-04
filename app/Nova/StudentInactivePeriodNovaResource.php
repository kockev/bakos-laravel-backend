<?php

namespace App\Nova;

use App\Models\GeneralSettings;
use App\Models\StudentInactivePeriod;
use App\Support\Roles;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class StudentInactivePeriodNovaResource extends Resource
{
    public static string $model = StudentInactivePeriod::class;

    public static $displayInNavigation = false;

    public static $search = [];

    public static function singularLabel(): string
    {
        return __('Period');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderBy('inactive_from', 'asc');
    }

    public function fields(NovaRequest $request)
    {
        $isGuest = $request->user()->hasRole(Roles::GUEST);

        /** @var GeneralSettings $generalSettings */
        $generalSettings = app(GeneralSettings::class);
        $minDate         = Carbon::now() < $generalSettings->student_edit_closing_time ? Carbon::today() : Carbon::tomorrow();

        $fields = [
            BelongsTo::make($isGuest ? 'Diák' : 'Student', 'student', StudentNovaResource::class)
                     ->readonly(),
        ];

        if ($isGuest) {
            $fields[] = Date::make(__('Inactive From'), 'inactive_from')
                            ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                            ->required()
                            ->min($minDate)
                            ->max(Carbon::today()->addWeek(1))
                            ->rules('required', 'date', 'before_or_equal:inactive_to');

            $fields[] = Date::make(__('Inactive To'), 'inactive_to')
                            ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                            ->required()
                            ->min($minDate)
                            ->max(Carbon::today()->addWeek(1))
                            ->rules('required', 'date', 'after_or_equal:inactive_from');
        } else {
            $fields[] = Date::make(__('Inactive From'), 'inactive_from')
                            ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                            ->required()
                            ->rules('required', 'date', 'before_or_equal:inactive_to');

            $fields[] = Date::make(__('Inactive To'), 'inactive_to')
                            ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                            ->required()
                            ->rules('required', 'date', 'after_or_equal:inactive_from');
        }

        return $fields;
    }
}
