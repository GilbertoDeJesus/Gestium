<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function credit() {
        return $this->hasOne(Credit::class);
    }
    public function route(){
        return $this->belongsTo(Route::class);
    }
    public function sale(){
        return $this->hasMany(Sale::class);
    }
    protected $guarded = [];
    protected $fillable = [
        'nombre',
    ];

}
