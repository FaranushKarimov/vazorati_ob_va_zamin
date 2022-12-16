<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $guarded = array('id','updated_at','created_at');
    protected $table = 'user_roles';
}
