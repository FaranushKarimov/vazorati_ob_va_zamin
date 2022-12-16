<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Hydropost;

class Qcordinate extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'qcordinates';

    public function hydropost() {
	  return $this->belongsTo(Hydropost::class, $foreign_key = 'hydropost_id', $local_key = 'id');
	}

    static function qValue($height, $hydropost_id)
    {
        if(is_null($height) || is_null($hydropost_id)) return NULL;

    	return SELF::where('hydropost_id','=',$hydropost_id)->where('height','=',$height)->value('flow');
    }

    static function wValue($qms)
    {
    	return $qms ? floatval(number_format($qms*86.4, 2, ".", "")) : NULL;
    }

    static function avgQ($h1,$h2,$h3,$h4,$id){
        $arr_levels = array($h1,$h2,$h3,$h4);
        $count_levels = count(array_filter($arr_levels));
        $arr_q = array(SELF::qValue($h1, $id),SELF::qValue($h2, $id),SELF::qValue($h3, $id),SELF::qValue($h4, $id));
        $count_q = count(array_filter($arr_q));

        $avg = NULL;
        $part = NULL;

        if($count_levels && $count_q) {
            $part = ($arr_q[0]?:0) + ($arr_q[1]?:0) + ($arr_q[2]?:0) + ($arr_q[3]?:0);
            $avg = $part/$count_q;
        }

        return $avg;
    }
}
