<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class CarController extends Controller
{
    /**
     * Display a listing of cars for customers
     */
    public function index(Request $request)
    {
        $query = Car::query();
        
        // Filter by availability
        if ($request->filled('available')) {
            $query->where('is_available', true);
        }
        
        // Filter by make
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }
        
        // Filter by model
        if ($request->filled('model')) {
            $query->where('model', 'like', "%{$request->model}%");
        }
        
        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }
        
        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }
        
        // Filter by seats
        if ($request->filled('seats_min')) {
            $query->where('seats', '>=', $request->seats_min);
        }
        
        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('daily_rate', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $query->where('daily_rate', '<=', $request->price_max);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $cars = $query->where('is_available', true)
                     ->orderBy('make')
                     ->paginate(12);
        
        // Get unique makes and fuel types for filters
        $makes = Car::select('make')->distinct()->pluck('make');
        $fuelTypes = Car::select('fuel_type')->distinct()->pluck('fuel_type');
        $transmissions = Car::select('transmission')->distinct()->pluck('transmission');
        
        return view('cars.index', compact('cars', 'makes', 'fuelTypes', 'transmissions'));
    }

    /**
     * Display the specified car
     */
    public function show(Car $car)
    {
        $car->load(['reservations' => function ($query) {
            $query->where('status', '!=', 'cancelled');
        }, 'rentals' => function ($query) {
            $query->where('status', '!=', 'returned');
        }]);

        return view('cars.show', compact('car'));
    }

    /**
     * Admin: Show the form for creating a new car.
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.cars.create');
    }

    /**
     * Admin: Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20|unique:cars',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:30',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'transmission' => 'required|string|in:manual,automatic',
            'seats' => 'required|integer|min:1|max:50',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'mileage' => 'nullable|integer|min:0',
            'status' => 'required|string|in:available,maintenance,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'features' => 'nullable|array',
            'is_available' => 'boolean',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }
        
        // Set default rates if not provided
        if (!isset($validated['weekly_rate'])) {
            $validated['weekly_rate'] = $validated['daily_rate'] * 6; // 1 day free for weekly
        }
        
        if (!isset($validated['monthly_rate'])) {
            $validated['monthly_rate'] = $validated['daily_rate'] * 25; // 5 days free for monthly
        }
        
        // Create car
        $car = Car::create($validated);
        
        return redirect()->route('admin.cars.index')
            ->with('success', 'Car created successfully!');
    }

    /**
     * Admin: Show the form for editing the specified car.
     */
    public function edit(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Admin: Update the specified car in storage.
     */
    public function update(Request $request, Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $car->id,
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:30',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'transmission' => 'required|string|in:manual,automatic',
            'seats' => 'required|integer|min:1|max:50',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'mileage' => 'nullable|integer|min:0',
            'status' => 'required|string|in:available,maintenance,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'features' => 'nullable|array',
            'is_available' => 'boolean',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }
        
        // Set default rates if not provided
        if (!isset($validated['weekly_rate'])) {
            $validated['weekly_rate'] = $validated['daily_rate'] * 6; // 1 day free for weekly
        }
        
        if (!isset($validated['monthly_rate'])) {
            $validated['monthly_rate'] = $validated['daily_rate'] * 25; // 5 days free for monthly
        }
        
        // Update car
        $car->update($validated);
        
        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully!');
    }

    /**
     * Admin: Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if car is currently rented
        if ($car->rentals()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete car that is currently rented.');
        }
        
        // Delete image if exists
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        
        $car->delete();
        
        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully!');
    }

    /**
     * Admin: Toggle car availability.
     */
    public function toggleAvailability(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $car->update(['is_available' => !$car->is_available]);
        
        $status = $car->is_available ? 'available' : 'unavailable';
        return back()->with('success', "Car marked as {$status} successfully!");
    }

    /**
     * Admin: Display a listing of all cars.
     */
    public function adminIndex(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = Car::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by availability
        if ($request->filled('available')) {
            $query->where('is_available', $request->available == 'yes');
        }
        
        $cars = $query->orderBy('make')->paginate(15);
        
        return view('admin.cars.index', compact('cars'));
    }
}
