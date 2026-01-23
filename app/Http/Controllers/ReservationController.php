<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // إنشاء حجز
    public function store(Request $request)
    {
        $data = $request->validate([
            'coach_id' => 'nullable|exists:users,id',
            'abonnement_id' => 'required|exists:abonnements,id',
            'numer_telephone' => 'required|string'
        ]);

        $abonnement = Abonnement::findOrFail($data['abonnement_id']);

        $reservation = Reservation::create([
            'abonnement_id' => $abonnement->id,
            'client_id' => auth()->id(),
            'coach_id' => $data['coach_id'] ?? null,
            'numer_telephone' => $data['numer_telephone'],
            'prix' => $abonnement->prix,
            'status' => 'en attente'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }

    // حجوزات المستخدم الحالي
    public function myReservations()
    {
        $reservations = auth()->user()
            ->reservations()
            ->with(['abonnement', 'abonnement.discipline', 'coach'])
            ->get();

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
    }

    // إلغاء حجز من طرف العميل
    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('client_id', auth()->id())
            ->firstOrFail();

        $reservation->update([
            'status' => 'annuler'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation cancelled successfully',
            'reservation' => $reservation
        ]);
    }

    // تعديل حالة الحجز (Admin)
    public function adminUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:en attente,confirmer,annuler'
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Reservation status updated',
            'reservation' => $reservation
        ]);
    }

    // عرض كل الحجوزات (Admin)
    public function index()
    {
        $reservations = Reservation::with(['client', 'abonnement'])->get();

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
    }
}
