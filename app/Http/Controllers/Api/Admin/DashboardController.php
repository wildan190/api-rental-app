<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mobil;
use App\Models\Testimoni;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $jumlahMobil = Mobil::count();
            $jumlahFeedbackBintang5 = Testimoni::where('rate', 5)->count();

            return response()->json([
                'message' => 'Welcome to the admin dashboard!',
                'user' => Auth::user(),
                'jumlah_mobil' => $jumlahMobil,
                'jumlah_feedback_bintang_5' => $jumlahFeedbackBintang5,
            ], 200);
        }

        return response()->json([
            'message' => 'You are not authenticated.',
        ], 401);
    }
}
