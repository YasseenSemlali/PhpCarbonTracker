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
    private const SCHOOL_LAT = 45.490146;
    private const SCHOOL_LONG = -73.588221;

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
    
    
    /**
     * This method is called with a post request to add a trip to the database
     *
     * param request 
     */
    public function addTrip(Request $request){
        $user = Auth::user();
        $hereRepo = new HereRepository();

        $request->validate([
            'start' => 'required',
            'destination' => 'required',
            'transportationMode' => 'required',
        ]);
        
        //if the selected starting point is home or school we fetch coordinates from the database
        if($request->start == "home"){
            $origin['latitude'] = $user->latitude;
            $origin['longitude'] = $user->longitude;
            
        } else if($request->start == "school"){
            $origin['latitude'] = HomeController::SCHOOL_LAT;
            $origin['longitude'] = HomeController::SCHOOL_LONG;
            
        } else{
              $origin = $hereRepo->getLatitudeLongitude($request->start);
        }
        
        if($request->destination == "home"){
            
             $destination['latitude'] = $user->latitude;
             $destination['longitude'] = $user->longitude;
             
        } else if($request->destination == "school"){
            $destination['latitude'] = HomeController::SCHOOL_LAT;
            $destination['longitude'] = HomeController::SCHOOL_LONG;
            
        } else{
              $destination = $hereRepo->getLatitudeLongitude($request->destination);
        }
        
         $validator = Validator::make([], []);
        if(count($origin) == 0) { 
             $validator->getMessageBag()->add('start', 'Invalid start address');
             return redirect("/home")->withErrors($validator);
        }
        if(count($destination) == 0) {
             $validator->getMessageBag()->add('destination', 'Invalid end address');
             return redirect("/home")->withErrors($validator);
        }
        
        //if the selection is a car i provide extra arguments
        if($request->transportationMode == "car"){
            $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longitude'],$destination['latitude'],$destination['longitude'],'car',$user->fuel_type, $user->fuel_consumption);

            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/home")->withErrors($validator);
            }
            
            $co2emissions = $tripInfo['co2emissions'];
            $fuelType = $user->fuel_type;
            
            //if the selection is carpool i divide the emission by 2
        }else if($request->transportationMode == "carpool"){
            $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longitude'],$destination['latitude'],$destination['longitude'],'car',$user->fuel_type, $user->fuel_consumption);

            
            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/home")->withErrors($validator);
            }
            $co2emissions = $tripInfo['co2emissions']/2;
            $fuelType = $user->fuel_type;
        }else{
             $tripInfo = $hereRepo->getTrip($origin['latitude'],$origin['longitude'],$destination['latitude'],$destination['longitude'],$request->transportationMode);

            if(count($tripInfo) == 0) {
                $validator->getMessageBag()->add('destination', 'Could not calculate route to destination');
                return redirect("/home")->withErrors($validator);
            }
            $co2emissions = $tripInfo['co2emissions'];
            $fuelType = null;
        }


        /**
         * Adding a trip to the database
         * */
        $request->user()->trips()->create([
                 'start_latitude' =>$origin['latitude'],
                     'start_longitude' => $origin['longitude'],
                     'end_latitude' => $destination['latitude'],
                     'end_longitude' => $destination['longitude'],
                    'mode' =>$request->transportationMode,
                    'engine' => $fuelType,
                    'travelTime' =>$tripInfo['travelTime'],
                    'distance' => $tripInfo['distance'],
                    'co2emissions' => $co2emissions,

            ]);
            
        if($request->start != 'school' && $request->start != 'home') {
            $request->user()->locations()->create([
                     'name' => $request->start,
                     'latitude' =>$origin['latitude'],
                     'longitude' => $origin['longitude'],
                    
                ]);
        }
         if($request->destination != 'school' && $request->destination != 'home') {
            $request->user()->locations()->create([
                     'name' => $request->destination,
                     'latitude' =>$destination['latitude'],
                     'longitude' => $destination['longitude'],
                    
                ]);
         }
            return redirect('/home');
    }
    
    public function home(){
        return view('welcome');
    }
}
