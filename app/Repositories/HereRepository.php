<?php
    namespace App\Repositories;
    class HereRepository {
        static $app_id = 'Nq8Tkg61stTaV5gAT5jv';
        static $app_code = 'aI_Q8jPEQgQxojt0rJrJiA';
        
        public function getLatitudeLongitude(string $address) {
            $url = "https://geocoder.api.here.com/6.2/geocode.json?searchtext=".urlencode($address)."&app_id=".self::$app_id."&app_code=".self::$app_code."&gen=9";
            
            $contents = json_decode(file_get_contents($url), true);

            if(count($contents['Response']['View']) == 0) {
                return [];   
            }
            //echo "<pre>"; print_r($contents); echo "</pre>";

            $latitude = $contents['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Latitude'];
            $longitude = $contents['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Longitude'];
            
            return [
                'latitude' => $latitude,
                'longtitude' => $longitude,
                ];
        }
        
        public function getTrip(string $startAddress, string $endAddress, string $transportType, string $fuelType = null, float $fuelConsumption = null) {
            $startResult = $this->getLatitudeLongitude($startAddress);
            $startLatitude = $startResult['latitude'];
            $startLongitude = $startResult['longtitude'];
            
            $endResult = $this->getLatitudeLongitude($endAddress);
            $endLatitude = $endResult['latitude'];
            $endLongtitude = $endResult['longtitude'];
            
            $mode='fastest';
            $traffic = 'enabled';
            
            $url = 'https://route.api.here.com/routing/7.2/calculateroute.json?app_id='.self::$app_id.'&app_code='.self::$app_code
            .'&waypoint0='."geo!$startLatitude,$startLongitude".'&waypoint1='."geo!$endLatitude,$endLongtitude"."&mode=$mode;$transportType;traffic:$traffic";
            
            if($transportType == 'car') {
                $url = "$url&vehicletype=$fuelType,$fuelConsumption";
            }
            
            $contents = json_decode(file_get_contents($url), true);
            //echo "<pre>"; print_r($contents); echo "</pre>";
            
            $result['distance'] = $contents['response']['route'][0]['summary']['distance'];
            $result['travelTime'] = $contents['response']['route'][0]['summary']['travelTime'];
            if(isset( $contents['response']['route'][0]['summary']['co2Emission'])) {
                $result['co2Emission'] =  $contents['response']['route'][0]['summary']['co2Emission'];
            }
            
            return $result;
        }
    }
?>