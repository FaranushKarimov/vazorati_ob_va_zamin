<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agriculture extends Model
{
    //
    public $timestamps=false;

    public function wuas() {
        return $this->belongsTo(Wua::class);
    }
}
