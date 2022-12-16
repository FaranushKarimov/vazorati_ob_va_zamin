<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmallHydroelectric extends Model
{
    //
    protected $table = "small_hydroelectric";
    protected $guarded = array('id','updated_at','created_at');
}
