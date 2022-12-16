<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hydroelectric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hydroelectric', function(Blueprint $table) {
            $table->increments('id');
            $table->text('name_ru');
            $table->text('name_tj');
            $table->text('name_en');
            $table->text('state')->nullable();
            $table->text('town')->nullable();
            $table->integer('hydroelectric_code')->unsigned();
            $table->date('date')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->text('river')->nullable();
            $table->decimal('height');
            $table->decimal('consumption')->nullable();
            $table->decimal('idle_reset')->nullable();
            $table->decimal('maximum_level');
            $table->decimal('minimum_level');
            $table->decimal('power generation');
            $table->decimal('volume');
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
