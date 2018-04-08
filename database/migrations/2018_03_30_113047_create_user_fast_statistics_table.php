<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFastStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fast_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('account_mode');
            $table->integer('success_count')->default(0); // Количество побед
            $table->integer('loss_count')->default(0); // Количество проигрышей
            $table->integer('ret_count')->default(0); // Количество возвратов
            $table->integer('cancel_count')->default(0); // Количество отмен
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
        Schema::dropIfExists('user_fast_statistics');
    }
}
