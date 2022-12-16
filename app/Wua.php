<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Hydropost;
use App\WaterBasinZone;
use App\Canal;
use App\Region;

class Wua extends Model
{
  protected $guarded = array('id','updated_at','created_at');
  protected $connection = 'mysql';
  protected $table = 'wuas';

  // public $timestamps = false;
  /*public function canals() {
      return $this->hasMany(Canal::class);
  }
  
  public function agricultures() {
     return $this->hasMany(Agriculture::class);
  }*/

  public function hydropostEnds() {
      return $this->hasMany(Hydropost::class, $foreign_key = 'wua_id', $local_key = 'id');
  }

  public function basin() {
    return $this->belongsTo(WaterBasinZone::class, $foreign_key = 'basin_id', $local_key = 'id');
  }

  public function canal() {
    return $this->belongsTo(Canal::class, $foreign_key = 'canal_id', $local_key = 'id');
  }

  public function regionR() {
    return $this->belongsTo(Region::class, $foreign_key = 'region_id', $local_key = 'id');
  }
}
