<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropOldPrayerTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('prayer_responses');
        Schema::dropIfExists('prayer_requests');
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        // Intentionally empty — clean-slate approach, old tables not restored
    }
}
