<?php

namespace App\Nova;

use App\Models\StudentInactivePeriod;
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
        return 'Period';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderBy('inactive_from', 'asc');
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Student', 'student', StudentNovaResource::class)
                     ->readonly(),

            Date::make('Inactive From', 'inactive_from')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->required()
                ->rules('required', 'date', 'before_or_equal:inactive_to'),

            Date::make('Inactive To', 'inactive_to')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->required()
                ->rules('required', 'date', 'after_or_equal:inactive_from'),
        ];
    }
}
