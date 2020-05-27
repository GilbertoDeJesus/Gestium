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
    public function depurate(){
        return $this->belongsToMany(Depurate::class)
        ->withPivot('cantidad')
        ->withTimestamps();
    }
    public function sale(){
        return $this->belongsToMany(Sale::class)
        ->withPivot('cantidad', 'precio_venta','precio_compra','monto','product_depurate_id')
        ->withTimestamps();
    }
    protected $guarded = [];

}
