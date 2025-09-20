<?php

namespace App\Nova;

use App\Models\Order;
use App\Nova\Actions\CreateOrderNovaAction;
use App\Nova\Actions\DownloadOrderBigMealPdfNovaAction;
use App\Nova\Actions\DownloadOrderCombinedPdfNovaAction;
use App\Nova\Actions\DownloadOrderSmallMealPdfNovaAction;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Order::class;

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
    public static $group = 'Order Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'uuid',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Orders';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Order';
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
            Text::make('Name', 'name')
                ->sortable(),

            BelongsTo::make('Institution', 'institution', InstitutionNovaResource::class)
                     ->displayUsing(function ($institution) {
                         return $institution ? $institution->name : '-';
                     }),

            BelongsTo::make('Updated by', 'updatedBy', UserNovaResource::class)
                     ->viewable(false)
                     ->onlyOnDetail(),

            Date::make('Order date', 'order_date')
                ->displayUsing(fn(?Carbon $date) => $date?->toDateString())
                ->readonly()
                ->hideWhenCreating(),

            DateTime::make('Updated At', 'updated_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->onlyOnDetail()
                    ->readonly(),

            DateTime::make('Created At', 'created_at')
                    ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                    ->readonly(),

            HasMany::make('Students', 'orderStudents', OrderStudentNovaResource::class),

            HasMany::make("Food's Quantity", 'orderFoods', OrderFoodNovaResource::class),

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
        return [
            DownloadOrderCombinedPdfNovaAction::make()
                                              ->icon('download')
                                              ->extraClasses('bg-primary-500 text-white hover:black'),

            CreateOrderNovaAction::make()
                                 ->icon('plus')
                                 ->extraClasses('bg-primary-500 text-white hover:black'),

            DownloadOrderBigMealPdfNovaAction::make(),

            DownloadOrderSmallMealPdfNovaAction::make(),
        ];
    }
}
