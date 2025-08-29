<?php

namespace App\Jobs;

use App\Models\Institution;
use App\Models\Order;
use App\Models\OrderStudent;
use App\Models\Student;
use App\Models\User;
use App\Notifications\OrderCreationNovaNotification;
use App\Services\Pdf\src\PdfService;
use App\Support\Roles;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProcessOrderCreationJob implements ShouldQueue
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

    public function handle()
    {
        $institutions = Institution::all();

        try {
            DB::transaction(function () use ($institutions) {

                foreach ($institutions as $institution) {

                    //Create order in order table (by institution)
                    $order = $institution->orders()->create([
                                                                'name'       => 'ORDER_OF_' .
                                                                    $institution->name . '_' .
                                                                    $this->orderDate->format('Y-m-d') . '_' .
                                                                    $this->orderDate->format('l'),
                                                                'order_date' => $this->orderDate,
                                                            ]);

                    $students = Student::query()
                                       ->with(['diet.menus.foods'])
                                       ->where('institution_id', $institution->id)
                                       ->get();

                    foreach ($students as $student) {

                        //After we have the order lets add students to the order and track their name, status, diet...etc
                        //Add students to the order -> order_students table
                        $orderStudentData = [
                            'student_id'                   => $student->id,
                            'order_id'                     => $order->id,
                            'student_name'                 => $student->name,
                            'diet_name'                    => $student->diet->name,
                            'age_group_name'               => $student->age_group ?? '-',
                            'is_active'                    => $student->isActive(),
                            'diet_certificate_valid_until' => $student->diet_certificate_valid_until,
                        ];

                        $orderStudent = OrderStudent::create($orderStudentData);

                        //After we have the order and we know what students we have in the order lets track what food with meal type do they have on the order date
                        //Add foods for student order -> order_student_foods table
                        $studentMeals = $student->mealPreferences;
                        foreach ($studentMeals as $meal) {
                            $diet = $student->diet;

                            // Get menu for the diet and according the given date
                            $menu = $diet->menus
                                ->filter(fn($menu) => $menu->date->toDateString() === $this->orderDate->toDateString())
                                ->first();

                            if ($menu) {
                                // Get matching food for this meal type
                                $food = $menu->foods->firstWhere('pivot.meal_type', $meal->meal_type->value);

                                // Insert order student food record
                                // If there is no food in the menu for the related meal, then cross out
                                $orderStudentFoodData = [
                                    'meal_type' => $meal->meal_type->value,
                                    'food_name' => $food->name ?? '-',
                                    'food_code' => $food->code ?? '-',
                                    'allergens' => $food->allergens ?? '-',
                                ];

                                $orderStudent->orderStudentFoods()->create($orderStudentFoodData);
                            } // If there is no menu at all for the diet meal on the given date, then cross out the food
                            else {
                                // Insert order student food record
                                $orderStudentFoodData = [
                                    'meal_type' => '-',
                                    'food_name' => '-',
                                    'food_code' => '-',
                                    'allergens' => '-',
                                ];

                                $orderStudent->orderStudentFoods()->create($orderStudentFoodData);
                            }
                        }

                    }

                    //Now we know what students, what students eat by meal type in the order, we have to count now all the foods by type for the order
                    //Count foods for the order -> order_foods table
                    $foodSummary = [];

                    // Step through all order students and their foods
                    foreach ($order->orderStudents as $orderStudent) {
                        foreach ($orderStudent->orderStudentFoods as $food) {
                            $code = $food->food_code;
                            // Don't count the quantity of the food where there was no food at all, because of missing menu
                            // But we saved the with "-" to display in the order
                            if ($food->food_code === '-') {
                                continue;
                            }

                            if (!isset($foodSummary[$code])) {
                                $foodSummary[$code] = [
                                    'food_code' => $food->food_code,
                                    'food_name' => $food->food_name,
                                    'meal_type' => $food->meal_type,
                                    'allergens' => $food->allergens,
                                    'quantity'  => 1,
                                ];
                            } else {
                                $foodSummary[$code]['quantity']++;
                            }
                        }
                    }

                    // Save to OrderFood
                    foreach ($foodSummary as $summary) {
                        $order->orderFoods::create([
                                                       'meal_type' => $summary['meal_type'],
                                                       'food_code' => $summary['food_code'],
                                                       'food_name' => $summary['food_name'],
                                                       'allergens' => $summary['allergens'],
                                                       'quantity'  => $summary['quantity'],
                                                   ]);
                    }

                    $order->load([
                                     'orderStudents.orderStudentFoods',
                                     'orderFoods',
                                 ]);

                    // Generate and attach PDF - separate small and big meals
                    $bigMealOrderHtmlContent = view('pdf.order_big_meal', compact('order'))->render();
                    $bigMealPdfFile          = $this->pdfService->generatePdf($bigMealOrderHtmlContent);
                    $order->addMediaFromStream($bigMealPdfFile)
                          ->usingFileName('order_big_meal_' . $order->uuid . '.pdf')
                          ->toMediaCollection(Order::ORDER_INSTITUTION_BIG_MEAL_PDF);

                    $smallMealOrderHtmlContent = view('pdf.order_small_meal', compact('order'))->render();
                    $smallMealPdfFile          = $this->pdfService->generatePdf($smallMealOrderHtmlContent);
                    $order->addMediaFromStream($smallMealPdfFile)
                          ->usingFileName('order_small_meal_' . $order->uuid . '.pdf')
                          ->toMediaCollection(Order::ORDER_INSTITUTION_SMALL_MEAL_PDF);
                }

            });
        } catch (\Throwable $e) {
            Log::error('Error during order creation!', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, "Error during order creation!");
        }

        $admins = User::role([Roles::SUPER_ADMIN, Roles::ADMIN])->get();

        $admins->each(function (User $user) {
            $user->notify(
                new OrderCreationNovaNotification()
            );
        });
    }
}
