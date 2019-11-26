<?php 
    namespace App\Repositories;
    use Illuminate\Support\Facades\Auth;

    use App\Trip;
    use App\User;

    class TripRepository {
        
        //tempoprary, make it take id as param later
        public function getAllTrips(int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $trips = $user->trips->toArray();
            
            return $trips;
        }
        
        public function addTrip(int $id) {
            
        }
    }
?>