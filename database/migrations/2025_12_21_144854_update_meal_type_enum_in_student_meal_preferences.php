<?php

use App\Enums\MealTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $values = implode("','", MealTypeEnum::values());

        DB::statement("
            ALTER TABLE student_meal_preferences
            MODIFY meal_type ENUM('{$values}')
        ");
    }
};
