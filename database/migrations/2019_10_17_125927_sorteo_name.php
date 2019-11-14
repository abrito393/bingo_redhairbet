<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SorteoName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sorteos', 'nombre')) {
            Schema::table('sorteos', function (Blueprint $table) {
                $table->string('nombre')->nullable()->default(null);
            });
        }
        
        if (!Schema::hasColumn('sorteos', 'descripcion')) {
            Schema::table('sorteos', function (Blueprint $table) {
                $table->text('descripcion')->nullable()->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
