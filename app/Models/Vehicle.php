<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $vin
 * @property string $make_and_model
 * @property string $color
 * @property string $transmission
 * @property string $drive_type
 * @property string $fuel_type
 * @property string $car_type
 * @property string $doors
 * @property string $mileage
 * @property string $kilometrage
 * @property string $license_plate
 *
 * @property Specification $specifications
 * @property CarOption $car_options
 */
class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vin',
        'make_and_model',
        'color',
        'transmission',
        'drive_type',
        'fuel_type',
        'car_type',
        'doors',
        'mileage',
        'kilometrage',
        'license_plate',
        'is_imported',
    ];

    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }

    public function car_options()
    {
        return $this->hasMany(CarOption::class);
    }
}
