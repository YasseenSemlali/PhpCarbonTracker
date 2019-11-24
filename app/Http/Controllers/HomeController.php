<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;
use App\Repositories\HereRepository;
use Illuminate\Http\Request;
use App\Trip;

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
        $trips = Trip::orderBy('created_at','DESC')->paginate(5);
        
        return view('home.index', [
            'trips' => $trips,
            'username' => "John DOE",
            'dateStarted' => 'Date xxxx',
            'totalDistance' => '30 km',
            'emissionAmount' => 'AMount Here ',
            'cost' => 'Cost offset Here '
            ]);
    }
    
    
    public function addTrip(Request $request){
        
        $hereRepo = new HereRepository();
        $origin = $hereRepo->getLatitudeLongitude($request->origin);
        $destination = $hereRepo->getLatitudeLongitude($request->destinationTxt);
       echo $destination[0];
        $tripInfo = $hereRepo->getTrip($origin[0],$origin[1],$destination[0],$destination[1],$request->transportationMode);
        //validate here if necessary
        $request->user()->trips()->create([
                    'start_lattitude' =>$origin[0],
                    'start_longtitude' => $origin[1],
                    'end_lattitude' => $destination[0],
                    'end_longtitude' => $destination[1],
                    'mode' =>$request->mode,
                    'engine' => 'diesel',
                    'travelTime' =>634,
                    'distance' => 1345,
                    'co2emissions' => 0.385
            ]);
    }
    
}
