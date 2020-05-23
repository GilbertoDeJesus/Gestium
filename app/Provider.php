<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function entry(){
        return $this->belongsToMany(Entry::class);
    }
}
