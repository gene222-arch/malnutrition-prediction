<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMalnourishmentLevelToCheckUpResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_up_results', function (Blueprint $table) {
            $table->string('malnourishment_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_up_results', function (Blueprint $table) {
            $table->dropColumn('malnourishment_level');
        });
    }
}
