<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function index()
    {
        return Abonnement::with('discipline')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'=>'required',
            'prix'=>'required|numeric',
            'discipline_id'=>'required|exists:disciplines,id'
        ]);

        return Abonnement::create($data);
    }

    public function show($id)
    {
        return Abonnement::with('discipline')->findOrFail($id);
    }

    public function update(Request $request,$id)
    {
        $ab = Abonnement::findOrFail($id);

        $data = $request->validate([
            'nom'=>'required',
            'prix'=>'required|numeric',
            'discipline_id'=>'required|exists:disciplines,id'
        ]);

        $ab->update($data);
        return $ab;
    }

    public function destroy($id)
    {
        Abonnement::destroy($id);
        return response()->json(['message'=>'Abonnement deleted']);
    }

    // PUBLIC
    public function byDiscipline($id)
    {
        return Abonnement::where('discipline_id',$id)->get();
    }
}
