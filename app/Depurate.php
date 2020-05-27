<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depurate extends Model
{
 public function deliverer(){
     return $this->belongsTo(Deliverer::class);

 }
 public function product(){
    return $this->belongsToMany(Product::class)->using(DepurateProduct::class);
}
 protected $guarded = [];

}
