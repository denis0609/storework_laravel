<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_data', function (Blueprint $table) {
            $table->id();
            $table->integer('reference');
            $table->string('company')->nullable();
            $table->string('department')->nullable();
            $table->string('jobposition')->nullable();
            $table->string('companyemail')->nullable();
            $table->string('idno')->nullable();
            $table->string('startdate')->nullable();
            $table->string('dateregularized')->nullable();
            $table->string('reason', '500')->nullable();
            $table->integer('leaveprivilege')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_data');
    }
}
