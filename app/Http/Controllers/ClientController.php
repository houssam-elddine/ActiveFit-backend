<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // LISTE DES CLIENTS
    public function index()
    {
        return response()->json([
            'message' => 'Liste des clients',
            'data'    => Client::with('user')->get()
        ]);
    }

    // AJOUT CLIENT (admin)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'birth_date' => 'nullable|date'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'client'
        ]);

        Client::create([
            'user_id'    => $user->id,
            'birth_date' => $request->birth_date
        ]);

        return response()->json([
            'message' => 'Client ajouté avec succès'
        ], 201);
    }

    // SUPPRIMER CLIENT
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->user->delete(); // cascade

        return response()->json([
            'message' => 'Client supprimé avec succès'
        ]);
    }
}
