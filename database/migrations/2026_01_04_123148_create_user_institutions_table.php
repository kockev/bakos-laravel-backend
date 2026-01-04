<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['institution_id', 'user_id']);

            $table->index('institution_id', 'user_institutions_institution_id_index');
            $table->index('user_id', 'user_institutions_user_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_institutions');
    }
};
