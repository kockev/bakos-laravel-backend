<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_inactive_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('inactive_from');
            $table->date('inactive_to');
            $table->timestamps();

            $table->index(['student_id', 'inactive_from', 'inactive_to'], 'index_student_inactive_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_inactive_periods');
    }
};
