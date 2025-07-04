<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Rfid;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function showRegistrationForm()
    {
        return view('visitor-registration');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name_printed' => 'required|string|max:255',
            'ic_number' => 'required|string|max:255',
            'rfid_id' => 'required|exists:rfids,id',
            'type' => 'required|in:reusable,permanent', // <-- NEW: required input for RFID type
            'visitor_type' => 'required|string|max:255',
            'vehicle_plate' => 'nullable|string|max:255',
            'house_number' => 'required|string|max:255',
            'address_1' => 'required|string',
            'valid_until' => 'required|date|after_or_equal:valid_from',
        ]);

        DB::beginTransaction();

        try {
            $valid_from = now();

            // 1. Create the visitor
            $visitor = Visitor::create([
                'name_printed' => $validated['name_printed'],
                'ic_number' => $validated['ic_number'],
                'rfid_id' => $validated['rfid_id'],
                'visitor_type' => $validated['visitor_type'],
                'vehicle_plate' => $validated['vehicle_plate'],
                'house_number' => $validated['house_number'],
                'address_1' => $validated['address_1'],
                'valid_from' => $valid_from,
                'valid_until' => $validated['valid_until'],
            ]);

            // 2. Update RFID to 'active' and set correct type
            $rfid = Rfid::findOrFail($validated['rfid_id']);
            $rfid->update([
                'status' => 'active',
                'type' => $validated['type'], // <-- Force type based on submitted selection
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Visitor registered successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }

}
