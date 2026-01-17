<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ClientSubscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Liste des abonnements',
            'data' => Subscription::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'duration_days' => 'required|integer',
            'price'         => 'required|numeric'
        ]);

        Subscription::create($request->all());

        return response()->json([
            'message' => 'Abonnement créé avec succès'
        ], 201);
    }

    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);

        return response()->json([
            'message' => 'Détails de l\'abonnement',
            'data'    => $subscription
        ]);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $request->validate([
            'name'          => 'sometimes|required',
            'duration_days' => 'sometimes|required|integer',
            'price'         => 'sometimes|required|numeric'
        ]);

        $subscription->update($request->all());

        return response()->json([
            'message' => 'Abonnement mis à jour avec succès'
        ]);
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json([
            'message' => 'Abonnement supprimé avec succès'
        ]);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'client_id'       => 'required',
            'subscription_id' => 'required',
            'start_date'      => 'required|date'
        ]);

        $subscription = Subscription::findOrFail($request->subscription_id);

        $endDate = Carbon::parse($request->start_date)
            ->addDays($subscription->duration_days);

        ClientSubscription::create([
            'client_id'       => $request->client_id,
            'subscription_id' => $subscription->id,
            'start_date'      => $request->start_date,
            'end_date'        => $endDate,
            'paid_amount'     => $subscription->price,
            'payment_method'  => 'cash'
        ]);

        return response()->json([
            'message' => 'Abonnement attribué avec succès'
        ]);
    }
}
