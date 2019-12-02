<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;
use App\Repositories\HereRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Trip;
use App\User;
use App\Locations;
use DB;

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
        $user = Auth::user();
        
        $trips = $this->trip->getAllTrips(5);
      
       $recentLocations = $this->trip->getAllRecentLocations();
        
        $totalDistance = $this->trip->totalDistance();
        $co2sum =  $this->trip->totalCO2();
        $offset = $this->trip->totalCostToOffsetCO2();
        
        return view('home.index', [
            'trips' => $trips,
            'username' => $user->name,
            'dateStarted' => $user->created_at,
            'totalDistance' => $totalDistance,
            'emissionAmount' => $co2sum,
            'cost' =>$offset,
            'locations' =>$recentLocations

            ]);
    }
    
    
    public function addTrip(Request $request){
        $user = Auth::user();
        $hereRepo = new HereRepository();

        
        if($request->start == "Home"){
            $origin['latitude'] = $user->lattitude;
            $origin['longtitude'] = $user->longtitude;
            
        }else{
              $origin = $hereRepo->getLatitudeLongitude($request->start);
        }
        
        if($request->destination == "Home"){
            
             $destination['latitude'] = $user->lattitude;
             $destination['longtitude'] = $user->longtitude;
             
        }else{
              $destination = $hereRepo->getLatitudeLongitude($request->destination);
        }
        
        
        //if the selection is a car i provide extra arguments
        if($request->transportationMode == "car"){
            
            $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],$request->transportationMode, $user->fuel_type, $user->fuel_consumption);
            $co2emissions = $tripInfo['co2Emission'];
            $fuelType = $user->fuel_type;
            
            //if the selection is carpool i divide the emission by 2
        }else if($request->transportationMode == "carpool"){
            $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],'car',$user->fuel_type, $user->fuel_consumption);
            $co2emissions = $tripInfo['co2Emission']/2;
            $fuelType = $user->fuel_type;
        }else{
             $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],$request->transportationMode);
            $co2emissions = 0.0;
            $fuelType = null;
        }



        $request->user()->trips()->create([
                 'start_lattitude' =>$origin['latitude'],
                     'start_longtitude' => $origin['longtitude'],
                     'end_lattitude' => $destination['latitude'],
                     'end_longtitude' => $destination['longtitude'],
                    'mode' =>$request->transportationMode,
                    'engine' => $fuelType,
                    'travelTime' =>$tripInfo['travelTime'],
                    'distance' => $tripInfo['distance'],
                    'co2emissions' => $co2emissions,

            ]);
            
        $request->user()->locations()->create([
                 'name' => $request->start,
                 'lattitude' =>$origin['latitude'],
                 'longtitude' => $origin['longtitude'],
                
            ]);
            
        $request->user()->locations()->create([
                 'name' => $request->destination,
                 'lattitude' =>$destination['latitude'],
                 'longtitude' => $destination['longtitude'],
                
            ]);
            return redirect('/home');
    }
    
    public function home(){
        return view('welcome');
    }
}
