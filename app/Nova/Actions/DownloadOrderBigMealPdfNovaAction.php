<?php

namespace App\Nova\Actions;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DownloadOrderBigMealPdfNovaAction extends Action
{
    use InteractsWithQueue,
        Queueable;

    public $name = 'Download Big Meal PDF';

    public $confirmText = 'Are you sure you want to download this PDF?';

    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var Order $order */
        $order = $models->first();

        $media = $order->getFirstMedia(Order::ORDER_INSTITUTION_BIG_MEAL_PDF);

        if (!$media) {
            return Action::danger("No PDF file found for the selected order.");
        }

        $fileName = $order->institution->name . '_' . $order->order_date->format('Y-m-d') . '_order_BIG.pdf';

        return Action::download($media->getFullUrl(), $fileName);
    }
}
