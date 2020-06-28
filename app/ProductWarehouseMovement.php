<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductWarehouseMovement extends Pivot
{
    public function sale(){
        return $this->belongsToMany(Sale::class)->using(ProductSale::class);
          }

        public $incrementing=true;
}
