<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function credit() {
        return $this->hasOne(Credit::class);
    }
}
