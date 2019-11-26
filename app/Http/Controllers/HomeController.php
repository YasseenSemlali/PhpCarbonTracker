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
        $trips = $this->trip->getAllTrips(10);	
    		
    		foreach($trips as $trip) {
    		    $response['id'] = $trip->id;
    		    $response['from']['latitude'] = $trip->start_lattitude;
    		    $response['from']['longtitude'] = $trip->start_longtitude;
    		    $response['to']['latitude'] = $trip->end_lattitude;
    		    $response['to']['longtitude'] = $trip->end_longtitude;
    		    $response['mode'] = $trip->mode;
    		    $response['distance'] = $trip->distance;
    		    $response['traveltime'] = $trip->travelTime;
    		    $response['co2emissions'] = $trip->co2emissions;
    		    $response['created_at'] = $trip->created_at;
    		    
    		    $allTrips[] = $response;
    		}
    		var_dump($allTrips);
        //$first = $this->here->getLatitudeLongitude('1445 Guy St, Montreal, Quebec H3H 2L5');
        //$second = $this->here->getLatitudeLongitude('358 Sainte-Catherine');
        //$this->trip->addTrip($first['latitude'], $first['longtitude'], $second['latitude'], $second['longtitude'], 'car', 'diesel', 12);
        
        $this ->trip->totalCostToOffsetCO2();
        return view('home.index', [
            //'test'=>$this->here->getTrip($first['latitude'], $first['longtitude'], $second['latitude'], $second['longtitude'], 'car', 'diesel', 12),
            //'test2'=>$this->trip->getAllTrips(5)
            ]);
    }
    
}
