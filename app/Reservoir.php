<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservoir extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'reservoirs';

    public function basin() {
        return $this->belongsTo(WaterBasinZone::class,'basin_id');
    }
}
