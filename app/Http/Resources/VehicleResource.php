<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vin' => $this->vin,
            'make_and_model' => $this->make_and_model,
            'color' => $this->color,
            'transmission' => $this->transmission,
            'drive_type' => $this->drive_type,
            'fuel_type' => $this->fuel_type,
            'car_type' => $this->car_type,
            'doors' => $this->doors,
            'mileage' => $this->mileage,
            'kilometrage' => $this->kilometrage,
            'license_plate' => $this->license_plate,
            'car_options' => CarOptionResource::collection($this->car_options),
            'specs' => SpecificationResource::collection($this->specifications),
        ];
    }
}
