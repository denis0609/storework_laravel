<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('timezone')->nullable();
            $table->string('clock_comment')->nullable();
            $table->string('rfid')->nullable();
            $table->integer('time_format')->nullable();
            $table->string('iprestriction', '500')->nullable();
            $table->string('opt', '800')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
