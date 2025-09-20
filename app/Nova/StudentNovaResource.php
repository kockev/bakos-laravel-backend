<?php

namespace App\Nova;

use App\Enums\AgeGroupTypeEnum;
use App\Enums\MealTypeEnum;
use App\Models\GeneralSettings;
use App\Models\Student;
use App\Models\User;
use App\Support\Roles;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class StudentNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Student::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Student Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'email',
        'status',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return auth()->check() && auth()->user()->hasRole(Roles::GUEST) ? 'Diákok' : 'Students';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return auth()->check() && auth()->user()->hasRole(Roles::GUEST) ? 'Diák' : 'Student';
    }

    /**
     * Modify the index query to filter institutions based on the user's institution_id.
     *
     * @param NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        /** @var User $user */
        $user = $request->user();
        if ($user->hasRole(Roles::GUEST)) {
            return $query->where('institution_id', $request->user()->institution_id);
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        /** @var GeneralSettings $generalSettings */
        $generalSettings = app(GeneralSettings::class);
        $minDate         = Carbon::now() < $generalSettings->student_edit_closing_time ? Carbon::today() : Carbon::tomorrow();

        $isGuest = $request->user()->hasRole(Roles::GUEST);

        if ($isGuest) {
            return [
                BelongsTo::make('Intézmény', 'institution', InstitutionNovaResource::class)
                         ->displayUsing(function ($institution) {
                             return $institution ? $institution->name : '-';
                         })
                         ->readonly(),

                Text::make('Név', 'name')
                    ->sortable()
                    ->readonly(),

                Boolean::make('Jelenlét', function () {
                    return $this->isActive();
                })->readonly(),

                BelongsTo::make('Diéta', 'diet', DietNovaResource::class)
                         ->displayUsing(function ($diet) {
                             return $diet ? $diet->name : '-';
                         })
                         ->readonly(),

                Date::make('Hiányzik (-tól)', 'inactive_from')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                    ->hideWhenCreating()
                    ->hideFromIndex()
                    ->min($minDate)
                    ->max(Carbon::today()->addWeek(1)),

                Date::make('Hiányzik (-ig)', 'inactive_to')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                    ->hideWhenCreating()
                    ->hideFromIndex()
                    ->min($minDate)
                    ->max(Carbon::today()->addWeek(1)),
            ];
        }

        return [
            ID::make('ID', 'id')
              ->hideFromIndex()
              ->readonly()
              ->sortable()
              ->canSee(function (NovaRequest $request) {
                  return !$request->user()
                                  ->hasRole(Roles::GUEST);
              }),

            BelongsTo::make('Institution', 'institution', InstitutionNovaResource::class)
                     ->displayUsing(function ($institution) {
                         return $institution ? $institution->name : '-';
                     }),

            Text::make('Name', 'name')
                ->sortable()
                ->required(),

            Boolean::make('Is Active Today', function () {
                return $this->isActive();
            })->readonly(),

            BelongsTo::make('Diet', 'diet', DietNovaResource::class)
                     ->displayUsing(function ($diet) {
                         return $diet ? $diet->name : '-';
                     }),

            Select::make('Age Group', 'age_group')
                  ->options(
                      collect(AgeGroupTypeEnum::values())
                          ->mapWithKeys(fn($value) => [$value => $value])
                          ->toArray()
                  )
                  ->displayUsingLabels()
                  ->required(),

            BooleanGroup::make('Meal Preferences')
                        ->options(
                            collect(MealTypeEnum::values())
                                ->mapWithKeys(fn($value) => [$value => $value])
                                ->toArray()
                        )
                        ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                            $rawData        = $request->input('meal_preferences', []);
                            $dataCollection = collect(json_decode($rawData, true));

                            // Filter out unchecked (false) items and validate against MealTypeEnum
                            $selectedMeals = $dataCollection
                                ->filter(fn($value) => $value === true) // Keep only `true` values
                                ->keys();

                            // Sync the filtered meal preferences after student saved
                            $model::saved(function ($student) use ($selectedMeals) {
                                $student->mealPreferences()->delete(); // Clear old preferences
                                foreach ($selectedMeals as $mealType) {
                                    $student->mealPreferences()->create(['meal_type' => $mealType]);
                                }
                            });
                        })
                        ->resolveUsing(function ($value, $model) {
                            // Fetch all meal preferences and return them as booleans for the BooleanGroup
                            $selectedMeals = $model->mealPreferences
                                ->pluck('meal_type')
                                ->map(fn($mealType) => $mealType->value)
                                ->toArray();

                            // Map enum values to booleans
                            return collect(MealTypeEnum::values())
                                ->mapWithKeys(fn($mealType) => [
                                    $mealType => in_array($mealType, $selectedMeals),
                                ])
                                ->toArray();
                        })
                        ->rules('required'),

            Date::make('Diet Certificate Valid Until', 'diet_certificate_valid_until')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->hideFromIndex(),

            Date::make('Inactive From', 'inactive_from')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->hideWhenCreating()
                ->hideFromIndex(),

            Date::make('Inactive To', 'inactive_to')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->hideWhenCreating()
                ->hideFromIndex(),

            BelongsTo::make('Updated by', 'updatedBy', UserNovaResource::class)
                     ->viewable(false)
                     ->onlyOnDetail(),

            DateTime::make('Updated At', 'updated_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->onlyOnDetail()
                    ->readonly(),

            DateTime::make('Created At', 'created_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->onlyOnDetail()
                    ->readonly(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
