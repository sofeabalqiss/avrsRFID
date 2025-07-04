<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rfid;
use Illuminate\Http\Request;

class RfidCardController extends Controller
{
    public function index()
    {
        $rfidCards = Rfid::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.rfid-cards.index', compact('rfidCards'));
    }

    public function create()
    {
        return view('admin.rfid-cards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfid_string' => 'required|unique:rfids,rfid_string',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:permanent,reusable',
        ]);

        Rfid::create([
            'rfid_string' => $request->rfid_string,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.rfid-cards.index')->with('success', 'RFID card added successfully.');
    }

    public function destroy(Rfid $rfid)
    {
        $rfid->delete();
        return redirect()->route('admin.rfid-cards.index')->with('success', 'RFID card deleted successfully.');
    }
}
