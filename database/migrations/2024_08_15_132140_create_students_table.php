<?php

use App\Enums\AgeGroupTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('institution_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->enum('age_group', AgeGroupTypeEnum::values());
            $table->foreignId('diet_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('diet_certificate_valid_until')->nullable();
            $table->date('inactive_from')->nullable();
            $table->date('inactive_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
