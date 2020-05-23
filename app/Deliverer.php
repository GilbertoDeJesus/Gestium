<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverer extends Model
{
    public function Goal(){
        return $this->hasMany(Goal::class);
    }
}
