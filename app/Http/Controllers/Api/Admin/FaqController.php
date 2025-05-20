<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Tampilkan semua FAQ
    public function index()
    {
        $faqs = Faq::all();
        return response()->json([
            'message' => 'List of all FAQs',
            'data' => $faqs
        ], 200);
    }

    // Simpan FAQ baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'questions' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq = Faq::create($validated);

        return response()->json([
            'message' => 'FAQ created successfully',
            'data' => $faq
        ], 201);
    }

    // Tampilkan detail FAQ
    public function show($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'message' => 'FAQ not found'
            ], 404);
        }

        return response()->json([
            'message' => 'FAQ detail',
            'data' => $faq
        ], 200);
    }

    // Update FAQ
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'message' => 'FAQ not found'
            ], 404);
        }

        $validated = $request->validate([
            'questions' => 'sometimes|string',
            'answer' => 'sometimes|string',
        ]);

        $faq->update($validated);

        return response()->json([
            'message' => 'FAQ updated successfully',
            'data' => $faq
        ], 200);
    }

    // Hapus FAQ
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'message' => 'FAQ not found'
            ], 404);
        }

        $faq->delete();

        return response()->json([
            'message' => 'FAQ deleted successfully',
        ], 200);
    }
}
