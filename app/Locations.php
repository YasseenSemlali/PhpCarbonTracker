<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
        protected $fillable = ['name', 'longtitude', 'lattitude'];
    
     public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
