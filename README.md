## Installations steps

1. Place project to some directory and enter to it

2. Run composer to install dependencies  
```bash
    composer install
```

3. Copy .env file and edit DB credentials
```bash
    cp .env.example .env
    nano .env
```

4. Generate app key
```bash
    php artisan key:generate
```

5. Run migrations
```bash
    php artisan migrate
```

## Sync data with RandomDataAPI

Run command below
```bash
    php artisan vehicle:sync_with_provider
```

## Some info

* In .env we have `RANDOM_DATA_API_URL` where we specify the url of provider

* In `config/services.php` file we specify our default provider
```php
    'vehicle_provider' => [
       'domain' => env('RANDOM_DATA_API_URL'),
    ]
```

* In `app/console/Commands/VehicleProviderSync.php` artisan command to sync with external API

* In `app/Services/RandomDataApi.php` defining logic how to fetch data from provider (external API)

## API description

* "/" GET - Get list of all vehicles

* "/" POST - Add information about new vehicle

* "/{vin}" GET - Get vehicle extras by VIN

* "/{vin}" PATCH - Update vehicle information by VIN (only for vehicles added through API)

* "/{vin}" DELETE - Delete vehicle info

## JSON example for creating vehicle

```json
{
    "vin": "12344FDDSAFH243442",
    "make_and_model": "Audi Q7",
    "color": "grey",
    "transmission": "manual",
    "drive_type": "drive_type",
    "fuel_type": "petrol",
    "car_type": "SUV",
    "doors": "4 doors",
    "mileage": "100000",
    "kilometrage": "150000",
    "license_plate": "HM-4324",
    "car_options": [
        {"name": "option 1"},
        {"name": "option 2"}
    ],
    "specs": [
        {"name": "spec 1"},
        {"name": "spec 2"},
        {"name": "spec 3"}
    ]
}
```
