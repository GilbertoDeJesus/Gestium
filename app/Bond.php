<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    protected $guarded = [];
    public function goal(){
        return $this->belongsTo(Goal::class);
    }
}
