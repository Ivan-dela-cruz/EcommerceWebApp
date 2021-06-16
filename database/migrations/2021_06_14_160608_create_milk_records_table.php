<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_id');
            $table->unsignedBigInteger('supplier_id');
            $table->double('total_liters')->nullable()->default(0);
            $table->double('price')->nullable()->default(0);
            $table->double('sub_total')->nullable()->default(0);
            $table->integer('year')->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->string('data1')->nullable();
            $table->string('data2')->nullable();
            $table->string('data3')->nullable();
            $table->integer('value1')->nullable();
            $table->integer('value2')->nullable();
            $table->double('value3')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milk_records');
    }
}
