<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->integer('year')->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->double('total_liters')->nullable()->default(0);
            $table->double('total_price')->nullable()->default(0);
//            $table->string('description')->nullable();
            $table->string('time_milk_record')->nullable();
            $table->string('status_milk_record')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('data1')->nullable();
            $table->string('data2')->nullable();
            $table->string('data3')->nullable();
            $table->integer('value1')->nullable();
            $table->integer('value2')->nullable();
            $table->double('value3')->nullable();
            $table->softDeletes();
            $table->timestamps();
//            $table->foreign('estate_id')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
