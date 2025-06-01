<?php

namespace App\Providers;

use App\Nova\ActivityLogNovaResource;
use App\Nova\CompanyNovaResource;
use App\Nova\KitchenOrderNovaResource;
use App\Nova\Dashboards\Main;
use App\Nova\InstitutionNovaResource;
use App\Nova\FoodNovaResource;
use App\Nova\DietNovaResource;
use App\Nova\MenuNovaResource;
use App\Nova\OrderNovaResource;
use App\Nova\SettingsNovaResource;
use App\Nova\StudentNovaResource;
use App\Nova\UserNovaResource;
use App\Support\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::showUnreadCountInNotificationCenter();
//        Nova::withoutThemeSwitcher();
        Nova::withoutGlobalSearch();
        Nova::footer(fn() => '');

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)
                           ->icon('chart-bar')
                           ->canSee(function (NovaRequest $request) {
                               return $request->user()
                                              ->hasPermissionTo(Permissions::VIEW_DASHBOARD);
                           }),

                MenuSection::make('User Management', [
                    MenuItem::resource(UserNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_USER);
                            }),
                ])->icon('user')
                           ->collapsable(),

                MenuSection::make('General Management', [
                    MenuItem::resource(CompanyNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_COMPANY);
                            }),
                    MenuItem::resource(InstitutionNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_INSTITUTION);
                            }),
                ])->icon('library')
                           ->collapsable(),

                MenuSection::make('Student Management', [
                    MenuItem::resource(StudentNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_STUDENT);
                            }),
                ])->icon('users')
                           ->collapsable(),

                MenuSection::make('Nutrition Management', [
                    MenuItem::resource(FoodNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_FOOD);
                            }),
                    MenuItem::resource(DietNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_DIET);
                            }),
                    MenuItem::resource(MenuNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_MENU);
                            }),
                ])->icon('heart')
                           ->collapsable(),

                MenuSection::make('Order Management', [
                    MenuItem::resource(OrderNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_ORDER);
                            }),
                    MenuItem::resource(KitchenOrderNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_KITCHEN_ORDER);
                            }),
                ])->icon('clipboard-list')
                           ->collapsable(),

                MenuSection::make('Activity Log', [
                    MenuItem::resource(ActivityLogNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_ACTIVITY);
                            }),
                ])->icon('map')
                           ->collapsable(),

                MenuSection::make('Settings', [
                    MenuItem::resource(SettingsNovaResource::class)
                            ->canSee(function (NovaRequest $request) {
                                return $request->user()
                                               ->hasPermissionTo(Permissions::VIEW_ANY_SETTINGS);
                            }),
                ])->icon('cog')
                           ->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
