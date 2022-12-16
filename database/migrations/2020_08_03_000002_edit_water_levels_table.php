<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWaterLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('water_levels', function (Blueprint $table) {
            $table->renameColumn('height_h', 'height_h_8');
            $table->double('height_h_12')->nullable();
            $table->double('height_h_16')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('water_levels', function (Blueprint $table) {
            $table->renameColumn('height_h_8','height_h');
            $table->dropColumn('height_h_12');
            $table->dropColumn('height_h_16');
        });
    }
}
