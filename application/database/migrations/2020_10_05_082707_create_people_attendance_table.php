<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('reference')->nullable();
            $table->string('idno')->nullable();
            $table->date('date')->nullable();
            $table->string('employee')->nullable();
            $table->string('timein')->nullable();
            $table->string('timeout')->nullable();
            $table->string('totalhours')->nullable();
            $table->string('status_timein')->nullable();
            $table->string('status_timeout')->nullable();
            $table->string('reason')->nullable();
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_attendance');
    }
}
