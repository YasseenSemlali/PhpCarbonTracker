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
        
        public function getAllTrips(int $paginate, int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $trips = $user->trips()->orderBy('created_at')->paginate($paginate);
            //var_dump($trips->toArray());
            return $trips;
        }
        
        public function addTrip(float $fromLatitude, float $fromLongtude, float $toLatitude, float $toLongtude, string $transportType, string $fuelType = null, float $fuelConsumption = null, int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $tripInfo = $this->here->getTrip($fromLatitude, $fromLongtude, $toLatitude, $toLongtude, $transportType, $fuelType, $fuelConsumption);
            
            $trip = new Trip;
            
            $trip -> start_lattitude = $fromLatitude;
            $trip -> start_longtitude = $fromLongtude;
            $trip -> end_lattitude = $toLatitude;
            $trip -> end_longtitude = $toLongtude;
            $trip -> mode = $transportType;
            $trip -> engine = $fuelType;
            $trip -> travelTime = $tripInfo['travelTime'];
            $trip -> distance = $tripInfo['distance'];
            $trip -> co2emissions = $tripInfo['co2Emission'];
            $trip -> user_id = $user->id;
            
            $trip->save();
            
            return $trip;
        }
        
        public function totalDistance(int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $sum = $user->trips()->sum('distance');
            
            return $sum;
        }
        
        public function totalCO2(int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $sum = $user->trips()->sum('co2emissions');
            
            return $sum;
        }
        
        public function totalCostToOffsetCO2(int $id = -1) {
            if($id == -1) {
                $user = Auth::user();
            } else {
                $user = User::findOrFail($id);
            }
            
            $sum = $user->trips()->sum('co2emissions');
            
            return $sum * 30 / 1000;
        }
    }
?>