<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function product(){
        return $this->belongsToMany(Product::class)
        ->withPivot('cantidad', 'precio_compra')
        ->withTimestamps();
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    protected $guarded = [];
}
