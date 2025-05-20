<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:testimonis,email',
            'rate' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $testimoni = Testimoni::create($validated);

        return response()->json(
            [
                'message' => 'Testimoni created successfully',
                'data' => $testimoni,
            ],
            201,
        );
    }
}
