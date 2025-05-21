<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class ListMobilController extends Controller
{

    /**
     * Contoh body raw JSON untuk tes di Postman:
     * {
     *   "merk": "Toyota",
     *   "transmission": "Automatic",
     *   "model": "Avanza",
     *   "price": 300000,
     *   "seat": 7
     * }
     *
     */

    public function index(Request $request)
    {
        $query = Mobil::query();

        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        if ($request->filled('seat')) {
            $query->where('seat', $request->seat);
        }

        $mobils = Mobil::paginate(10);

        return response()->json([
            'mobils' => $mobils,
        ], 200);
    }
}