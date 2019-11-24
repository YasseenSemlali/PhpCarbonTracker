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
    
}
