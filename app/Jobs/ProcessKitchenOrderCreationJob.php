<?php

namespace App\Jobs;

use App\Models\KitchenOrder;
use App\Models\Order;
use App\Models\User;
use App\Notifications\KitchenOrderCreationNovaNotification;
use App\Services\Pdf\src\PdfService;
use App\Support\Roles;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProcessKitchenOrderCreationJob
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    public function __construct(
        protected Carbon     $orderDate,
        protected PdfService $pdfService
    )
    {
    }

    public function handle(): void
    {
        // Get the latest orders for the given day, unique institution
        $orders = Order::query()
                       ->where('order_date', $this->orderDate->format('Y-m-d'))
                       ->orderBy('created_at')
                       ->get()
                       ->unique('institution_id')
                       ->values();

        try {
            DB::transaction(function () use ($orders) {

                $kitchenOrder = KitchenOrder::create([
                                                         'name'         => 'KITCHEN_ORDER_' .
                                                             $this->orderDate->format('Y-m-d') . '_' .
                                                             $this->orderDate->format('l'),
                                                         'cooking_date' => $this->orderDate->format('Y-m-d'),
                                                     ]);

                $foodSummary = [];
                foreach ($orders as $order) {

                    foreach ($order->orderFoods as $food) {

                        if (!isset($foodSummary[$food->food_code])) {
                            $foodSummary[$food->food_code] = [
                                'food_code' => $food->food_code,
                                'food_name' => $food->food_name,
                                'meal_type' => $food->meal_type,
                                'allergens' => $food->allergens,
                                'quantity'  => $food->quantity,
                            ];
                        } else {
                            $foodSummary[$food->food_code]['quantity'] = $foodSummary[$food->food_code]['quantity'] + $food->quantity;
                        }

                    }
                }

                // Save to OrderFood
                foreach ($foodSummary as $summary) {
                    $kitchenOrder->kitchenOrderFoods()->create([
                                                                   'meal_type' => $summary['meal_type'],
                                                                   'food_name' => $summary['food_name'],
                                                                   'food_code' => $summary['food_code'],
                                                                   'allergens' => $summary['allergens'],
                                                                   'quantity'  => $summary['quantity'],
                                                               ]);
                }

                $kitchenOrder->load(['kitchenOrderFoods']);

                // Generate and attach PDF - separate small and big meals
                $bigMealKitchenOrderHtmlContent = view('pdf.kitchen_order_big_meal', compact('kitchenOrder'))->render();
                $bigMealPdfFile                 = $this->pdfService->generatePdf($bigMealKitchenOrderHtmlContent);
                $kitchenOrder->addMediaFromStream($bigMealPdfFile)
                             ->usingFileName('kitchen_order_big_meal_' . $kitchenOrder->uuid . '.pdf')
                             ->toMediaCollection(KitchenOrder::KITCHEN_ORDER_BIG_MEAL_PDF);

                $smallMealKitchenOrderHtmlContent = view('pdf.kitchen_order_small_meal', compact('kitchenOrder'))->render();
                $smallMealPdfFile                 = $this->pdfService->generatePdf($smallMealKitchenOrderHtmlContent);
                $kitchenOrder->addMediaFromStream($smallMealPdfFile)
                             ->usingFileName('kitchen_order_small_meal_' . $kitchenOrder->uuid . '.pdf')
                             ->toMediaCollection(KitchenOrder::KITCHEN_ORDER_SMALL_MEAL_PDF);

            });
        } catch (\Throwable $e) {
            Log::error('Error during kitchen order creation!', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, "Error during kitchen order creation!");
        }

        $admins = User::role([Roles::SUPER_ADMIN, Roles::ADMIN])->get();

        $admins->each(function (User $user) {
            $user->notify(
                new KitchenOrderCreationNovaNotification()
            );
        });
    }
}
