<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmallHydroelectric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('small_hydroelectric', function(Blueprint $table) {
            $table->increments('id');
            $table->text('name_ru');
            $table->text('name_tj');
            $table->text('name_en');
            $table->text('state')->nullable();
            $table->text('town')->nullable();
            $table->integer('hydroelectric_code')->unsigned();
            $table->text('river')->nullable();
            $table->decimal('power_generation');
        });
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
