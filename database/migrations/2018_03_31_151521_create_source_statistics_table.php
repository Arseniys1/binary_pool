<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('source_id');
            $table->integer('success_count')->default(0); // Количество побед
            $table->integer('loss_count')->default(0); // Количество проигрышей
            $table->integer('ret_count')->default(0); // Количество возвратов
            $table->integer('cancel_count')->default(0); // Количество продаж
            $table->integer('win_sum')->default(0); // Сколько заработал. В копейках
            $table->integer('loss_sum')->default(0); // Сколько проиграл. В копейках
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_statistics');
    }
}
