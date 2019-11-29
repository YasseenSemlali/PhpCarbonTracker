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
    
    public function alltrips() {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    		$trips = $this->trip->getAllTrips($user->id);	
    		
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
    		return response()->json($allTrips, 200);
    	}
    }
    
    public function tripinfo() {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    		$stories = Story::where('user_id', '=',$user->id)->orderBy('created_at', 'desc')->get();	
    		return response()->json($stories, 200);
    	}
    }
    
    public function addtrip() {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    		$stories = Story::where('user_id', '=',$user->id)->orderBy('created_at', 'desc')->get();	
    		return response()->json($stories, 200);
    	}
    }
    
    public function byauthor(Request $request)
    {
    	$user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	 return response()->json(['error' => 'invalid_token'], 401);
    	else {
    		$stories = Story::where('user_id', '=',$user->id)->orderBy('created_at', 'desc')->get();	
    		return response()->json($stories, 200);
    	}
    }

}
