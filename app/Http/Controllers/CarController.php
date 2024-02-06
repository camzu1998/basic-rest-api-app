<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Car::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        Car::create($request->validated());

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function showFirst(string $type)
    {
        $car = Car::type($type)->firstOrFail();
        $car->name = $car->type == Car::DEFAULT_TYPES[0] ? Str::lower($car->name) : Str::upper($car->name);

        return response()->json($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return response('', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFirst(string $type)
    {
        Car::type($type)->firstOrFail()->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
