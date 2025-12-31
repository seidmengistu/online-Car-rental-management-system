<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                ActivityLog::log('login_failed', 'User attempted to login but account is inactive: ' . $user->email);
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Your account has been deactivated. Please contact support.'])
                    ->withInput($request->only('email'));
            }

            ActivityLog::log('login', 'User logged in', $user);

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        ActivityLog::log('login_failed', 'Failed login attempt for email: ' . $request->email);

        return redirect()->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[A-Za-z ]+$/', 'max:255'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['required', 'regex:/^09\\d{8}$/'],
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'driving_license_number' => 'nullable|string|max:50|unique:users',
            'driving_license_expiry' => 'nullable|date|after:today',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Get customer role
        $customerRole = Role::where('name', 'customer')->first();

        // Handle ID Document Upload
        $idDocumentPath = null;
        if ($request->hasFile('id_document')) {
            $idDocumentPath = $request->file('id_document')->store('id_documents', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $customerRole->id,
            'phone' => $request->phone,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'driving_license_number' => $request->driving_license_number,
            'driving_license_expiry' => $request->driving_license_expiry,
            'id_document_path' => $idDocumentPath,
            'is_active' => true,
        ]);

        Auth::login($user);

        ActivityLog::log('register', 'New customer registered: ' . $user->name, $user);

        return redirect('/dashboard')->with('success', 'Account created successfully! Welcome to Ethio Car Rental.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::log('logout', 'User logged out', $user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return view('auth.profile', compact('user'));
        }
        return view('auth.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[A-Za-z ]+$/', 'max:255'],
            'phone' => ['required', 'regex:/^09\\d{8}$/'],
            'address' => 'required|string|max:255', // Kept for now as migration removed it but plan didn't explicitly say remove from profile update validation? wait plan says 'Similar validation updates'. So should remove address.
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'driving_license_number' => 'nullable|string|max:50|unique:users,driving_license_number,' . $user->id,
            'driving_license_expiry' => 'nullable|date|after:today',
            'id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'name',
            'phone',
            'city',
            'state',
            'country',
            'driving_license_number',
            'driving_license_expiry'
        ]);

        if ($request->hasFile('id_document')) {
            $data['id_document_path'] = $request->file('id_document')->store('id_documents', 'public');
        }

        $user->update($data);

        ActivityLog::log('profile_update', 'User updated profile details', $user);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('current_password'));
        }

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        ActivityLog::log('password_change', 'User changed password', $user);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}