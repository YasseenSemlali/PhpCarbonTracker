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
    
    private const VALID_MODES=['car','carpool','publicTransport','bicycle','pedestrian'];
    private const VALID_ENGINES=['gasoline','diesel','electric'];
        
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
    		
    		$allTrips = array();
    		
    		foreach($trips as $trip) {
    		    $response['id'] = $trip->id;
    		    $response['from']['latitude'] = $trip->start_latitude;
    		    $response['from']['longitude'] = $trip->start_longitude;
    		    $response['to']['latitude'] = $trip->end_latitude;
    		    $response['to']['longitude'] = $trip->end_longitude;
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
    	    $fromlatitude = $request->query('fromlatitude');
    	    $fromlongitude = $request->query('fromlongitude');
    	    $tolatitude = $request->query('tolatitude');
    	    $tolongitude = $request->query('tolongitude');
    	    $mode = $request->query('mode');
    	    $engine = $request->query('engine');
    	    $consumption = $request->query('consumption');
    	    
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
    	    
    	    if(!in_array($mode,ApiController::VALID_MODES)) {
    	        $err[] = 'Invalid transport mode';
    	    }
    	    
    	    if($mode == 'car' && !(isset($engine) && isset($consumption))) {
    	        $err[] = 'fuel type and fuel consumption must be set';
    	    } else if($mode == 'car' && !in_array($engine, ApiController::VALID_ENGINES)) {
    	        $err[] = 'invalid engine type';
    	    }
    	    
    	     if(isset($err)) {
    	        return response()->json([
    	                'message' => 'The given data was invalid.',
    	                'errors' => $err
    	            ], 422);
    	    }
    	    
    	    $trip = $this->here->getTrip($fromlatitude, $fromlongitude,$tolatitude ,$tolongitude ,$mode ,$engine, $consumption );
    	    
    	    if(empty($trip)) {
    	        return response()->json([
    	                'error' => 'ApplicationError',
    	            ], 422);
    	    }
    	    
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
    	    
    	    if(!in_array($mode,ApiController::VALID_MODES)) {
    	        $err[] = 'Invalid transport mode';
    	    }
    	    
    	    if($mode == 'car' && !(isset($engine) && isset($consumption))) {
    	        $err[] = 'fuel type and fuel consumption must be set';
    	    } else if($mode == 'car' && !in_array($engine, ApiController::VALID_ENGINES)) {
    	        $err[] = 'invalid engine type';
    	    }
    	    
    	     if(isset($err)) {
    	        return response()->json([
    	                'message' => 'The given data was invalid.',
    	                'errors' => $err
    	            ], 422);
    	    }
    	    
    	    $trip = $this->trip->addTrip($user, $fromlatitude, $fromlongitude,$tolatitude ,$tolongitude ,$mode ,$engine, $consumption );
    	    
    	    if(empty($trip)) {
    	        return response()->json([
    	                'error' => 'ApplicationError',
    	            ], 422);
    	    }
    	   
    		$response['id'] = $trip->id;
    		$response['from']['latitude'] = $trip->start_latitude;
    		$response['from']['longitude'] = $trip->start_longitude;
    		$response['to']['latitude'] = $trip->end_latitude;
    		$response['to']['longitude'] = $trip->end_longitude;
    		$response['mode'] = $trip->mode;
    		
    		$response['distance'] = $trip->distance;
    		$response['traveltime'] = $trip->travelTime;
    		$response['co2emissions'] = $trip->co2emissions;
    		$response['created_at'] = $trip->created_at;
    		    
    		    
    		return response()->json($response);
    	}
    }

}
