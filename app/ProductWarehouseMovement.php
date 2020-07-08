<?php

namespace App;

use CreateProductWarehouseMovementSaleTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ProductWarehouseMovement extends Pivot
{
  public function sale()
  {
     return $this->belongsToMany(Sale::class,'product_warehouse_movement_sale',
     'product_sale_id','sale_id')
     ->withPivot('cantidad', 'monto')
     ->withTimestamps();
  }

  public $incrementing = true;
}
