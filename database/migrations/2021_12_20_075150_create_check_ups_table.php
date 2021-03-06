<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id');
            $table->string('patient_name');
            $table->unsignedDecimal('height_in_cm')->default(0);
            $table->unsignedDecimal('height_in_inches')->default(0);
            $table->unsignedDecimal('weight_in_kg')->default(0);
            $table->unsignedDecimal('weight_in_pounds')->default(0);
            $table->timestamp('visited_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('check_up_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_up_id');
            $table->foreignId('malnutrition_symptom_id');

            $table->unique(['check_up_id', 'malnutrition_symptom_id']);
        });

        Schema::create('check_up_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_up_id');
            $table->unsignedDecimal('bmi')->default(0);
            $table->string('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_ups');
    }
}
