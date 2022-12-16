<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatchmentArea extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'catchment_areas';

    /*public function riverNetwork() {
        return $this->hasOne(RiverNetwork::class);
    }
    */
    //
    public function basin() {
        return $this->belongsTo(WaterBasinZone::class,'basin_id');
    }
}
