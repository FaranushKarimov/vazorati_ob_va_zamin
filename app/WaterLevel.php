<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Hydropost;

class WaterLevel extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'water_levels';

    // public $timestamps = false;
    /*public function canals() {
        return $this->belongsTo(Canal::class);
    }*/

    public function hydropost() {
	  return $this->belongsTo(Hydropost::class, $foreign_key = 'hydropost_id', $local_key = 'id');
	}

	public function getFlowQAttribute($flow) {
	  return $this->attributes['flow_q'] = number_format($flow, 2,'.','');
	}
}
