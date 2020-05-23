<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function credit() {
        return $this->hasOne(Credit::class);
    }
    public function route(){
        return $this->hasOne(Route::class);
    }
    public function sale(){
        return $this->hasMany(Sale::class);
    }
}
