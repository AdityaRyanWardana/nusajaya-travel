<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Models\Armada;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('armada')->latest()->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $armadas = Armada::all();
        return view('admin.vehicles.create', compact('armadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'plate_number' => 'required|string|max:255|unique:vehicles',
            'mirror_number' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
            'notes' => 'nullable|string'
        ]);

        Vehicle::create($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle unit added successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        $armadas = Armada::all();
        return view('admin.vehicles.edit', compact('vehicle', 'armadas'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $vehicle->id,
            'mirror_number' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
            'notes' => 'nullable|string'
        ]);

        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle unit updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle unit deleted successfully.');
    }
}
