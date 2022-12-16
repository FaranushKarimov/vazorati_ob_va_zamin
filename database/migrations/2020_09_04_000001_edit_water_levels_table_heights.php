<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWaterLevelsTableHeights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('water_levels', function (Blueprint $table) {
            $table->renameColumn('height_h_8', 'height_h_6');
            $table->renameColumn('height_h_16', 'height_h_18');
            $table->double('height_h_24')->nullable();
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
            $table->renameColumn('height_h_6','height_h_8');
            $table->renameColumn('height_h_18','height_h_16');
            $table->dropColumn('height_h_24');
        });
    }
}
