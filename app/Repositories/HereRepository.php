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
                'longitude' => $longitude,
                ];
        }
        
        public function getTrip(float $startLatitude, float $startLongitude,float $endLatitude,float $endlongitude, string $transportType, string $fuelType = null, float $fuelConsumption = null) {
            
            $traffic = 'enabled';
            
            $baseUrl = 'https://route.api.here.com/routing/7.2/calculateroute.json';
            
            if($transportType == 'carpool') {
                $mode='fastest;car;traffic:'.$traffic;
            } else {
                $mode='fastest;'.$transportType.';traffic:'.$traffic;
            }
            
            
            $query_array = array (
                'app_code' => self::$app_code,
                'app_id' => self::$app_id,
                'waypoint0' =>  'geo!'.$startLatitude.','.$startLongitude,
                'waypoint1' => 'geo!'.$endLatitude.','.$endlongitude,
                'mode' => $mode,
            );
            
            if($transportType == 'car' || $transportType == 'carpool') {
                $query_array['vehicletype'] = "$fuelType,$fuelConsumption";
            }
            
            $query = $baseUrl.'?'.http_build_query($query_array);
            $contents = json_decode($this->makeRequest($query), true);
            
            if(!isset($contents['response'])) {
                return [];
            }
            
            $result['distance'] = $contents['response']['route'][0]['summary']['distance'];
            $result['travelTime'] = $contents['response']['route'][0]['summary']['travelTime'];
            
             $result['co2emissions']=0;
            if ($transportType == 'publicTransport') {
                 $result['co2emissions']=  $result['distance'] / 1000 * 0.0462;
            } else if (isset( $contents['response']['route'][0]['summary']['co2Emission']) && $transportType == 'carpool') {
                 $result['co2emissions'] =  $contents['response']['route'][0]['summary']['co2Emission'] / 3;
            }
            else if(isset( $contents['response']['route'][0]['summary']['co2Emission'])) {
                $result['co2emissions'] =  $contents['response']['route'][0]['summary']['co2Emission'];
            } 
            
            return $result;
        }
        
        private function makeRequest($url) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;
        }
    }
?>