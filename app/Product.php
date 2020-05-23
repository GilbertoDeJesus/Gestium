<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function entry(){
        return $this->belongsToMany(Entry::class);
    }
    public function depurate(){
        return $this->belongsToMany(Depurate::class);
    }
    public function sale(){
        return $this->belongsToMany(Sale::class);
    }
}
