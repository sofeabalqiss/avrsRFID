<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Rfid;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    public function listVisits(Request $request, $type = 'checkins')
    {
        $query = Visit::with(['visitor' => function($query) {
            $query->select('id', 'name_printed', 'ic_number', 'visitor_type', 'house_number', 'vehicle_plate');
        }]);

        if ($type === 'checkins') {
            $visits = $query->orderBy('check_in', 'desc')->paginate(10);
            return view('checkins', ['checkins' => $visits]);
        }

        $visits = $query->whereNotNull('check_out')
                      ->orderBy('check_out', 'desc')
                      ->get();
        return view('checkout', ['checkouts' => $visits]);
    }

    public function index(Request $request)
    {
        $query = Visit::with('visitor')->latest('check_in');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('visitor', function($q) use ($search) {
                $q->where('name_printed', 'like', "%$search%")
                ->orWhere('ic_number', 'like', "%$search%")
                ->orWhere('house_number', 'like', "%$search%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'inside') {
                $query->whereNull('check_out');
            } elseif ($request->status === 'checked_out') {
                $query->whereNotNull('check_out');
            }
        }

        // Date range filter (corrected)
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('check_in', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay()
            ]);
        } else {
            if ($request->filled('date_from')) {
                $query->where('check_in', '>=', Carbon::parse($request->date_from)->startOfDay());
            }

            if ($request->filled('date_to')) {
                $query->where('check_in', '<=', Carbon::parse($request->date_to)->endOfDay());
            }
        }

        // Visitor type filter
        if ($request->filled('visitor_type')) {
            $query->whereHas('visitor', function($q) use ($request) {
                $q->where('visitor_type', $request->visitor_type);
            });
        }

        $checkins = $query->paginate(25);

        return view('checkins', compact('checkins'));
    }

    public function show(Visit $visit)
    {
        $visit->load(['visitor.visits', 'visitor.rfid']);
        return view('show', compact('visit'));
    }

    // app/Http\Controllers/CheckinController.php
    public function checkout(Visit $visit)
    {
        DB::beginTransaction();
        try {
            // 1. Update check-out time
            $visit->update(['check_out' => now()]);

            // 2. Force deactivate RFID (even if valid_until is in future)
            if ($visit->visitor && $rfid = $visit->visitor->rfid) {
                if ($rfid->type === 'reusable') {
                    $rfid->update(['status' => 'inactive']);
                }

            }

            DB::commit();
            return redirect()->back()->with('success', 'Checked out & RFID deactivated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout failed: '.$e->getMessage());
        }
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'rfid_string' => 'required|string' // Removed exists validation to handle matching ourselves
        ]);

        DB::beginTransaction();
        try {
            // Normalize the incoming RFID string
            $searchRfid = strtolower(trim($validated['rfid_string']));

            // Find RFID with flexible matching
            $rfid = Rfid::with('activeVisitor')
                    ->where(function($query) use ($searchRfid) {
                        $query->whereRaw('LOWER(rfid_string) = ?', [$searchRfid]) // Exact match (case insensitive)
                                ->orWhere('rfid_string', 'like', '%'.substr($searchRfid, -7).'%'); // Partial match for last 7 chars
                    })
                    ->firstOrFail();

            // Your existing visitor validation logic
            if (!$rfid->activeVisitor) {
                $latestVisitor = $rfid->visitors()->latest('valid_until')->first();

                if ($latestVisitor && now()->gt($latestVisitor->valid_until)) {
                    throw new \Exception("RFID expired. Last valid until: ".$latestVisitor->valid_until->format('Y-m-d'));
                }

                throw new \Exception("No active visitor assigned to this RFID");
            }

            $visitor = $rfid->activeVisitor;

            // Your existing recent check-in logic
            $recentCheckin = Visit::where('visitor_id', $visitor->id)
                            ->where('check_in', '>=', now()->subMinutes(5))
                            ->latest()
                            ->first();

            if ($recentCheckin) {
                return response()->json([
                    'status' => 'already_checked_in',
                    'visitor' => $visitor->name_printed,
                    'message' => 'Visitor already checked in recently'
                ]);
            }

            // Your existing check-in/check-out logic
            $activeVisit = Visit::where('visitor_id', $visitor->id)
                            ->whereNull('check_out')
                            ->latest()
                            ->first();

            if ($activeVisit) {
                // Check-out process
                $activeVisit->update(['check_out' => now()]);
                DB::commit();
                return response()->json([
                    'status' => 'checked_out',
                    'visitor' => $visitor->name_printed,
                    'rfid_matched' => $rfid->rfid_string // Added for debugging
                ]);
            } else {
                // Check-in process
                $visit = Visit::create([
                    'visitor_id' => $visitor->id,
                    'check_in' => now()
                ]);
                DB::commit();
                return response()->json([
                    'status' => 'checked_in',
                    'visitor' => $visitor->name_printed,
                    'rfid_matched' => $rfid->rfid_string // Added for debugging
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('RFID tracking failed: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'received_rfid' => $validated['rfid_string'] ?? null // Added for debugging
            ], 500);
        }
    }


    // Helper method to find the visitor for the RFID if it is inactive
    protected function findVisitorForRfid($rfid)
    {
        // Logic to find the visitor assigned to this RFID
        // You can use your existing logic to associate a visitor with the RFID
        // For now, we'll just return the visitor, assuming the new visitor is ready for this RFID.

        // Example: Find the visitor by some criteria, or prompt the user to assign a visitor
        // This could involve checking for the latest visitor or some other business logic.

        // For this demo, let's assume that the visitor is the first one found, but you may need
        // to adjust based on your actual use case.

        return Visitor::where('rfid_id', $rfid->id)->first();
    }

   public function getVisitsForPolling(Request $request)
    {
        \Log::info('Polling request received', $request->all());

        $query = Visit::with(['visitor' => function($query) {
            $query->select('id', 'name_printed', 'ic_number', 'visitor_type', 'house_number');
        }])
        ->where(function($query) {
            $query->whereNull('check_out')
                ->orWhere('check_out', '>=', now()->subDay());
        })
        ->orderBy('check_in', 'desc');

        // Apply filters from request
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('visitor', function($q) use ($search) {
                $q->where('name_printed', 'like', "%$search%")
                ->orWhere('ic_number', 'like', "%$search%")
                ->orWhere('house_number', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'inside') {
                $query->whereNull('check_out');
            } elseif ($request->status === 'checked_out') {
                $query->whereNotNull('check_out');
            }
        }

        if ($request->filled('visitor_type')) {
            $query->whereHas('visitor', function($q) use ($request) {
                $q->where('visitor_type', $request->visitor_type);
            });
        }

        // If client sent last_update, only return newer records
        if ($request->has('last_update')) {
            $lastUpdate = Carbon::parse($request->last_update);
            \Log::info('last_update filter applied: ' . $lastUpdate);
            $query->where('updated_at', '>', $lastUpdate);
        }


        $visits = $query->get();

        return response()->json([
            'visits' => $visits,
            'last_updated' => now()->toISOString()
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }


}
