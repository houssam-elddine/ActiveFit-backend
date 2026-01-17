<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $request->validate([
            'client_id' => 'required'
        ]);

        Attendance::create([
            'client_id' => $request->client_id,
            'check_in_date' => now()->toDateString()
        ]);

        return response()->json([
            'message' => 'Présence enregistrée avec succès'
        ]);
    }
}
