<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sorteos extends Migration
{
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('sorteos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->string('status')->nullable();
            $table->integer('min_numeros')->nullable();
            $table->integer('max_numeros')->nullable();
            $table->text('numeros_sorteados')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('sorteos');
    }
}
