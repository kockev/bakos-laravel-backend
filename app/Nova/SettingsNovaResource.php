<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\LaravelSettings\Models\SettingsProperty;

class SettingsNovaResource extends Resource
{
    /**
     * @var SettingsProperty
     */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = SettingsProperty::class;

    public static function label(): string
    {
        return 'Configurations';
    }

    public static function singularLabel(): string
    {
        return 'Configuration';
    }

    public function title(): string
    {
        return $this->resource->name;
    }

    public static $search = [
        'group',
        'name',
    ];

    public static array $indexDefaultOrder = [
        'id' => 'asc',
    ];

    public static function redirectAfterUpdate(NovaRequest $request, $resource): string
    {
        return '/resources/' . static::uriKey();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make('ID', 'id')
              ->sortable(),

            Text::make('Group', 'group')
                ->sortable(),

            Text::make('Name', 'name')
                ->sortable(),

            Text::make('Value', 'payload')
                ->sortable(),

            Boolean::make('Locked', 'locked')
                   ->sortable(),
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
