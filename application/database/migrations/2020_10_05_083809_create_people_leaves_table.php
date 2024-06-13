<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('reference')->nullable();
            $table->string('idno')->nullable();
            $table->string('employee')->nullable();
            $table->integer('typeid')->nullable();
            $table->string('type')->nullable();
            $table->date('leavefrom')->nullable();
            $table->date('leaveto')->nullable();
            $table->date('returndate')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->integer('archived')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_leaves');
    }
}
