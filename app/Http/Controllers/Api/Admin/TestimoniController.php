<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TestimoniController extends Controller
{
    // Tampilkan semua testimoni
    public function index()
    {
        $testimonis = Testimoni::all();
        return response()->json([
            'message' => 'List of all testimoni',
            'data' => $testimonis
        ], 200);
    }

    // Simpan testimoni baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:testimonis,email',
            'rate' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $testimoni = Testimoni::create($validated);

        return response()->json([
            'message' => 'Testimoni created successfully',
            'data' => $testimoni
        ], 201);
    }

    // Tampilkan detail testimoni
    public function show($id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'message' => 'Testimoni not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Testimoni detail',
            'data' => $testimoni
        ], 200);
    }

    // Update testimoni
    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'message' => 'Testimoni not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:testimonis,email,' . $id,
            'rate' => 'sometimes|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $testimoni->update($validated);

        return response()->json([
            'message' => 'Testimoni updated successfully',
            'data' => $testimoni
        ], 200);
    }

    // Hapus testimoni
    public function destroy($id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'message' => 'Testimoni not found'
            ], 404);
        }

        $testimoni->delete();

        return response()->json([
            'message' => 'Testimoni deleted successfully',
        ], 200);
    }
}
