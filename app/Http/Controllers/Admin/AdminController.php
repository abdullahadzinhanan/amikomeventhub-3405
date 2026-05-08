<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
  public function dashboard()
{
    // 1. Ambil data statistik
    $totalPendapatan = Transaction::where('status', 'Success')->sum('total_price');
    $totalTiketTerjual = Transaction::where('status', 'Success')->count();
    $totalEvent = Event::count();
    $transaksiPending = Transaction::where('status', 'Pending')->count();

    // 2. Ambil transaksi terakhir (Gunakan satu variabel saja agar efisien)
    $transaksiTerakhir = Transaction::with('event')->latest()->limit(5)->get();
    
    // 3. KIRIM KE VIEW (Pastikan string di dalam compact SAMA PERSIS dengan nama variabel di atas tanpa $)
    return view('admin.dashboard', compact(
        'totalPendapatan', 
        'totalTiketTerjual', 
        'totalEvent',
        'transaksiPending', 
        'transaksiTerakhir'
    ));
}

    public function events()
    {
        $events = Event::with('category')->latest()->get();
        return view('admin.events', compact('events'));
    }

    public function transactions()
    {
        $transactions = Transaction::with('event')->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }

    public function createEvent()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description2' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'poster' => 'nullable|image|max:2048',
            'organizer_name' => 'nullable|string|max:255',
            'organizer_initials' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('poster')) {
    $path = $request->file('poster')->store('posters', 'public');
    // Simpan path-nya saja, misal: "posters/namafile.jpg"
    $validated['poster_path'] = $path; 
}

        Event::create($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil ditambahkan');
    }

    public function editEvent(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description2' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'poster' => 'nullable|image|max:2048',
            'organizer_name' => 'nullable|string|max:255',
            'organizer_initials' => 'nullable|string|max:255',
        ]);

        if ($request->title !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if ($request->hasFile('poster')) {
            if ($event->poster_path && Str::startsWith($event->poster_path, 'storage/')) {
                Storage::disk('public')->delete(Str::replaceFirst('storage/', '', $event->poster_path));
            }
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster_path'] = 'storage/' . $path;
        }

        $event->update($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui');
    }

    public function destroyEvent(Event $event)
    {
        if ($event->poster_path && Str::startsWith($event->poster_path, 'storage/')) {
            Storage::disk('public')->delete(Str::replaceFirst('storage/', '', $event->poster_path));
        }
        $event->delete();

        return redirect()->route('admin.events')->with('success', 'Event berhasil dihapus');
    }
}