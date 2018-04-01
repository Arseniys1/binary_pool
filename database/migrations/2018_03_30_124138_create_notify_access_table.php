<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('source_id');
            $table->bigInteger('user_id');
            $table->integer('status'); // Статус доступа
            $table->integer('access_type'); // Тип доступа
            $table->integer('is_hidden')->default(0); // Скрытый доступ
            $table->timestamp('end_at')->nullable(); // До какого активен доступ. Используется при типе доступа с ежемесячной оплатой
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
        Schema::dropIfExists('notify_access');
    }
}
