<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWuaTableAddIrrigationLands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wuas', function (Blueprint $table) {
            $table->integer('irrigation_lands')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wuas', function (Blueprint $table) {
            $table->dropColumn('irrigation_lands');
        });
    }
}
