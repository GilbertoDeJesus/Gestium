<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $guarded = [];
    public function deliverer(){
        return $this->belongsToMany(Deliverer::class)->withTimestamps();;
    }
    public function customer(){
        return $this->hasMany(Customer::class);
    }

}
