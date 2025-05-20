<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MobilController extends Controller
{
    // Tampilkan semua data mobil
    public function index()
    {
        $mobils = Mobil::all();
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
            'picture_upload' => 'nullable|string', // bisa kamu ganti sesuai kebutuhan upload file
        ]);

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
            'plat_number' => ['sometimes', 'string', Rule::unique('mobils')->ignore($mobil->id)],
            'category' => ['sometimes', Rule::in(['MPV', 'SUV', 'HATCHBACK', 'CROSSOVER', 'SEDAN', 'COUPE', 'CABRIOLET', 'ROADSTER'])],
            'merk' => 'sometimes|string',
            'model' => 'sometimes|string',
            'year' => 'sometimes|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'transmission' => ['sometimes', Rule::in(['AT', 'MT'])],
            'seat' => 'sometimes|integer|min:1',
            'description' => 'nullable|string',
            'status' => ['sometimes', Rule::in(['Available', 'Disewa', 'Out Of Order'])],
            'picture_upload' => 'nullable|string',
        ]);

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

        $mobil->delete();

        return response()->json([
            'message' => 'Mobil deleted successfully',
        ], 200);
    }
}
