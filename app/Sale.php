<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function product(){
        return $this->belongsToMany(WarehouseMovementProduct::class)->using(ProductSale::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function deliverer(){
        return $this->belongsTo(Deliverer::class);
    }
    protected $guarded = [];

}
