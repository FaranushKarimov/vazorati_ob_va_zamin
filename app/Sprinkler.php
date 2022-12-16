<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprinkler extends Model
{
    //
    public function riverNetwork() {
        return $this->belongsTo(RiverNetwork::class);
    }
}
