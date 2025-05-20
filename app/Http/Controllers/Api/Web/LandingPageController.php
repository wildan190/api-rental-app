<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\MetaWeb;
use App\Models\Mobil;
use App\Models\Gallery;
use App\Models\Testimoni;
use App\Models\Faq;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data MetaWeb (hanya field yang diminta)
        $metaWeb = MetaWeb::select('whatsapp', 'instagram', 'address', 'email')->first();

        // Ambil data Mobil max 6
        $mobils = Mobil::limit(6)->get();

        // Ambil data Gallery max 4
        $galleries = Gallery::limit(4)->get();

        // Ambil data Testimoni max 6
        $testimonis = Testimoni::limit(6)->get();

        // Ambil data Faq max 5
        $faqs = Faq::limit(5)->get();

        return response()->json([
            'meta_web' => $metaWeb,
            'mobils' => $mobils,
            'galleries' => $galleries,
            'testimonis' => $testimonis,
            'faqs' => $faqs,
        ], 200);
    }
}
