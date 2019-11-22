<?php 
    namespace App\Repositories;
    use Illuminate\Support\Facades\Auth;

    use App\Trip;

    class TripRepository {
        
        //tempoprary, make it take id as param later
        public function getAllTrips() {
            $test = Auth::user()->trips->toArray();
            
        }
        
        public function addTrip(int $id) {
            
        }
    }
?>