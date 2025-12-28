<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indexes for orders table
        Schema::table('orders', function (Blueprint $table) {
            // Index for filtering by order_date (used in ProcessKitchenOrderCreationJob)
            if (!$this->indexExists('orders', 'orders_order_date_index')) {
                $table->index('order_date', 'orders_order_date_index');
            }

            // Composite index for institution_id + order_date queries
            if (!$this->indexExists('orders', 'orders_institution_order_date_index')) {
                $table->index(['institution_id', 'order_date'], 'orders_institution_order_date_index');
            }
        });

        // Indexes for students table
        Schema::table('students', function (Blueprint $table) {
            // Index for filtering by institution_id (used frequently)
            if (!$this->indexExists('students', 'students_institution_id_index')) {
                $table->index('institution_id', 'students_institution_id_index');
            }

            // Composite index for institution_id + diet_id queries
            if (!$this->indexExists('students', 'students_institution_diet_index')) {
                $table->index(['institution_id', 'diet_id'], 'students_institution_diet_index');
            }
        });

        // Indexes for order_students table
        Schema::table('order_students', function (Blueprint $table) {
            // Index for order_id (used when loading order with students)
            if (!$this->indexExists('order_students', 'order_students_order_id_index')) {
                $table->index('order_id', 'order_students_order_id_index');
            }

            // Index for student_id (for reverse lookups)
            if (!$this->indexExists('order_students', 'order_students_student_id_index')) {
                $table->index('student_id', 'order_students_student_id_index');
            }
        });

        // Indexes for order_student_foods table
        Schema::table('order_student_foods', function (Blueprint $table) {
            // Index for order_student_id (used when loading order students with foods)
            if (!$this->indexExists('order_student_foods', 'order_student_foods_order_student_id_index')) {
                $table->index('order_student_id', 'order_student_foods_order_student_id_index');
            }

            // Index for food_code (used in summary calculations)
            if (!$this->indexExists('order_student_foods', 'order_student_foods_food_code_index')) {
                $table->index('food_code', 'order_student_foods_food_code_index');
            }
        });

        // Indexes for order_foods table
        Schema::table('order_foods', function (Blueprint $table) {
            // Index for order_id (used when loading order foods)
            if (!$this->indexExists('order_foods', 'order_foods_order_id_index')) {
                $table->index('order_id', 'order_foods_order_id_index');
            }

            // Index for food_code (used in kitchen order aggregation)
            if (!$this->indexExists('order_foods', 'order_foods_food_code_index')) {
                $table->index('food_code', 'order_foods_food_code_index');
            }
        });

        // Indexes for menus table
        Schema::table('menus', function (Blueprint $table) {
            // Index for date (used when filtering menus by date)
            if (!$this->indexExists('menus', 'menus_date_index')) {
                $table->index('date', 'menus_date_index');
            }
        });

        // Indexes for menu_foods pivot table
        Schema::table('menu_foods', function (Blueprint $table) {
            // Composite index for menu_id + meal_type (used when finding food by meal type)
            if (!$this->indexExists('menu_foods', 'menu_foods_menu_meal_index')) {
                $table->index(['menu_id', 'meal_type'], 'menu_foods_menu_meal_index');
            }

            // Index for food_id (for reverse lookups)
            if (!$this->indexExists('menu_foods', 'menu_foods_food_id_index')) {
                $table->index('food_id', 'menu_foods_food_id_index');
            }
        });

        // Indexes for diet_menus pivot table
        Schema::table('diet_menus', function (Blueprint $table) {
            // Index for diet_id (used when loading diet menus)
            if (!$this->indexExists('diet_menus', 'diet_menus_diet_id_index')) {
                $table->index('diet_id', 'diet_menus_diet_id_index');
            }

            // Index for menu_id (for reverse lookups)
            if (!$this->indexExists('diet_menus', 'diet_menus_menu_id_index')) {
                $table->index('menu_id', 'diet_menus_menu_id_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_order_date_index');
            $table->dropIndex('orders_institution_order_date_index');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('students_institution_id_index');
            $table->dropIndex('students_institution_diet_index');
        });

        Schema::table('order_students', function (Blueprint $table) {
            $table->dropIndex('order_students_order_id_index');
            $table->dropIndex('order_students_student_id_index');
        });

        Schema::table('order_student_foods', function (Blueprint $table) {
            $table->dropIndex('order_student_foods_order_student_id_index');
            $table->dropIndex('order_student_foods_food_code_index');
        });

        Schema::table('order_foods', function (Blueprint $table) {
            $table->dropIndex('order_foods_order_id_index');
            $table->dropIndex('order_foods_food_code_index');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex('menus_date_index');
        });

        Schema::table('menu_foods', function (Blueprint $table) {
            $table->dropIndex('menu_foods_menu_meal_index');
            $table->dropIndex('menu_foods_food_id_index');
        });

        Schema::table('diet_menus', function (Blueprint $table) {
            $table->dropIndex('diet_menus_diet_id_index');
            $table->dropIndex('diet_menus_menu_id_index');
        });
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();

        $result = $connection->select(
            "SELECT COUNT(*) as count
             FROM information_schema.statistics
             WHERE table_schema = ?
             AND table_name = ?
             AND index_name = ?",
            [$databaseName, $table, $index]
        );

        return $result[0]->count > 0;
    }
};
