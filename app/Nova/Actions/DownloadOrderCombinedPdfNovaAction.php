<?php

namespace App\Nova\Actions;

use App\Models\Order;
use App\Services\Pdf\PdfServiceInterface;
use Carbon\Carbon;
use Datomatic\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class DownloadOrderCombinedPdfNovaAction extends DetachedAction
{
    use InteractsWithQueue,
        Queueable;

    protected PdfServiceInterface $pdfService;

    public $name = 'Download Combined PDF';

    public $confirmText = 'Choose the date and meal type to download the combined PDF:';

    public $confirmButtonText = 'Confirm';

    public function __construct()
    {
        $this->pdfService = app(PdfServiceInterface::class);
    }

    public function handle(ActionFields $fields)
    {
        $date     = Carbon::parse($fields->get('date'));
        $mealType = $fields->get('meal_type');

        $mealTypeLabels = [
            Order::ORDER_INSTITUTION_BIG_MEAL_PDF   => 'big-meal',
            Order::ORDER_INSTITUTION_SMALL_MEAL_PDF => 'small-meal',
        ];

        $mealLabel = $mealTypeLabels[$mealType];

        $latestOrders = Order::query()
                             ->whereDate('created_at', $date)
                             ->orderBy('created_at', 'desc')
                             ->get()
                             ->unique('institution_id');

        if ($latestOrders->isEmpty()) {
            return DetachedAction::danger('No available order for today!');
        }

        $pdfPaths = [];

        foreach ($latestOrders as $order) {
            $orderPdfPaths = $order->getMedia($mealType)
                                   ->map(function ($media) {
                                       return $media->getPath();
                                   })
                                   ->toArray();

            $pdfPaths = array_merge($pdfPaths, $orderPdfPaths);
        }

        // Ensure the combined directory exists
        if (!Storage::disk('public')->exists('combined')) {
            Storage::disk('public')->makeDirectory('combined');
        }

        // Generate combined PDF path
        $combinedPdfPath = Storage::disk('public')
                                  ->path('combined/combined_orders_' . $mealLabel . '_' . $date->format('Y-m-d') . '.pdf');

        // Concatenate PDFs
        $this->pdfService->concatenatePdfs($pdfPaths, $combinedPdfPath);

        $downloadUrl = Storage::disk('public')
                              ->url('combined/combined_orders_' . $mealLabel . '_' . $date->format('Y-m-d') . '.pdf');

        return DetachedAction::download($downloadUrl, 'combined_orders_' . $mealLabel . '_' . $date->format('Y-m-d') . '.pdf');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Date::make('Date:')
                ->rules('required', 'date'),

            Select::make('Meal Type', 'meal_type')
                  ->options([
                                Order::ORDER_INSTITUTION_BIG_MEAL_PDF   => 'Big Meal',
                                Order::ORDER_INSTITUTION_SMALL_MEAL_PDF => 'Small Meal',
                            ])
                  ->rules('required')
                  ->displayUsingLabels(),
        ];
    }
}
