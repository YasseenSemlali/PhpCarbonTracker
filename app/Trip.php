<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['start_latitude', 'start_longitude', 'end_latitude', 'end_longitude', 
    'mode', 'engine', 'travelTime', 'distance', 'co2emissions',];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
