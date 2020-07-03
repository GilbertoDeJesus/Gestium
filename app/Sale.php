<?php

namespace App;

use CreateProductWarehouseMovementTable;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    
    public function productwarehousemovement(){
        return $this->belongsToMany(ProductWarehouseMovement::class)->using(ProductSale::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function deliverer(){
        return $this->belongsTo(Deliverer::class);
    }
    protected $guarded = [];

}
