<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('account_mode'); // В каком режиме была совершена ставка
            $table->integer('direction'); // Направление ставки
            $table->integer('sum'); // Сумма ставки. В копейках
            $table->integer('status')->default(3); // Статус ставки
            $table->string('cur_pair'); // Валютная пара
            $table->bigInteger('source_id')->nullable(); // Id статистики источника. Использвуется когда ставка ставилась в режиме слушателя.
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
        Schema::dropIfExists('user_statistics');
    }
}
