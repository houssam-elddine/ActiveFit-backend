<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    // عرض كل الاشتراكات
    public function index()
    {
        $abonnements = Abonnement::with('discipline')->get();

        return response()->json([
            'success' => true,
            'abonnements' => $abonnements
        ]);
    }

    // إضافة اشتراك
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'discipline_id' => 'required|exists:disciplines,id'
        ]);

        $abonnement = Abonnement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Abonnement created successfully',
            'abonnement' => $abonnement
        ], 201);
    }

    // عرض اشتراك واحد
    public function show($id)
    {
        $abonnement = Abonnement::with('discipline')->findOrFail($id);

        return response()->json([
            'success' => true,
            'abonnement' => $abonnement
        ]);
    }

    // تعديل اشتراك
    public function update(Request $request, $id)
    {
        $abonnement = Abonnement::findOrFail($id);

        $data = $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'discipline_id' => 'required|exists:disciplines,id'
        ]);

        $abonnement->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Abonnement updated successfully',
            'abonnement' => $abonnement
        ]);
    }

    // حذف اشتراك
    public function destroy($id)
    {
        Abonnement::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Abonnement deleted successfully'
        ]);
    }

    // PUBLIC - اشتراكات حسب discipline
    public function byDiscipline($id)
    {
        $abonnements = Abonnement::where('discipline_id', $id)->get();

        return response()->json([
            'success' => true,
            'abonnements' => $abonnements
        ]);
    }
}
