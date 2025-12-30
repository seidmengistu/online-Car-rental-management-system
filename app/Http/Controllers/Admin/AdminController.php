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
use App\Models\ActivityLog;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_customers' => User::whereHas('role', function ($query) {
                $query->where('name', 'customer');
            })->count(),
            'total_staff' => User::whereHas('role', function ($query) {
                $query->where('name', 'staff');
            })->count(),
            'total_managers' => User::whereHas('role', function ($query) {
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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role if provided
        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
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

        ActivityLog::log('user_create', "Created new user: {$user->name} ({$user->email})", $user);

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

        ActivityLog::log('user_update', "Updated user details for: {$user->name}", $user);

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

        ActivityLog::log('user_delete', "Deleted user: {$user->name} ({$user->email})", null, ['deleted_user_id' => $user->id]);

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
        ActivityLog::log('user_status_update', "User {$user->name} was {$status}", $user);

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

        ActivityLog::log('user_password_reset', "Reset password for user: {$user->name}", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User password reset successfully!');
    }

    /**
     * Show reports page
     */
    public function reports(Request $request)
    {
        // Check if user is super admin (should not see rental details)
        $isSuperAdmin = auth()->user()->isSuperAdmin();

        // Handle export requests
        if ($request->filled('export')) {
            // Prevent super admin from exporting rental data
            if ($isSuperAdmin && in_array($request->export, ['rentals'])) {
                return redirect()->back()->with('error', 'Access denied. Administrators cannot access rental data.');
            }
            return $this->handleExport($request->export);
        }

        // Basic stats
        $totalUsers = User::count();
        $totalCars = Car::count();
        $totalReservations = Reservation::count();

        // Only show rental data to staff and managers, not super admin
        $totalRentals = $isSuperAdmin ? null : Rental::count();

        // Monthly revenue data for chart (only for staff/manager)
        $monthlyRevenue = [];
        if (!$isSuperAdmin) {
            for ($i = 1; $i <= 12; $i++) {
                $month = now()->setMonth($i)->startOfMonth();
                $revenue = Rental::whereYear('created_at', now()->year)
                    ->whereMonth('created_at', $i)
                    ->sum('total_amount');
                $monthlyRevenue[] = $revenue;
            }
        }

        // Reservation status counts for pie chart
        $reservationStatusCounts = [
            Reservation::where('status', 'pending')->count(),
            Reservation::where('status', 'confirmed')->count(),
            Reservation::where('status', 'cancelled')->count(),
            Reservation::where('status', 'completed')->count()
        ];

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalCars',
            'totalReservations',
            'totalRentals',
            'monthlyRevenue',
            'reservationStatusCounts',
            'isSuperAdmin'
        ));
    }

    /**
     * Handle export requests
     */
    protected function handleExport(string $type)
    {
        $filename = $type . '_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = match ($type) {
            'users' => $this->exportUsers(),
            'cars' => $this->exportCars(),
            'reservations' => $this->exportReservations(),
            'rentals' => $this->exportRentals(),
            default => null,
        };

        if (!$callback) {
            return redirect()->back()->with('error', 'Invalid export type.');
        }

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export users to CSV
     */
    protected function exportUsers(): callable
    {
        return function () {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Role',
                'Status',
                'Address',
                'City',
                'State',
                'ZIP Code',
                'Country',
                'Date of Birth',
                'License Number',
                'License Expiry',
                'Created At',
            ]);

            // Data rows
            User::with('role')->chunk(100, function ($users) use ($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone,
                        $user->role->display_name ?? 'N/A',
                        $user->is_active ? 'Active' : 'Inactive',
                        $user->address,
                        $user->city,
                        $user->state,
                        $user->zip_code,
                        $user->country,
                        $user->date_of_birth?->format('Y-m-d'),
                        $user->driving_license_number,
                        $user->driving_license_expiry?->format('Y-m-d'),
                        $user->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        };
    }

    /**
     * Export cars to CSV
     */
    protected function exportCars(): callable
    {
        return function () {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'ID',
                'Plate Number',
                'Make',
                'Model',
                'Year',
                'Color',
                'Seats',
                'Transmission',
                'Fuel Type',
                'Daily Rate',
                'Weekly Rate',
                'Monthly Rate',
                'Status',
                'Available',
                'Mileage',
                'Description',
                'Created At',
            ]);

            // Data rows
            Car::chunk(100, function ($cars) use ($file) {
                foreach ($cars as $car) {
                    fputcsv($file, [
                        $car->id,
                        $car->plate_number,
                        $car->make,
                        $car->model,
                        $car->year,
                        $car->color,
                        $car->seats,
                        $car->transmission,
                        $car->fuel_type,
                        $car->daily_rate,
                        $car->weekly_rate,
                        $car->monthly_rate,
                        $car->status ?? 'available',
                        $car->is_available ? 'Yes' : 'No',
                        $car->mileage,
                        $car->description,
                        $car->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        };
    }

    /**
     * Export reservations to CSV
     */
    protected function exportReservations(): callable
    {
        return function () {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'ID',
                'Customer Name',
                'Customer Email',
                'Car',
                'Plate Number',
                'Start Date',
                'End Date',
                'Total Days',
                'Total Amount',
                'Status',
                'Payment Status',
                'Payment Reference',
                'Payment Method',
                'Created At',
            ]);

            // Data rows
            Reservation::with(['user', 'car'])->chunk(100, function ($reservations) use ($file) {
                foreach ($reservations as $reservation) {
                    $days = $reservation->start_date->diffInDays($reservation->end_date) + 1;
                    fputcsv($file, [
                        $reservation->id,
                        $reservation->user->name ?? 'N/A',
                        $reservation->user->email ?? 'N/A',
                        $reservation->car->full_name ?? 'N/A',
                        $reservation->car->plate_number ?? 'N/A',
                        $reservation->start_date->format('Y-m-d'),
                        $reservation->end_date->format('Y-m-d'),
                        $days,
                        $reservation->total_amount,
                        ucfirst($reservation->status),
                        ucfirst($reservation->payment_status ?? 'pending'),
                        $reservation->payment_reference,
                        $reservation->payment_method,
                        $reservation->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        };
    }

    /**
     * Export rentals to CSV
     */
    protected function exportRentals(): callable
    {
        return function () {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'ID',
                'Reservation ID',
                'Customer Name',
                'Customer Email',
                'Car',
                'Plate Number',
                'Start Date',
                'End Date',
                'Actual End Date',
                'Total Days',
                'Total Amount',
                'Status',
                'Overdue Days',
                'Overdue Fee',
                'Overdue Payment Status',
                'Return Verified At',
                'Created At',
            ]);

            // Data rows
            Rental::with(['user', 'car', 'reservation'])->chunk(100, function ($rentals) use ($file) {
                foreach ($rentals as $rental) {
                    $days = $rental->start_date->diffInDays($rental->end_date) + 1;
                    fputcsv($file, [
                        $rental->id,
                        $rental->reservation_id,
                        $rental->user->name ?? 'N/A',
                        $rental->user->email ?? 'N/A',
                        $rental->car->full_name ?? 'N/A',
                        $rental->car->plate_number ?? 'N/A',
                        $rental->start_date->format('Y-m-d'),
                        $rental->end_date->format('Y-m-d'),
                        $rental->actual_end_date?->format('Y-m-d H:i:s'),
                        $days,
                        $rental->total_amount,
                        ucfirst($rental->status),
                        $rental->overdue_days ?? 0,
                        $rental->overdue_fee ?? 0,
                        ucfirst($rental->overdue_payment_status ?? 'not_required'),
                        $rental->return_verified_at?->format('Y-m-d H:i:s'),
                        $rental->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        };
    }
}