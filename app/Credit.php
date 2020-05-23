<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
