<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function entry(){
        return $this->belongsToMany(Entry::class)
        ->withPivot('cantidad', 'precio_compra')
        ->withTimestamps();
    }
    public function warehousemovement(){
        return $this->belongsToMany(WarehouseMovement::class)->using(WarehouseMovementProduct::class)
        ->withPivot('cantidad', 'tipo_movimiento')
        ->withTimestamps();
    }


    protected $guarded = [];

}
