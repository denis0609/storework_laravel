<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('mi')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('emailaddress')->nullable();
            $table->string('civilstatus')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('mobileno')->nullable();
            $table->string('birthday')->nullable();
            $table->string('nationalid')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('homeaddress')->nullable();
            $table->string('employmentstatus')->nullable();
            $table->string('employmenttype')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
