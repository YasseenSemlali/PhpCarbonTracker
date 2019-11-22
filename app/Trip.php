<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['start_lattitude', 'start_longtitude', 'end_lattitude', 'end_longtitude', 
    'mode', 'engine', 'travelTime', 'distance', 'co2emissions',];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
