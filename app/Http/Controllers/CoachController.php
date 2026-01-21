<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::with('discipline')->get();

        return response()->json([
            'success' => true,
            'coaches' => $coaches
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discipline_id' => 'required|exists:disciplines,id',
            'description' => 'nullable|string',
            'img' => 'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $data['img'] = $this->uploadImage($request->file('img'), 'coaches');
        }

        $coach = Coach::create($data);

        return response()->json([
            'success' => true,
            'coach' => $coach
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $coach = Coach::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'discipline_id' => 'sometimes|exists:disciplines,id',
            'description' => 'nullable|string',
            'img' => 'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $data['img'] = $this->uploadImage($request->file('img'), 'coaches');
        }

        $coach->update($data);

        return response()->json([
            'success' => true,
            'coach' => $coach
        ]);
    }

    public function show($id)
    {
        $coach = Coach::with('discipline')->findOrFail($id);

        return response()->json([
            'success' => true,
            'coach' => $coach
        ]);
    }

    public function destroy($id)
    {
        Coach::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }

    // ✅ الدالة الناقصة
    private function uploadImage($image, $folder)
    {
        $path = $image->store($folder, 'public');
        //$path = $image->file('img')->store('images', 'public');
        //$validated['img'] = $path;
        //$filename = time() . '_' . $image->getClientOriginalName();
        //$image->storeAs('public/' . $folder, $filename);
        return $path;
    }

}
