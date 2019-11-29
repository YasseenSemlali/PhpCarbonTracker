<?php
    namespace App\Repositories;
    //https://developer.here.com/documentation/routing/dev_guide/topics/resource-param-type-vehicle-type.html
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
        
        public function getTrip(float $startLatitude, float $startLongitude,float $endLatitude,float $endLongtitude, string $transportType, string $fuelType = null, float $fuelConsumption = null) {
            
            $mode='fastest';
            $traffic = 'enabled';
            
            $baseUrl = 'https://route.api.here.com/routing/7.2/calculateroute.json';
            $query_array = array (
                'app_code' => self::$app_code,
                'app_id' => self::$app_id,
                'waypoint0' =>  'geo!'.$startLatitude.','.$startLongitude,
                'waypoint1' => 'geo!'.$endLatitude.','.$endLongtitude,
                'mode' => 'fastest;'.$transportType.';traffic:'.$traffic,
            );
            
            if($transportType == 'car') {
                $query_array['vehicletype'] = "$fuelType,$fuelConsumption";
            }
            
            $query = $baseUrl.'?'.http_build_query($query_array);
            $contents = json_decode($this->makeRequest($query), true);
            
            //echo "<pre>"; print_r($contents); echo "</pre>";
            
            $result['distance'] = $contents['response']['route'][0]['summary']['distance'];
            $result['travelTime'] = $contents['response']['route'][0]['summary']['travelTime'];
            if(isset( $contents['response']['route'][0]['summary']['co2Emission'])) {
                $result['co2Emission'] =  $contents['response']['route'][0]['summary']['co2Emission'];
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