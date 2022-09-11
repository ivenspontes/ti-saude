<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_insurance_patient', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('health_insurance_id');

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('health_insurance_id')->references('id')->on('health_insurances');

            $table->unsignedInteger('contract_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_insurance_patient');
    }
};
