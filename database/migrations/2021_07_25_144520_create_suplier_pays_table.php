<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuplierPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suplier_pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date')->nullable();
            $table->string('biweekly')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->double('total_liters')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('cheese')->nullable();
            $table->double('serum')->nullable();
            $table->double('yogurt')->nullable();
            $table->double('loan')->nullable();
            $table->double('balanced')->nullable();
            $table->double('salt')->nullable();
            $table->double('transaction')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('suplier_pays');
    }
}
