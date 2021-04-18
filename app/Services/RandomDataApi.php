<?php

namespace App\Services;

use GuzzleHttp\Client;

class RandomDataApi
{
    protected $domain;

    public function __construct()
    {
        $this->domain = config('services.vehicle_provider.domain');
    }

    /**
     * Undocumented function
     *
     * @param integer $count - count of vehicles to get
     */
    public function getVehicles(int $count = 100)
    {
        $http_client = new Client();

        $response = $http_client->get($this->domain . '/vehicle/random_vehicle', [
            'verify' => false,
            'query' => [
                'size' => $count,
                'is_xml' => 'true'
            ]
        ]);
        $xml = simplexml_load_string($response->getBody());
        $vehicles = (array)$xml;
        $data = [];
        $i = 0;

        for ($i = 0; $i < $count; $i++) {
            $vehicle = $vehicles['object'][$i];

            $data[$i]['vin']              = (string) $vehicle->vin;
            $data[$i]['make_and_model']   = (string) $vehicle->{'make-and-model'};
            $data[$i]['color']            = (string) $vehicle->color;
            $data[$i]['transmission']     = (string) $vehicle->transmission;
            $data[$i]['drive_type']       = (string) $vehicle->{'drive-type'};
            $data[$i]['fuel_type']        = (string) $vehicle->{'fuel-type'};
            $data[$i]['car_type']         = (string) $vehicle->{'car-type'};
            $data[$i]['doors']            = (string) $vehicle->doors;
            $data[$i]['mileage']          = (string) $vehicle->mileage;
            $data[$i]['kilometrage']      = (string) $vehicle->kilometrage;
            $data[$i]['license_plate']    = (string) $vehicle->{'license-plate'};
            $data[$i]['car_options']      = (array) $vehicle->{'car-type'};
            $data[$i]['specifications']   = (array) $vehicle->specs->spec;
        }
        return $data;
    }
}
