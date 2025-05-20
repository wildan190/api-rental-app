<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MobilController extends Controller
{
    // Tampilkan semua data mobil
    public function index()
    {
        $mobils = Mobil::paginate(5);
        return response()->json([
            'message' => 'List of all cars',
            'data' => $mobils
        ], 200);
    }

    // Simpan data mobil baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plat_number' => 'nullable|string|unique:mobils,plat_number',
            'category' => ['required', Rule::in(['MPV', 'SUV', 'HATCHBACK', 'CROSSOVER', 'SEDAN', 'COUPE', 'CABRIOLET', 'ROADSTER'])],
            'merk' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'transmission' => ['required', Rule::in(['AT', 'MT'])],
            'seat' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['Available', 'Disewa', 'Out Of Order'])],
            'price' => 'required|numeric|min:0',
            'picture_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload file gambar jika ada
        if ($request->hasFile('picture_upload')) {
            $path = $request->file('picture_upload')->store('mobil_pictures', 'public');
            $validated['picture_upload'] = 'storage/' . $path;
        }

        $mobil = Mobil::create($validated);

        return response()->json([
            'message' => 'Mobil created successfully',
            'data' => $mobil
        ], 201);
    }

    // Tampilkan data mobil spesifik
    public function show($id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                'message' => 'Mobil not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Mobil detail',
            'data' => $mobil
        ], 200);
    }

    // Update data mobil
    public function update(Request $request, $id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                'message' => 'Mobil not found'
            ], 404);
        }

        $validated = $request->validate([
            'plat_number' => ['nullable', 'string', Rule::unique('mobils')->ignore($mobil->id)],
            'category' => ['sometimes', Rule::in(['MPV', 'SUV', 'HATCHBACK', 'CROSSOVER', 'SEDAN', 'COUPE', 'CABRIOLET', 'ROADSTER'])],
            'merk' => 'sometimes|string',
            'model' => 'sometimes|string',
            'year' => 'sometimes|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'transmission' => ['sometimes', Rule::in(['AT', 'MT'])],
            'seat' => 'sometimes|integer|min:1',
            'description' => 'nullable|string',
            'status' => ['sometimes', Rule::in(['Available', 'Disewa', 'Out Of Order'])],
            'price' => 'sometimes|numeric|min:0',
            'picture_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('picture_upload')) {
            // Hapus gambar lama jika ada
            if ($mobil->picture_upload) {
                $oldPath = str_replace('storage/', 'public/', $mobil->picture_upload);
                if (Storage::disk('public')->exists(str_replace('public/', '', $oldPath))) {
                    Storage::disk('public')->delete(str_replace('public/', '', $oldPath));
                }
            }

            $path = $request->file('picture_upload')->store('mobil_pictures', 'public');
            $validated['picture_upload'] = 'storage/' . $path;
        }

        $mobil->update($validated);

        return response()->json([
            'message' => 'Mobil updated successfully',
            'data' => $mobil
        ], 200);
    }

    // Hapus data mobil
    public function destroy($id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                'message' => 'Mobil not found'
            ], 404);
        }

        // Hapus file gambar jika ada
        if ($mobil->picture_upload) {
            $oldPath = str_replace('storage/', 'public/', $mobil->picture_upload);
            if (Storage::disk('public')->exists(str_replace('public/', '', $oldPath))) {
                Storage::disk('public')->delete(str_replace('public/', '', $oldPath));
            }
        }

        $mobil->delete();

        return response()->json([
            'message' => 'Mobil deleted successfully',
        ], 200);
    }
}
