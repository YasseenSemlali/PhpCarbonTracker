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
        return view('home.index', [
            //'test'=>$this->here->getTrip('1445 Guy St, Montreal, Quebec H3H 2L5', '358 Sainte-Catherine', 'car', 'diesel', 12)
            'test2'=>$this->trip->getAllTrips(5)
            ]);
    }
    
}
