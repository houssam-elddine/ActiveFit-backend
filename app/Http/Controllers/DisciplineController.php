<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Requests\DisciplineRequest;

class DisciplineController extends Controller
{
    // عرض كل الـ disciplines مع العلاقات
    public function index()
    {
        $disciplines = Discipline::with(['abonnements', 'coachs'])->get();

        return response()->json([
            'success' => true,
            'disciplines' => $disciplines
        ]);
    }

    // إضافة discipline جديد
    public function store(DisciplineRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $data['img'] = $this->uploadImage($request->file('img'), 'disciplines');
        }

        $discipline = Discipline::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Discipline created successfully',
            'discipline' => $discipline
        ]);
    }

    // تعديل discipline موجود
    public function update(DisciplineRequest $request, $id)
    {
        $discipline = Discipline::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $data['img'] = $this->uploadImage($request->file('img'), 'disciplines');
        }

        $discipline->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Discipline updated successfully',
            'discipline' => $discipline
        ]);
    }

    public function show($id)
    {
        $discipline = Discipline::with(['abonnements', 'coachs'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'discipline' => $discipline
        ]);
    }

    // حذف discipline
    public function destroy($id)
    {
        $discipline = Discipline::findOrFail($id);
        $discipline->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discipline deleted successfully'
        ]);
    }

    // دالة مساعدة لتحميل الصور
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
