<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
        ALTER TABLE blogs
PARTITION BY RANGE (TO_DAYS(publish_date)) (
    PARTITION p_past VALUES LESS THAN (TO_DAYS("2021-01-01")),
    PARTITION p_current VALUES LESS THAN (TO_DAYS("2023-01-01")),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = 'blogs';
        $statement = "ALTER TABLE {$table} REMOVE PARTITIONING";
        DB::statement($statement);
    }
};
