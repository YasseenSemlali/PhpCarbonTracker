<?php

namespace App\Http\Controllers;

use App\Repositories\TripRepository;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $trip;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct(TripRepository $weather)
    {
        $this->trip = $weather;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            
            ]);
        return view('home');
    }
}
