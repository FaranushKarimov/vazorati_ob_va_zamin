<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lake extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'lakes';

    public function basin() {
        return $this->belongsTo(WaterBasinZone::class,'basin_id');
    }
}
