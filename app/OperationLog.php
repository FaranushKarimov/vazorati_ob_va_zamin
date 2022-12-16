<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class OperationLog extends Model
{
    protected $fillable = array('notes');
    protected $table = 'operation_logs';

    public function user() {
	    return $this->belongsTo(User::class, $foreign_key = 'user_id', $local_key = 'id');
	  }
}
