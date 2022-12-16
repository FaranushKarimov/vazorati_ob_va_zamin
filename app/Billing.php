<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    // protected $guarded = array('id','updated_at','created_at');
    protected $guarded = array('');
    protected $table = 'vw_export';
    // protected $connection = 'sqlsrv';

    public $timestamps = false;

}
