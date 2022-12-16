<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainRiver extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'main_rivers';
    
    public function basin() {
        return $this->belongsTo(WaterBasinZone::class,'basin_id');
    }
}
