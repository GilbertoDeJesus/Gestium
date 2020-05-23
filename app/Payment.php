<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function credit(){
        return $this->belongsTo(Credit::class);
    }
}
