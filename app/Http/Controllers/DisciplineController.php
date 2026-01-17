<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Requests\DisciplineRequest;

class DisciplineController extends Controller
{
    public function index()
    {
        return Discipline::with('abonnements','coaches')->get();
    }

    public function store(DisciplineRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('img')) {
            $data['img'] = uploadImage($request->img,'disciplines');
        }
        $data['user_id'] = auth()->id();

        return Discipline::create($data);
    }

    public function update(DisciplineRequest $request,$id)
    {
        $d = Discipline::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $data['img'] = uploadImage($request->img,'disciplines');
        }

        $d->update($data);
        return $d;
    }

    public function destroy($id)
    {
        Discipline::destroy($id);
        return response()->json(['message'=>'Deleted']);
    }
}
