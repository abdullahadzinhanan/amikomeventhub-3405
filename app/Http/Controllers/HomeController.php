<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua jenis kategori untuk tampilan filter tab button
        $categories = Category::all();

        // 2. Ambil semua partner
        $partners = Partner::latest()->get();

        // 3. Buat kueri dasar untuk mengambil event:
        //    - Eager loading `category`
        //    - Hanya tampilkan event dengan jadwal yang belum kedaluwarsa (>= hari ini)
        $query = Event::with('category')
                      ->where('date', '>=', now())
                      ->orderBy('date', 'asc');

        // 4. Filter query jika URL memiliki parameter ?category=...
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 5. Eksekusi query
        $events = $query->get();

        return response()
            ->view('welcome', compact('events', 'categories', 'partners'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }
}