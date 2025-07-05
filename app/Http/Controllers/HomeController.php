<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the home page with search functionality and available cars
     */
    public function index(Request $request)
    {
        $query = Car::where('is_available', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by make
        if ($request->filled('make')) {
            $query->where('make', 'like', '%' . $request->make . '%');
        }

        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Get available cars (limit to 6 for homepage)
        $cars = $query->orderBy('daily_rate', 'asc')->take(6)->get();

        // Get all makes for filter dropdown
        $makes = Car::where('is_available', true)
                   ->distinct()
                   ->pluck('make')
                   ->sort()
                   ->values();

        // Get car make statistics with counts
        $carMakes = Car::where('is_available', true)
                      ->select('make', DB::raw('count(*) as total_count'))
                      ->groupBy('make')
                      ->orderBy('total_count', 'desc')
                      ->get();

        return view('index', compact('cars', 'makes', 'carMakes'));
    }
} 