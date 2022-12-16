<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Wua;

class BillingWua extends Model
{
    // protected $guarded = array('id','updated_at','created_at');
    protected $guarded = array('');
    protected $table = 'vw_export_wua';
    // protected $connection = 'sqlsrv';

    public $timestamps = false;

    public function wua() {
	    return $this->hasOne(Wua::class, $foreign_key = 'billing_id', $local_key = 'wua_id');
	  }

}
