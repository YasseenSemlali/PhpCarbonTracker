<?php 
    namespace App\Repositories;
    use Illuminate\Support\Facades\Auth;

    use App\Trip;
    use App\User;
    use DB;
use App\Repositories\HereRepository;

    class TripRepository {
        private $here;
        
        public function __construct(HereRepository $here) {
            $this->here = $here;
        }
        
        public function getAllTrips(User $user,int $paginate) {
            $trips = $user->trips()->orderBy('created_at', 'DESC')->paginate($paginate);

            return $trips;
        }
        
        public function addTrip(User $user, float $fromLatitude, float $fromLongtude, float $toLatitude, float $toLongtude, string $transportType, string $fuelType = null, float $fuelConsumption = null) {
            $tripInfo = $this->here->getTrip($fromLatitude, $fromLongtude, $toLatitude, $toLongtude, $transportType, $fuelType, $fuelConsumption);
            
            if(empty($tripInfo)) {
                return [];
            }
            
            $trip = new Trip;
            
            $trip -> start_latitude = $fromLatitude;
            $trip -> start_longitude = $fromLongtude;
            $trip -> end_latitude = $toLatitude;
            $trip -> end_longitude = $toLongtude;
            $trip -> mode = $transportType;
            $trip -> engine = $fuelType;
            $trip -> travelTime = $tripInfo['travelTime'];
            $trip -> distance = $tripInfo['distance'];
            $trip -> co2emissions = $tripInfo['co2emissions'];
            $trip -> user_id = $user->id;
            
            $trip->save();
            
            return $trip;
        }
        
        public function totalDistance(User $user) {
            $sum = $user->trips()->sum('distance');
            
            return $sum;
        }
        
        public function totalCO2(User $user) {
            $sum = $user->trips()->sum('co2emissions');
            
            return $sum;
        }
        
        public function totalCostToOffsetCO2(User $user) {
            $sum = $user->trips()->sum('co2emissions');
            
            return $sum * 30 / 1000;
        }
        
        public function getAllRecentLocations(User $user){
             $locations =  db::table('locations')->select('name')->distinct()->get();
             
            return $locations;
        }
    }
?>