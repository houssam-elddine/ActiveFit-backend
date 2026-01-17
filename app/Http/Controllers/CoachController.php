<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        return Coach::with('discipline')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'discipline_id'=>'required|exists:disciplines,id',
            'description'=>'nullable',
            'img'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $data['img'] = uploadImage($request->img,'coaches');
        }

        return Coach::create($data);
    }

    public function show($id)
    {
        return Coach::with('discipline')->findOrFail($id);
    }

    public function update(Request $request,$id)
    {
        $coach = Coach::findOrFail($id);

        $data = $request->validate([
            'name'=>'required',
            'discipline_id'=>'required|exists:disciplines,id',
            'description'=>'nullable',
            'img'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $data['img'] = uploadImage($request->img,'coaches');
        }

        $coach->update($data);
        return $coach;
    }

    public function destroy($id)
    {
        Coach::destroy($id);
        return response()->json(['message'=>'Coach deleted']);
    }
}
