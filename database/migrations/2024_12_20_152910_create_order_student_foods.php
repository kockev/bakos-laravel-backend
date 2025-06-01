<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_student_foods', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('order_student_id')->constrained()->cascadeOnDelete();
            $table->string('meal_type');
            $table->string('food_name');
            $table->string('food_code');
            $table->text('allergens')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_student_meals');
    }
};
