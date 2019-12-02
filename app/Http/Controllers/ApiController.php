<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Trip;
use App\Repositories\TripRepository;
use App\Repositories\HereRepository;

class ApiController extends Controller
{
    private $trip;
    private $here;
        
    public function __construct(TripRepository $trip, HereRepository $here) {
        $this->trip = $trip;
        $this->here = $here;
    }
    
    public function alltrips(Request $request) {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    		$trips = $this->trip->getAllTrips($user, 1000);	
    		
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
    		return response()->json($allTrips);
    	}
    }
    
    public function tripinfo(Request $request) {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    	    $fromlatitude = $request->input('fromlatitude');
    	    $fromlongitude = $request->input('fromlongitude');
    	    $tolatitude = $request->input('tolatitude');
    	    $tolongitude = $request->input('tolongitude');
    	    $mode = $request->input('mode');
    	    $engine = $request->input('engine');
    	    $consumption = $request->input('consumption');
    	    
    	    if(!isset($fromlatitude)) {
    	        $err[] = 'fromlatitude must be set';
    	    }
    	    
    	    if(!isset($fromlongitude)) {
    	        $err[] = 'fromlongitude must be set';
    	    }
    	    
    	    if(!isset($tolatitude)) {
    	        $err[] = 'tolatitude must be set';
    	    }
    	    
    	    if(!isset($tolongitude)) {
    	        $err[] = 'tolongitude must be set';
    	    }
    	    
    	    if(!isset($mode)) {
    	        $err[] = 'mode must be set';
    	    }
    	    
    	    if($mode == 'car' && !(isset($engine) && isset($consumption))) {
    	        $err[] = 'fuel type and fuel consumption must be set';
    	        
    	    }
    	    
    	     if(isset($err)) {
    	        return response()->json([
    	                'message' => 'The given data was invalid',
    	                'errors' => $err
    	            ], 422);
    	    }
    	    
    	    $trip = $this->here->getTrip($fromlatitude, $fromlongitude,$tolatitude ,$tolongitude ,$mode ,$engine, $consumption );
    	    
    		$response['distance'] = $trip['distance'];
    		$response['traveltime'] = $trip['travelTime'];
    		$response['co2emissions'] = $trip['co2emissions'];
    		    
    		return response()->json($response);
    	}
    }
    
    public function addtrip(Request $request) {
       $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    	    $fromlatitude = $request->input('fromlatitude');
    	    $fromlongitude = $request->input('fromlongitude');
    	    $tolatitude = $request->input('tolatitude');
    	    $tolongitude = $request->input('tolongitude');
    	    $mode = $request->input('mode');
    	    $engine = $request->input('engine');
    	    $consumption = $request->input('consumption');
    	    
    	    if(!isset($fromlatitude)) {
    	        $err[] = 'fromlatitude must be set';
    	    }
    	    
    	    if(!isset($fromlongitude)) {
    	        $err[] = 'fromlongitude must be set';
    	    }
    	    
    	    if(!isset($tolatitude)) {
    	        $err[] = 'tolatitude must be set';
    	    }
    	    
    	    if(!isset($tolongitude)) {
    	        $err[] = 'tolongitude must be set';
    	    }
    	    
    	    if(!isset($mode)) {
    	        $err[] = 'mode must be set';
    	    }
    	    
    	    if($mode == 'car' && !(isset($engine) && isset($consumption))) {
    	        $err[] = 'fuel type and fuel consumption must be set';
    	        
    	    }
    	    
    	     if(isset($err)) {
    	        return response()->json([
    	                'message' => 'The given data was invalid',
    	                'errors' => $err
    	            ], 422);
    	    }
    	    
    	    $trip = $this->trip->addTrip($user, $fromlatitude, $fromlongitude,$tolatitude ,$tolongitude ,$mode ,$engine, $consumption );
    	    
    	   
    		$response['id'] = $trip->id;
    		$response['from']['latitude'] = $trip->start_lattitude;
    		$response['from']['longtitude'] = $trip->start_longtitude;
    		$response['to']['latitude'] = $trip->end_lattitude;
    		$response['to']['longtitude'] = $trip->end_longtitude;
    		$response['mode'] = $trip->mode;
    		$response['created_at'] = $trip->created_at;
    		
    		$response['distance'] = $trip->distance;
    		$response['traveltime'] = $trip->travelTime;
    		$response['co2emissions'] = $trip->co2emissions;
    		    
    		    
    		return response()->json($response);
    	}
    }

}
