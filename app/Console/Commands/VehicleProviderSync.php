<?php

namespace App\Console\Commands;

use App\Models\Specification;
use App\Models\Vehicle;
use App\Services\RandomDataApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VehicleProviderSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicle:sync_with_provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command syncs all DB data with external data source';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = new RandomDataApi();
        $response_array = $provider->getVehicles(2);

        $vins = DB::transaction(function () use ($response_array) {
            $vins = [];

            foreach ($response_array as $v) {
                $vins[] = $v['vin'];
                $vehicle = Vehicle::query()->updateOrCreate(['vin' => $v['vin']], $v);
                foreach ($v['specifications'] as $spec) {
                    $vehicle->specifications()->create(['name' => $spec]);
                }
                foreach ($v['car_options'] as $option) {
                    $vehicle->car_options()->create(['name' => $option]);
                }
            }

            return $vins;
        });

        //collect vehicles' vin
        foreach ($response_array as $v) {
            $vins[] = $v['vin'];
        }

        //Delete vehicles that are not present anymore by external provider
        DB::transaction(function () use ($vins) {
            Vehicle::query()->whereNotIn('vin', $vins)->delete();

        });

        return 1;
    }
}
