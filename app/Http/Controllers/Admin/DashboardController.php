<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Visit;
use Carbon\Carbon;

class DashboardController extends Controller
{
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

        $sevenDaysAgo = now()->subDays(7);

        $peakHours = array_fill_keys(range(0, 23), 0);
        $dbPeakHours = Visit::where('check_in', '>=', $sevenDaysAgo)
            ->selectRaw('HOUR(check_in) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        foreach ($dbPeakHours as $hour => $count) {
            $peakHours[$hour] = $count;
        }


        // Get visitor types with fallback data
        $visitorTypes = Visitor::whereNotNull('visitor_type')
            ->selectRaw('visitor_type, COUNT(*) as count')
            ->groupBy('visitor_type')
            ->pluck('count', 'visitor_type')
            ->toArray();

        if (empty($visitorTypes)) {
            $visitorTypes = [
                'technician' => rand(10, 30),
                'food delivery guy' => rand(10, 30),
                'parcel delivery guy' => rand(10, 30),
                'others' => rand(5, 15),
            ];
        }

        return view('admin.dashboard', [
            'totalVisitors' => $totalVisitors,
            'newVisitorsToday' => $newVisitorsToday,
            'totalCheckInsToday' => $totalCheckInsToday,
            'totalCheckOutsToday' => $totalCheckOutsToday,
            'peakHours' => $peakHours,
            'visitorTypes' => $visitorTypes
        ]);
    }
}
