<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrderCleanupCommand extends Command
{
    protected $signature   = 'cleanup:orders';
    protected $description = 'Delete orders older than 1,2 year along with related media';

    public function handle()
    {
        $this->info('Starting to deleting outdated orders...');

        $orders = Order::query()
                       ->where('created_at', '<', Carbon::now()->subYear(1)->subMonths(2))
                       ->get();

        foreach ($orders as $order) {
            $this->info('Deleting order ID: ' . $order->id);

            if ($order->hasMedia()) {
                $this->info('Deleting media for order ID: ' . $order->id);
                $order->clearMediaCollection(Order::ORDER_INSTITUTION_PDF);
            }

            $order->delete();
            $this->info('Order ID: ' . $order->id . ' deleted.');
        }

        $this->info('Orders deletion finished.');
    }
}
