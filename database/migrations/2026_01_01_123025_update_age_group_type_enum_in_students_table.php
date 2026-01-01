<?php

use App\Enums\AgeGroupTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $values = implode("','", AgeGroupTypeEnum::values());

        DB::statement("
            ALTER TABLE students MODIFY age_group ENUM('{$values}')
        ");
    }
};
