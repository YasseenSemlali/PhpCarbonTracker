<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;
use App\Repositories\HereRepository;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $trip;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(TripRepository $trip, HereRepository $here)

    {
        $this->trip = $trip;
        $this->here = $here;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$first = $this->here->getLatitudeLongitude('1445 Guy St, Montreal, Quebec H3H 2L5');
        //$second = $this->here->getLatitudeLongitude('358 Sainte-Catherine');
        
        //$this->trip->addTrip($first['latitude'], $first['longtitude'], $second['latitude'], $second['longtitude'], 'car', 'diesel', 12);
        return view('home.index', [
            //'test'=>$this->here->getTrip($first['latitude'], $first['longtitude'], $second['latitude'], $second['longtitude'], 'car', 'diesel', 12),
            //'test2'=>$this->trip->getAllTrips(5)
            ]);
    }
    
}
