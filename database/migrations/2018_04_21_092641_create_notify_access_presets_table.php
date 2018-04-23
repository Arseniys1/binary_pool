<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyAccessPresetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_access_presets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('source_id');
            $table->integer('days')->default(1);
            $table->integer('forever')->default(0);
            $table->integer('status')->default(1);
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('notify_access_presets');
    }
}
