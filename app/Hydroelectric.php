<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hydroelectric extends Model
{
    //
    protected $table = "hydroelectric";
    protected $guarded = array('id','updated_at','created_at');
}
