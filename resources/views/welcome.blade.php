@extends('layouts.app')

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
                Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
                Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div
                class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <img src="assets/concert.png" alt="Concert"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
        </div>

        <div class="mb-10 flex flex-wrap gap-3 items-center">
            <a href="/#events"
               class="px-5 py-2.5 rounded-2xl font-bold text-sm transition-all duration-200
                      {{ !request('category')
                          ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 scale-105'
                          : 'bg-white border-2 border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
                🎪 Semua Kategori
            </a>

            @foreach($categories as $cat)
                <a href="/?category={{ $cat->slug }}#events"
                   class="px-5 py-2.5 rounded-2xl font-bold text-sm transition-all duration-200
                          {{ request('category') === $cat->slug
                              ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 scale-105'
                              : 'bg-white border-2 border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        @if(request('category'))
            @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
            <div class="mb-6 px-5 py-3 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-between">
                <p class="text-indigo-700 font-semibold text-sm">
                    Menampilkan event kategori:
                    <span class="font-black">{{ $activeCat->name ?? request('category') }}</span>
                    <span class="ml-2 text-indigo-400">({{ $events->count() }} event ditemukan)</span>
                </p>
                <a href="/#events" class="text-xs text-indigo-400 hover:text-indigo-700 font-bold transition">✕ Reset Filter</a>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[3/4]">
                    @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <img src="assets/concert.png" alt="{{ $event->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @endif
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                        {{ $event->category->name ?? 'Umum' }}</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $event->date->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ route('events.show', $event->id) }}"
                            class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-slate-500 text-lg font-semibold">Tidak ada event untuk kategori ini.</p>
                <a href="/#events" class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Lihat semua event →</a>
            </div>
            @endforelse
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-extrabold mb-2">Partner Kami</h2>
                <p class="text-slate-500 font-medium">Mitra yang mendukung platform AmikomEventHub</p>
            </div>
        </div>
        @if($partners->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($partners as $partner)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center justify-center hover:shadow-md transition">
                @if($partner->logo)
                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-12 object-contain filter grayscale hover:filter-none transition">
                @else
                <span class="text-slate-400 text-xs font-bold">{{ $partner->name }}</span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-slate-500">Belum ada partner yang ditambahkan.</p>
        </div>
        @endif
    </section>
@endsection