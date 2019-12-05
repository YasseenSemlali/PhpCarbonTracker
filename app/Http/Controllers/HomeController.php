<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;
use App\Repositories\HereRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
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
        
        $trips = $this->trip->getAllTrips($user, 5);
      
        $recentLocations = $this->trip->getAllRecentLocations($user);
        
        $totalDistance = $this->trip->totalDistance($user);
        $co2sum =  $this->trip->totalCO2($user);
        $offset = $this->trip->totalCostToOffsetCO2($user);
        $hasCar = true;
        
        if(is_null($user->fuel_type) || $user->fuel_type == "none"){
            $hasCar = false;
        }
        
        return view('home.index', [
            'trips' => $trips,
            'username' => $user->name,
            'dateStarted' => $user->created_at,
            'totalDistance' => $totalDistance/1000,
            'emissionAmount' => $co2sum,
            'cost' =>$offset,
            'locations' =>$recentLocations,
            'hasCarInfo' =>$hasCar

            ]);
    }
    
    
    public function addTrip(Request $request){
        $user = Auth::user();
        $hereRepo = new HereRepository();

        $request->validate([
            'start' => 'required',
            'destination' => 'required',
            'transportationMode' => 'required',
        ]);
        
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
        
         $validator = Validator::make([], []);
        if(count($origin) == 0) { 
             $validator->getMessageBag()->add('start', 'Invalid start address');
             return redirect("/")->withErrors($validator);
        }
        if(count($destination) == 0) {
             $validator->getMessageBag()->add('destination', 'Invalid end address');
             return redirect("/")->withErrors($validator);
        }
        
        //if the selection is a car i provide extra arguments
        if($request->transportationMode == "car"){

            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/")->withErrors($validator);
            }
            
            $co2emissions = $tripInfo['co2emissions'];
            $fuelType = $user->fuel_type;
            
            //if the selection is carpool i divide the emission by 2
        }else if($request->transportationMode == "carpool"){
            $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],'car',$user->fuel_type, $user->fuel_consumption);

            
            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/")->withErrors($validator);
            }
            $co2emissions = $tripInfo['co2emissions']/2;
            $fuelType = $user->fuel_type;
        }else{
             $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longtitude'],$destination['latitude'],$destination['longtitude'],$request->transportationMode);

            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/")->withErrors($validator);
            }
            $co2emissions = $tripInfo['co2emissions'];
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
