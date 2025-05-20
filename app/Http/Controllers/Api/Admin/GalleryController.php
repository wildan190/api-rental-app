<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    // Tampilkan semua gallery
    public function index()
    {
        $galleries = Gallery::all();
        return response()->json([
            'message' => 'List of all galleries',
            'data' => $galleries
        ], 200);
    }

    // Simpan gallery baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload file gambar jika ada
        if ($request->hasFile('picture_upload')) {
            $path = $request->file('picture_upload')->store('galleries', 'public');
            $validated['picture_upload'] = $path;
        }

        $gallery = Gallery::create($validated);

        return response()->json([
            'message' => 'Gallery created successfully',
            'data' => $gallery
        ], 201);
    }

    // Tampilkan detail gallery
    public function show($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Gallery detail',
            'data' => $gallery
        ], 200);
    }

    // Update gallery
    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'picture_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Jika ada gambar baru di-upload
        if ($request->hasFile('picture_upload')) {
            // Hapus gambar lama jika ada
            if ($gallery->picture_upload && Storage::disk('public')->exists($gallery->picture_upload)) {
                Storage::disk('public')->delete($gallery->picture_upload);
            }
            // Upload gambar baru
            $path = $request->file('picture_upload')->store('galleries', 'public');
            $validated['picture_upload'] = $path;
        }

        $gallery->update($validated);

        return response()->json([
            'message' => 'Gallery updated successfully',
            'data' => $gallery
        ], 200);
    }

    // Hapus gallery
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        // Hapus gambar dari storage
        if ($gallery->picture_upload && Storage::disk('public')->exists($gallery->picture_upload)) {
            Storage::disk('public')->delete($gallery->picture_upload);
        }

        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted successfully',
        ], 200);
    }
}
