<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function deliverer(){
        return $this->belongsTo(Deliverer::class);
    }
}
