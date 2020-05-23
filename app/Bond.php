<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    public function goal(){
        return $this->belongsTo(Goal::class);
    }
}
