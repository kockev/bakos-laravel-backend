<?php

namespace App\Nova;

use App\Models\Institution;
use App\Models\User;
use App\Support\Roles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class InstitutionNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Institution::class;

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
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Institutions';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Institution';
    }

    /**
     * Modify the index query to filter institutions based on the user's institution_id.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        /** @var User $user */
        $user = $request->user();
        if ($user->hasRole(Roles::GUEST)) {
            $institutionIds = $user->institutions()->pluck('institutions.id');

            return $query->whereIn('id', $institutionIds);
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
        return [
            ID::make('ID', 'id')
              ->hideFromIndex()
              ->readonly()
              ->sortable(),

            Text::make('Name', 'name')
                ->sortable(),

            BelongsTo::make('Company', 'company', CompanyNovaResource::class)
                     ->displayUsing(function ($company) {
                         return $company ? $company->name : '-';
                     }),

            Text::make('Address', 'address')
                ->sortable(),

            BelongsTo::make('Updated by', 'updatedBy', UserNovaResource::class)
                     ->viewable(false)
                     ->onlyOnDetail()
                     ->canSee(function (NovaRequest $request) {
                         return !$request->user()
                                         ->hasRole(Roles::GUEST);
                     }),

            DateTime::make('Updated At', 'updated_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->onlyOnDetail()
                    ->readonly(),

            DateTime::make('Created At', 'created_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->onlyOnDetail()
                    ->readonly(),

            HasMany::make('Students', 'students', StudentNovaResource::class),
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
