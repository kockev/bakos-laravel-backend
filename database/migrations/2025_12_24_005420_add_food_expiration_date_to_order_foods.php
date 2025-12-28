<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_foods', function (Blueprint $table) {
            $table->date('food_expiration_date')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('order_foods', function (Blueprint $table) {
            $table->dropColumn('food_expiration_date');
        });
    }
};
