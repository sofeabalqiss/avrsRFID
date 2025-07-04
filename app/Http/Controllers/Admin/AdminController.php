<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Visitor;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Admin Dashboard Page
    public function index()
    {
        // Set timezone to Malaysia
        config(['app.timezone' => 'Asia/Kuala_Lumpur']);
        $today = Carbon::today();

        // Get visitor counts
        $totalVisitors = Visitor::count();
        $newVisitorsToday = Visitor::whereDate('created_at', $today)->count();

        // Get visit counts
        $totalCheckInsToday = Visit::whereDate('check_in', $today)->count();
        $totalCheckOutsToday = Visit::whereNotNull('check_out')
            ->whereDate('check_out', $today)
            ->count();

        // Get peak hours data (all 24 hours)
        $peakHours = array_fill_keys(range(0, 23), 0);
        $dbPeakHours = Visit::whereDate('check_in', $today)
            ->selectRaw('HOUR(check_in) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();
        $peakHours = array_merge($peakHours, $dbPeakHours);

        // Get visitor types with fallback data
        $visitorTypes = Visitor::whereNotNull('visitor_type')
            ->selectRaw('visitor_type, COUNT(*) as count')
            ->groupBy('visitor_type')
            ->pluck('count', 'visitor_type')
            ->toArray();

        // If no visitor types exist, use sample data
        if (empty($visitorTypes)) {
            $visitorTypes = [
                'Regular' => rand(20, 50),
                'Guest' => rand(10, 30),
                'VIP' => rand(5, 15)
            ];
        }

        // Return the admin dashboard view with data
        return view('admin.dashboard', [
            'totalVisitors' => $totalVisitors,
            'newVisitorsToday' => $newVisitorsToday,
            'totalCheckInsToday' => $totalCheckInsToday,
            'totalCheckOutsToday' => $totalCheckOutsToday,
            'peakHours' => $peakHours,
            'visitorTypes' => $visitorTypes
        ]);
    }

    // Admins Management - List all admins
    public function showAdmins()
    {
        $admins = Admin::paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    // Create Admin - Show the create form
    public function create()
    {
        return view('admin.admins.create');
    }

    // Store Admin - Create a new admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    // Edit Admin - Show the edit form
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    // Update Admin - Save the changes for an admin
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    // Delete Admin
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully.');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Handle Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withInput()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // Handle Admin Logout
    public function logout()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
