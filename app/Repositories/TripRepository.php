<?php 
    namespace App\Repositories;
    use Illuminate\Support\Facades\Auth;

    use App\Trip;
    use App\User;
use App\Repositories\HereRepository;

    class TripRepository {
        private $here;
        
        public function __construct(HereRepository $here) {
            $this->here = $here;
        }
        
        //tempoprary, make it take id as param later
        public function getAllTrips(int $paginate, int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $trips = $user->trips()->orderBy('created_at')->paginate($paginate);
            var_dump($trips->toArray());
            return $trips;
        }
        
        public function addTrip(float $fromLatitude, float $fromLongtude, float $toLatitude, float $toLongtude, string $transportType, string $fuelType = null, float $fuelConsumption = null, int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $trip = $this->here->getTrip($fromLatitude, $fromLongtude, $toLatitude, $toLongtude, $transportType, $fuelType, $fuelConsumption);
            var_dump($trip);
        }
    }
?>