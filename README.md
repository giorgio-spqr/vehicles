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

* In `app/console/Commands/VehicleProviderSync.php` we make specify artisan command to sync with external API

* In `app/Services/RandomDataApi.php` we define logic how to fetch data from provider (external API)
