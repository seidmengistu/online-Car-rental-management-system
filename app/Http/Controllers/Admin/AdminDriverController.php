<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class AdminDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $drivers = $query->latest()->paginate(10);

        return view('admin.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|unique:drivers,license_number',
            'status' => 'required|in:active,inactive,on_trip',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('drivers', 'public');
        }

        Driver::create($validated);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return view('admin.drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|unique:drivers,license_number,' . $driver->id,
            'status' => 'required|in:active,inactive,on_trip',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('drivers', 'public');
        }

        $driver->update($validated);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
