<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportTypes extends Model
{
    protected $fillable = ['type',];
    
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}


