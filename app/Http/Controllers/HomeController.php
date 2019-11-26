<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;
use App\Repositories\HereRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Trip;
use App\User;


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
        $user = Auth::user();
        
        return view('home.index', [
            'trips' => $trips,
            'username' => $user->name,
            'dateStarted' => $user->created_at,
            'totalDistance' => '30 km',
            'emissionAmount' => 'AMount Here ',
            'cost' => 'Cost offset Here '
            ]);
    }
    
    
    public function addTrip(Request $request){
        
        $hereRepo = new HereRepository();
        $origin = $hereRepo->getLatitudeLongitude($request->origin);
        $destination = $hereRepo->getLatitudeLongitude($request->destinationTxt);
        var_dump($request->transportationMode);

       $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],$request->transportationMode);
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
                    'co2emissions' => 1.3,
            //'test'=>$this->here->getTrip('1445 Guy St, Montreal, Quebec H3H 2L5', '358 Sainte-Catherine', 'car', 'diesel', 12)
            'test2'=>$this->trip->getAllTrips(5)
            ]);
    }

    
}
