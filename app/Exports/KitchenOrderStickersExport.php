<?php

namespace App\Exports;

use App\Enums\AgeGroupTypeEnum;
use App\Enums\MealTypeEnum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KitchenOrderStickersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected Collection $orders
    )
    {
    }

    public function collection()
    {
        $orderStudentFoods = collect();

        $allowedMealTypes = [
            MealTypeEnum::LUNCH_SOUP->value,
            MealTypeEnum::LUNCH_MAIN->value,
            MealTypeEnum::LUNCH_OTHER_1->value,
            MealTypeEnum::LUNCH_OTHER_2->value,
        ];

        foreach ($this->orders as $order) {
            foreach ($order->orderStudents as $orderStudent) {
                foreach ($orderStudent->orderStudentFoods as $orderStudentFood) {
                    if ($orderStudentFood->food_code !== '-' &&
                        in_array($orderStudentFood->meal_type, $allowedMealTypes)) {
                        $orderStudentFoods->push($orderStudentFood);
                    }
                }
            }
        }

        // Define meal type order
        $mealTypeOrder = [
            MealTypeEnum::LUNCH_SOUP->value => 1,
            MealTypeEnum::LUNCH_MAIN->value => 2,
            MealTypeEnum::LUNCH_OTHER_1->value => 3,
            MealTypeEnum::LUNCH_OTHER_2->value => 4,
        ];

        // Define age group order
        $ageGroupOrder = [
            AgeGroupTypeEnum::KINDERGARTEN->value => 1,
            AgeGroupTypeEnum::PRIMARY_SCHOOL->value => 2,
            AgeGroupTypeEnum::HIGH_SCHOOL->value => 3,
        ];

        // Sort by: age group -> diet name -> meal type
        return $orderStudentFoods->sortBy([
                                              function ($orderStudentFood) use ($ageGroupOrder) {
                                                  $orderStudent = $orderStudentFood->orderStudent ?? $orderStudentFood->orderStudent()->first();
                                                  $ageGroupName = $orderStudent->age_group_name ?? '';
                                                  return $ageGroupOrder[$ageGroupName] ?? 999;
                                              },
                                              function ($orderStudentFood) {
                                                  $orderStudent = $orderStudentFood->orderStudent ?? $orderStudentFood->orderStudent()->first();
                                                  return $orderStudent->diet_name ?? '';
                                              },
                                              function ($orderStudentFood) use ($mealTypeOrder) {
                                                  return $mealTypeOrder[$orderStudentFood->meal_type] ?? 999;
                                              },
                                          ])->values();
    }

    public function headings(): array
    {
        return [
            'Kód nyomtat',
            'Név',
            'Dátum',
            'Ellátott neve',
        ];
    }

    public function map($orderStudentFood): array
    {
        $orderStudent = $orderStudentFood->orderStudent ?? $orderStudentFood->orderStudent()->first();

        return [
            $orderStudentFood->food_code,
            $orderStudentFood->food_name,
            $orderStudentFood->food_expiration_date ? $orderStudentFood->food_expiration_date->format('Y-m-d') : '-',
            $orderStudent->student_name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
