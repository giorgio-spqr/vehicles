<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Resources\VehicleCollectionResource;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\RandomDataApi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $vehicles = Vehicle::query()->with(['specifications', 'car_options'])->get();
        return new VehicleCollectionResource($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(VehicleStoreRequest $request)
    {
        $vehicle = DB::transaction(function () use ($request) {
            /** @var Vehicle $vehicle */
            $vehicle = Vehicle::query()->create($request->validated());
            $vehicle->specifications()->createMany($request->input('specs'));
            $vehicle->car_options()->createMany($request->input('car_options'));

            return $vehicle;
        });

        return new VehicleResource($vehicle);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     */
    public function show(string $vin)
    {
        $vehicle = Vehicle::query()
            ->where(['vin' => $vin])
            ->with(['specifications'])
            ->firstOrFail();

        return response()->json($vehicle->specifications->pluck('name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $vin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VehicleUpdateRequest $request, string $vin)
    {
        $vehicle = Vehicle::query()
            ->where(['vin' => $vin])
            ->with(['car_options', 'specifications'])
            ->firstOrFail();

        if ($vehicle->is_imported) {
            abort(403);
        }

        $result = DB::transaction(function () use ($request, $vehicle) {
            $vehicle->update($request->validated());

            $vehicle->specifications()->delete();
            $vehicle->car_options()->delete();

            $vehicle->specifications()->createMany($request->input('specs'));
            $vehicle->car_options()->createMany($request->input('car_options'));

            return $vehicle;
        });

        return new VehicleResource($result);
    }

    /**
     * @param string $vin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $vin)
    {
        $vehicle = Vehicle::query()->where(['vin' => $vin])->firstOrFail();
        if ($vehicle->is_imported) {
            abort(403);
        }
        $vehicle->delete();

        return response()->json('Deleted successfully');
    }
}
