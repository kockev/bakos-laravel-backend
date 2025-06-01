<?php

namespace App\Nova\Actions;

use App\Models\KitchenOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DownloadKitchenOrderSmallMealPdfNovaAction extends Action
{
    use InteractsWithQueue,
        Queueable;

    public $name = 'Download Small Meal PDF';

    public $confirmText = 'Are you sure you want to download this PDF?';

    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var KitchenOrder $kitchenOrder */
        $kitchenOrder = $models->first();

        $media = $kitchenOrder->getFirstMedia(KitchenOrder::KITCHEN_ORDER_SMALL_MEAL_PDF);

        if (!$media) {
            return Action::danger("No PDF file found for the selected order.");
        }

        $fileName = $kitchenOrder->cooking_date->format('Y-m-d') . '_kitchen_order_SMALL.pdf';

        return Action::download($media->getFullUrl(), $fileName);
    }
}
