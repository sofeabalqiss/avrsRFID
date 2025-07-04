<?php

// app/Http/Controllers/Admin/VisitorLogController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Visit;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorLogController extends Controller
{
     public function index(Request $request)
    {
        $query = Visit::with('visitor')->orderBy('created_at', 'desc');

        // Filter: Search by name or IC number
        if ($search = $request->input('search')) {
            $query->whereHas('visitor', function ($q) use ($search) {
                $q->where('name_printed', 'like', "%{$search}%")
                ->orWhere('ic_number', 'like', "%{$search}%");
            });
        }

        // Filter: Date from
        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        // Filter: Date to
        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // Filter: Visitor Type
        if ($visitorType = $request->input('visitor_type')) {
            $query->whereHas('visitor', function ($q) use ($visitorType) {
                $q->where('visitor_type', $visitorType);
            });
        }

        // Filter: Status (Checked-In / Checked-Out)
        if ($status = $request->input('status')) {
            if ($status === 'Checked-In') {
                $query->whereNull('check_out');
            } elseif ($status === 'Checked-Out') {
                $query->whereNotNull('check_out');
            }
        }

        $visitorLogs = $query->paginate(10);

        return view('admin.visitor-logs.index', compact('visitorLogs'));
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'ic_number' => 'required|exists:visitors,ic_number',
            'notes' => 'nullable|string'
        ]);

        $visitor = Visitor::where('ic_number', $validated['ic_number'])->first();

        VisitorLog::create([
            'visitor_id' => $visitor->id,
            'user_id' => auth()->id(),
            'action' => 'check_in',
            'notes' => $validated['notes'] ?? null
        ]);

        return back()->with('success', 'Visitor checked in successfully');
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'ic_number' => 'required|exists:visitors,ic_number',
            'notes' => 'nullable|string'
        ]);

        $visitor = Visitor::where('ic_number', $validated['ic_number'])->first();

        VisitorLog::create([
            'visitor_id' => $visitor->id,
            'user_id' => auth()->id(),
            'action' => 'check_out',
            'notes' => $validated['notes'] ?? null
        ]);

        return back()->with('success', 'Visitor checked out successfully');
    }

    public function currentVisitors()
    {
        $visitors = Visitor::whereHas('logs', function($query) {
            $query->where('action', 'check_in')
                ->whereNotIn('visitor_id', function($subQuery) {
                    $subQuery->select('visitor_id')
                        ->from('visitor_logs')
                        ->where('action', 'check_out');
                });
        })->with(['logs' => function($query) {
            $query->where('action', 'check_in')
                ->latest()
                ->limit(1);
        }])->paginate(10);

        return view('admin.visitors.current', compact('visitors'));
    }
}
