<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseMovement extends Model
{
    public function deliverer(){
        return $this->belongsTo(Deliverer::class);

    }
    public function product(){
       return $this->belongsToMany(Product::class)->using(WarehouseMovementProduct::class)->withTimestamps();
   }
    protected $guarded = [];
}
