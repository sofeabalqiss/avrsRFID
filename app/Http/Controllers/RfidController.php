<?php

namespace App\Http\Controllers;

use App\Models\Rfid;
use Illuminate\Http\Request;

class RfidController extends Controller
{
    public function getInactiveRfids()
    {
        $rfids = Rfid::where('status', 'inactive')
                ->select('id', 'rfid_string', 'type')  // <-- add 'type' here
                ->get();

        return response()->json([
            'status' => 'success',
            'rfids' => $rfids
        ]);
    }

}
