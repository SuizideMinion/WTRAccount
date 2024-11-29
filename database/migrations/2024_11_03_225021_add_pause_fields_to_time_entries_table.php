<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPauseFieldsToTimeEntriesTable extends Migration
{
    public function up()
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->timestamp('paused_at')->nullable(); // Timestamp when paused
            $table->integer('paused_duration')->default(0); // Total paused duration in seconds
        });
    }

    public function down()
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->dropColumn(['paused_at', 'paused_duration']);
        });
    }
}
