<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cartones extends Migration
{
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('cartones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->integer('status')->nullable();
            $table->text('numeros')->nullable();
            $table->text('linea_1')->nullable();
            $table->text('linea_2')->nullable();
            $table->text('linea_3')->nullable();
            $table->integer('ganador')->nullable();
            $table->string('tipo_ganador')->nullable();
            $table->integer('sorteo_id')->unsigned()->nullable();
            $table->foreign('sorteo_id')->references('id')->on('sorteos')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tipo')->nullable();
            $table->integer('numero_serie')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('cartones');
    }
}
