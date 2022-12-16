<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterBasinZone extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'water_basin_zones';

    /*public function canals() {
        return $this->hasMany(Canal::class);
    }
    public function catchmentAreas() {
        return $this->hasMany(CatchmentArea::class);
    }
    public function mainRivers() {
        return $this->hasMany(MainRiver::class);
    }*/
}
