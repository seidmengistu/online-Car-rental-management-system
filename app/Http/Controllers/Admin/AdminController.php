<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_customers' => User::whereHas('role', function($query) {
                $query->where('name', 'customer');
            })->count(),
            'total_staff' => User::whereHas('role', function($query) {
                $query->where('name', 'staff');
            })->count(),
            'total_managers' => User::whereHas('role', function($query) {
                $query->where('name', 'manager');
            })->count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show all users
     */
    public function users(Request $request)
    {
        $query = User::with('role');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by role if provided
        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show user creation form
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => 'required|exists:roles,id',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'date_of_birth' => 'nullable|date|before:today',
            'driving_license_number' => 'nullable|string|max:50|unique:users',
            'driving_license_expiry' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'date_of_birth' => $request->date_of_birth,
            'driving_license_number' => $request->driving_license_number,
            'driving_license_expiry' => $request->driving_license_expiry,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show user edit form
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'date_of_birth' => 'nullable|date|before:today',
            'driving_license_number' => 'nullable|string|max:50|unique:users,driving_license_number,' . $user->id,
            'driving_license_expiry' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'date_of_birth' => $request->date_of_birth,
            'driving_license_number' => $request->driving_license_number,
            'driving_license_expiry' => $request->driving_license_expiry,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own account!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.users.index')
            ->with('success', "User {$status} successfully!");
    }

    /**
     * Reset user password
     */
    public function resetUserPassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('password'));
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User password reset successfully!');
    }
    
    /**
     * Show reports page
     */
    public function reports(Request $request)
    {
        // Basic stats
        $totalUsers = User::count();
        $totalCars = Car::count();
        $totalReservations = Reservation::count();
        $totalRentals = Rental::count();
        
        // Monthly revenue data for chart
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = now()->setMonth($i)->startOfMonth();
            $revenue = Rental::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->sum('total_amount');
            $monthlyRevenue[] = $revenue;
        }
        
        // Reservation status counts for pie chart
        $reservationStatusCounts = [
            Reservation::where('status', 'pending')->count(),
            Reservation::where('status', 'confirmed')->count(),
            Reservation::where('status', 'cancelled')->count(),
            Reservation::where('status', 'completed')->count()
        ];
        
        // Handle export requests
        if ($request->filled('export')) {
            // Here you would implement the export functionality
            // For now, just redirect back with a message
            return redirect()->back()->with('info', 'Export functionality coming soon!');
        }
        
        return view('admin.reports.index', compact(
            'totalUsers', 
            'totalCars', 
            'totalReservations', 
            'totalRentals',
            'monthlyRevenue',
            'reservationStatusCounts'
        ));
    }
} 