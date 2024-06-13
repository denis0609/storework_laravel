<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('reference')->nullable();
            $table->string('idno')->nullable();
            $table->string('employee')->nullable();
            $table->text('intime')->nullable();
            $table->text('outime')->nullable();
            $table->date('datefrom')->nullable();
            $table->date('dateto')->nullable();
            $table->integer('hours')->nullable();
            $table->string('restday')->nullable();
            $table->integer('archive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_schedules');
    }
}
