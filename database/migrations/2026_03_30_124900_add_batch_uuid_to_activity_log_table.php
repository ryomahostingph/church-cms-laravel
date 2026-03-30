<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = config('activitylog.table_name', 'activity_log');

        if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'batch_uuid')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->uuid('batch_uuid')->nullable()->after('causer_type');
            $table->index('batch_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('activitylog.table_name', 'activity_log');

        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'batch_uuid')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropIndex(['batch_uuid']);
            $table->dropColumn('batch_uuid');
        });
    }
};
