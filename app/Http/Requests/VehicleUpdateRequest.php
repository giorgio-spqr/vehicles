<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'make_and_model'    => 'nullable|string',
            'transmission'      => 'nullable|string',
            'fuel_type'         => 'nullable|string',
            'mileage'           => 'nullable|string',
            'license_plate'     => 'nullable|string',
            'color'             => 'nullable|string',
            'drive_type'        => 'nullable|string',
            'car_type'          => 'nullable|string',
            'doors'             => 'nullable|string',
            'kilometrage'       => 'nullable|string',
            'car_options'       => 'nullable|array',
            'specs'             => 'nullable|array',
        ];
    }
}
