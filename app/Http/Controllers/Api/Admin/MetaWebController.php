<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaWeb;
use Illuminate\Http\Request;

class MetaWebController extends Controller
{
    // Tampilkan detail informasi MetaWeb
    public function index()
    {
        $metaWeb = MetaWeb::first();

        if (!$metaWeb) {
            return response()->json([
                'message' => 'MetaWeb not found'
            ], 404);
        }

        return response()->json([
            'message' => 'MetaWeb information',
            'data' => $metaWeb
        ], 200);
    }

    // Simpan atau Update MetaWeb
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
        ]);

        // Jika sudah ada, update; jika belum, create baru
        $metaWeb = MetaWeb::first();
        if ($metaWeb) {
            $metaWeb->update($validated);
            $message = 'MetaWeb updated successfully';
        } else {
            $metaWeb = MetaWeb::create($validated);
            $message = 'MetaWeb created successfully';
        }

        return response()->json([
            'message' => $message,
            'data' => $metaWeb
        ], 200);
    }
}
