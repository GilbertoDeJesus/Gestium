<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverer extends Model
{
    public function goal(){
        return $this->hasMany(Goal::class);
    }
    public function expense(){
        return $this->hasMany(Expense::class);
    }
    public function warehousemovement(){
        return $this->hasMany(WarehouseMovement::class);
    }
    public function sale(){
        return $this->hasMany(Sale::class);
    }
    public function route(){
        return $this->belongsToMany(Route::class)->withTimestamps();
    }
    protected $guarded = [];
}
