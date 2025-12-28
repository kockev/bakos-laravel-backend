<?php

namespace App\Nova;

use App\Enums\MealTypeEnum;
use App\Models\Menu;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MenuNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Menu::class;

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
    public static $group = 'Nutrition Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'description',
        'date',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Menus';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Menu';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make('ID', 'id')
              ->hideFromIndex()
              ->readonly()
              ->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->required(),

            Text::make('Description', 'description')
                ->hideFromIndex(),

            Date::make('Date', 'date')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->required(),

            Number::make('Foods Expiration Period (Days)', 'foods_expiration_period_in_days')
                  ->help('Number of days after the foods in the menu expire')
                  ->min(0)
                  ->default(0)
                  ->textAlign('left'),

            Date::make('Foods Expiration Date', function () {
                return $this->date->copy()->addDays($this->foods_expiration_period_in_days)->toDateString();
            })
                ->displayUsing(function ($value, $resource) {
                    return $resource->date->copy()->addDays($resource->foods_expiration_period_in_days)->toDateString();
                })
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsToMany::make('Assigned Foods', 'foods', FoodNovaResource::class)
                         ->fields(function () {
                             return [
                                 Select::make('Meal Type', 'meal_type')
                                       ->options(
                                           collect(MealTypeEnum::values())
                                               ->mapWithKeys(fn($value) => [$value => $value])
                                               ->toArray()
                                       )
                                       ->displayUsingLabels()
                                       ->required(),
                             ];
                         })
                         ->required(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
