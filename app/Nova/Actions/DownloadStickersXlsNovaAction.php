<?php

namespace App\Nova\Actions;

use App\Models\KitchenOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DownloadStickersXlsNovaAction extends Action
{
    use InteractsWithQueue,
        Queueable;

    public $name = 'Download Stickers XLS';

    public $confirmText = 'Are you sure you want to download this XLS?';

    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var KitchenOrder $kitchenOrder */
        $kitchenOrder = $models->first();

        $media = $kitchenOrder->getFirstMedia(KitchenOrder::STICKERS_XLS);

        if (!$media) {
            return Action::danger("No XLS file found for the selected order.");
        }

        $fileName = $kitchenOrder->cooking_date->format('Y-m-d') . '_stickers.xls';

        return Action::download($media->getFullUrl(), $fileName);
    }
}
