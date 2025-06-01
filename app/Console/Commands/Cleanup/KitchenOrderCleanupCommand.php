<?php

namespace App\Console\Commands\Cleanup;

use App\Models\KitchenOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class KitchenOrderCleanupCommand extends Command
{
    protected $signature   = 'cleanup:kitchen-orders';
    protected $description = 'Delete cooking plans older than 1,2 year along with related media';

    public function handle()
    {
        $this->info('Starting to delete outdated kitchen orders...');

        $kitchenOrders = KitchenOrder::query()
                                     ->where('created_at', '<', Carbon::now()->subYear()->subMonths(2))
                                     ->get();

        foreach ($kitchenOrders as $order) {
            $this->info('Deleting Kitchen Order ID: ' . $order->id);

            if ($order->hasMedia()) {
                $this->info('Deleting media for cooking plan ID: ' . $order->id);
                $order->clearMediaCollection(KitchenOrder::KITCHEN_ORDER_PDF);
            }

            $order->delete();
            $this->info('Kitchen Order ID: ' . $order->id . ' has been deleted.');
        }

        $this->info('Kitchen orders deletion finished.');
    }
}
