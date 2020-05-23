<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function product(){
        return $this->belongsToMany(Product::class);
    }
    public function provider(){
        return $this->hasOne(Provider::class);
    }
}
