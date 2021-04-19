<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vin'               => 'required|string|unique:vehicles,vin',
            'make_and_model'    => 'required|string',
            'transmission'      => 'required|string',
            'fuel_type'         => 'required|string',
            'mileage'           => 'required|string',
            'car_type'          => 'required|string',
            'license_plate'     => 'nullable|string',
            'color'             => 'nullable|string',
            'drive_type'        => 'nullable|string',
            'doors'             => 'nullable|string',
            'kilometrage'       => 'nullable|string',
            'car_options'       => 'required|array',
            'specs'             => 'required|array',
        ];
    }
}
