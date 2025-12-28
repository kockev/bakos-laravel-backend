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
            <h3 class="underlined">Nagy Étkezés</h3>
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
                            <th colspan="7">Ellátottak</th>
                        </tr>
                        <tr>
                            <th>Ellátott neve</th>
                            <th>Diéta Típusa</th>
                            <th>Leves</th>
                            <th>Főétel</th>
                            <th>Egyéb 1</th>
                            <th>Egyéb 2</th>
                            <th>Vacsora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bigMealTypes = collect(MealTypeEnum::values())->filter(fn($meal) =>
                                $meal !== MealTypeEnum::BRUNCH->value && $meal !== MealTypeEnum::SNACK->value && $meal !== MealTypeEnum::BREAKFAST->value
                            );
                        @endphp

                        @foreach ($order->orderStudents as $orderStudent)
                            <tr class="{{ !$orderStudent->is_active ? 'crossed-out' : '' }}">
                                <td>{{ $orderStudent->student_name }}</td>
                                <td>{{ $orderStudent->diet_name }}</td>

                                @foreach($bigMealTypes as $bigMeal)
                                    @php
                                        $studentFood = $orderStudent->orderStudentFoods->firstWhere('meal_type', $bigMeal);
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
                        @foreach ($order->orderFoods->whereIn('meal_type', $bigMealTypes) as $food)
                            <tr>
                                <td>{{ MealTypeEnum::label($food->meal_type) }}</td>
                                <td>{{ $food->quantity }}</td>
                                <td>{{ $food->food_code }}</td>
                                <td>{{ $food->food_name }}</td>
                                <td>{{ $food->allergens }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content">
            <p>Tálalókonyhára érkezés időpontja: </p>
            <p>Hűtő dobozban mért hőmérséklet:</p>
            <p>Étel hőfoka érkezéskor:</p>
            <p>Átadó:</p>
            <p>Átvevő:</p>
            <p>Ellenőrizte:</p>
            <p>Megjegyzés: A diétás ételek elkészülésének, expediálására vonatkozó információk diétánként kerülnek
                dokumentálásra a főzőkonyhai Ételvizsgálati Felügyeleti Lap-on. A diétás ételek adagolása a Diétás
                Adagolási előírás szerint a főzőkonyhán történik diéta kódhoz és korcsoporthoz kötötten. Az étel 0-5 °C
                között tárolva, kizárólag a szállítás napján fogyasztható. A tálalókonyhákon a diétás ételek
                újramelegítését minden esetben el kell végezni, legalább 2 percen át tartó 72°C fok maghőmérséklet
                eléréséig. A doboz és a fedő is mikrózható.</p>
        </div>

    </body>
</html>
