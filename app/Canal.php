<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Wua;
use App\WaterBasinZone;
use App\MainRiver;

class Canal extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'canals';

    /*public function waterLevels() {
        return $this->hasMany(WaterLevel::class);
    }
    public function waterBasinZone() {
        return $this->belongsTo(WaterBasinZone::class);
    }
    public function wua() {
        return $this->belongsTo(Wua::class);
    }
    public function riverNetwork() {
        return $this->belongsTo(RiverNetwork::class);
    }*/

    public function basin() {
        return $this->belongsTo(WaterBasinZone::class, $foreign_key = 'basin_id', $local_key = 'id');
    }

    public function river() {
        return $this->belongsTo(MainRiver::class, $foreign_key = 'river_id', $local_key = 'id');
    }
}
