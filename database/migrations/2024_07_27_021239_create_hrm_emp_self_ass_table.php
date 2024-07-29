<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmpSelfAssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_emp_self_ass', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch')->default(0);
            $table->integer('employee')->default(0);
            $table->string('rating')->nullable();
            $table->string('appraisal_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_emp_self_ass');
    }
}
