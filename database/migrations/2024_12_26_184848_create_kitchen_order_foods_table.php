<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('kitchen_order_foods', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('kitchen_order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('meal_type');
            $table->string('food_code');
            $table->string('food_name');
            $table->string('allergens')->nullable();
            $table->integer('quantity');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitchen_order_foods');
    }
};
