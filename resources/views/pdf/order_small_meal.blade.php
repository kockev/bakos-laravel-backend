@php use App\Enums\MealTypeEnum; @endphp
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            .header {
                text-align: center;
                margin-bottom: 40px;
            }

            .header h1 {
                font-size: 20px;
                margin: 0;
            }

            .header p {
                font-size: 10px;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                border: 1px solid #b2b2b2;
            }

            .table th, .table td {
                padding: 8px;
                text-align: left;
                border: 1px solid #b2b2b2;
            }

            .table th {
                background-color: #e0e0e0;
                font-size: 12px;
                text-align: left;
            }

            .student-container {
                display: block;
                width: 100%;
                margin-bottom: 20px;
            }

            .student-container .content {
                width: 100%;
            }

            .meal-summary-container {
                display: block;
                width: 100%;
                margin-bottom: 20px;
            }

            .meal-summary-container .content {
                width: 100%;
            }

            .title-row th {
                background-color: #414141;
                color: #ffffff;
                text-align: center;
                font-size: 12px;
            }

            .crossed-out td {
                text-decoration: line-through;
            }

            .underlined {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>

        <div class="header">
            <h1>Diétás Ételszállító Lap</h1>
            <h2>{{ $order->institution->name }}</h2>
            <h3 class="underlined">Kis Étkezés</h3>
        </div>

        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Szállító címe:</th>
                        <th>Megrendelő címe:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bakos és Társai Bt. 6000 Kecskemét, Szent Imre utca 9.</td>
                        <td>{{ $order->institution->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="student-container">
            <div class="content">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th colspan="4">Ellátottak</th>
                        </tr>
                        <tr>
                            <th>Ellátott neve</th>
                            <th>Diéta Típusa</th>
                            <th>Tízórai</th>
                            <th>Uzsonna</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $smallMealTypes = collect(MealTypeEnum::values())->filter(fn($meal) =>
                                $meal == MealTypeEnum::BRUNCH->value || $meal == MealTypeEnum::SNACK->value
                            );
                        @endphp

                        @foreach ($order->orderStudents as $orderStudent)
                            <tr class="{{ !$orderStudent->is_active ? 'crossed-out' : '' }}">
                                <td>{{ $orderStudent->student_name }}</td>
                                <td>{{ $orderStudent->diet_name }}</td>

                                @foreach($smallMealTypes as $smallMeal)
                                    @php
                                        $studentFood = $orderStudent->orderStudentFoods->firstWhere('meal_type', $smallMeal);
                                    @endphp
                                    <td>{{ $studentFood ? $studentFood->food_code : '-' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="meal-summary-container">
            <div class="content">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th colspan="5">Ételek</th>
                        </tr>
                        <tr>
                            <th>Típus</th>
                            <th>Mennyiség</th>
                            <th>Kód</th>
                            <th>Megnevezés</th>
                            <th>Allergének</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(MealTypeEnum::values() as $meal)
                            @foreach ($order->orderFoods as $food)
                                @if($meal == $food->meal_type)
                                    <tr>
                                        <td>{{ $food->meal_type }}</td>
                                        <td>{{ $food->quantity }}</td>
                                        <td>{{ $food->food_code }}</td>
                                        <td>{{ $food->food_name }}</td>
                                        <td>{{ $food->allergens }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </body>
</html>
