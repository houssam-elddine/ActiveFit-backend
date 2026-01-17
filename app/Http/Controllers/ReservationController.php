<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'abonnement_id'=>'required|exists:abonnements,id',
            'numer_telephone'=>'required'
        ]);

        $ab = Abonnement::findOrFail($data['abonnement_id']);

        return Reservation::create([
            'abonnement_id'=>$ab->id,
            'client_id'=>auth()->id(),
            'numer_telephone'=>$data['numer_telephone'],
            'prix'=>$ab->prix,
            'status'=>'en attente'
        ]);
    }

    public function myReservations()
    {
        return auth()->user()
            ->reservations()
            ->with(['abonnement', 'abonnement.discipline.coaches'])
            ->get();
    }

    public function cancel($id)
    {
        $r = Reservation::where('id',$id)
            ->where('client_id',auth()->id())
            ->firstOrFail();

        $r->update(['status'=>'annuler']);
        return $r;
    }

    public function adminUpdate(Request $request,$id)
    {
        $data = $request->validate([
            'status'=>'required|in:en attente,confirmer,annuler'
        ]);

        $r = Reservation::findOrFail($id);
        $r->update($data);

        return $r;
    }

    public function index()
    {
        return Reservation::with('client','abonnement')->get();
    }
}
