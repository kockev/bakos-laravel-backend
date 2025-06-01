<?php

namespace App\Nova;

use App\Models\Company;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class CompanyNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Company::class;

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
    public static $group = 'Company Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'address',
        'contact_person',
        'email',
        'phone',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Companies';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Company';
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
              ->hideFromIndex()
              ->readonly()
              ->sortable(),

            Text::make('Name', 'name')
                ->sortable(),

            Text::make('Address', 'address')
                ->sortable(),

            Text::make('Contact Person', 'contact_person')
                ->hideFromIndex()
                ->sortable(),

            Text::make('Phone', 'phone')
                ->hideFromIndex()
                ->sortable(),

            Text::make('Email', 'email')
                ->sortable(),

            BelongsTo::make('Updated by', 'updatedBy', UserNovaResource::class)
                     ->viewable(false)
                     ->onlyOnDetail(),

            DateTime::make('Updated At', 'updated_at')
                    ->onlyOnDetail()
                    ->readonly(),

            DateTime::make('Created At', 'created_at')
                    ->onlyOnDetail()
                    ->readonly(),

            HasMany::make('Institutions', 'institutions', InstitutionNovaResource::class),
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
