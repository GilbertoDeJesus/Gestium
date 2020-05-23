<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function deliverer(){
        return $this->belongsTo(Deliverer::class);
    }
    public function bond(){
        return $this->hasOne(Bond::class);
    }
}
