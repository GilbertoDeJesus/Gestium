<?php

namespace App;

use CreateProductWarehouseMovementSaleTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ProductWarehouseMovement extends Pivot
{
  public function sale()
  {
     return $this->belongsToMany(Sale::class);
  }


  public $incrementing = true;
}
