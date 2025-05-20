<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\MetaWeb;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $metaWeb = MetaWeb::first();

        if (!$metaWeb) {
            return response()->json([
                'message' => 'MetaWeb data not found'
            ], 404);
        }

        return response()->json([
            'message' => 'About Us data retrieved successfully',
            'data' => $metaWeb
        ], 200);
    }
}
