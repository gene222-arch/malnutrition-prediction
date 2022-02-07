<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonForVisitToCheckUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_ups', function (Blueprint $table) {
            $table->text('reason_for_visit')->after('weight_in_pounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_ups', function (Blueprint $table) {
            $table->dropColumn('reason_for_visit');
        });
    }
}
