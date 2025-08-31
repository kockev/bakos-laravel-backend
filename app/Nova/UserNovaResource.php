<?php

namespace App\Nova;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Permission\Models\Role;

class UserNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Users';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'User';
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

            BelongsTo::make('Institution', 'institution', InstitutionNovaResource::class)
                     ->displayUsing(function ($institution) {
                         return $institution ? $institution->name : '-';
                     }),

            Text::make('Email', 'email')
                ->sortable(),

            Password::make('Password', 'password')
                    ->onlyOnForms(),

            Text::make('Suggested Secure Password')
                ->default(function ($request) {
                    return Str::random(15);
                })
                ->readonly()
                ->onlyOnForms()
                ->help('Use this if you want to assign a secure password.'),

            Text::make('Role', function () {
                return $this->roles->first()->name ?? '-';
            })
                ->sortable()
                ->onlyOnIndex(),

            Text::make('Role', function () {
                return $this->roles->first()->name ?? '-';
            })
                ->onlyOnDetail(),

            Select::make('Role')
                  ->options(Role::all()->pluck('name', 'id')->toArray())
                  ->displayUsingLabels()
                  ->sortable()
                  ->onlyOnForms()
                  ->resolveUsing(function ($value, $model) {
                      return optional($model->roles->first())->id;
                  })
                  ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                      $model->save();
                      $model->roles()->sync([$request->get($requestAttribute)]);
                  }),

            BelongsTo::make('Updated by', 'updatedBy', UserNovaResource::class)
                     ->viewable(false)
                     ->onlyOnDetail(),

            Text::make('Reset two-factor auth', function () {
                if (auth()->id() === $this->id) {
                    $route      = route('nova.google2fa.destroy');
                    $buttonText = __('nova-google2fa::2fa-auth.actions.reset');

                    return "<a href='{$route}' class='class=shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900'>
                            {$buttonText}</a>";
                }
            })->asHtml()
                ->onlyOnDetail(),

            DateTime::make('Updated At', 'updated_at')
                    ->onlyOnDetail()
                    ->readonly(),

            DateTime::make('Created At', 'created_at')
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
