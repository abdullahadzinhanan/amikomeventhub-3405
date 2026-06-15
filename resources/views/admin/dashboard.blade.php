@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                </path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black">{{ $totalTiketTerjual ?? 0 }}</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-2xl font-black">{{ $totalEvent ?? 0 }} Event</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
        <h3 class="text-2xl font-black">{{ $transaksiPending ?? 0 }} Pesanan</h3>
    </div>
</div>

<!-- Latest Sales Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Transaksi Terakhir</h3>
        {{-- ✅ PERBAIKAN: nama route diubah dari admin.transactions → admin.transactions.index --}}
        <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transaksiTerakhir ?? collect() as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6">
                        <p class="font-bold uppercase tracking-wide text-sm">{{ $trx->customer_name ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ $trx->customer_email ?? '' }}</p>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-600">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-8 py-6">
                        @php($status = $trx->status)
                        @php($badge = match($status) {
                            'Success'    => 'bg-green-100 text-green-700',
                            'Pending'    => 'bg-orange-100 text-orange-700',
                            'settlement' => 'bg-green-100 text-green-700',
                            'pending'    => 'bg-orange-100 text-orange-700',
                            default      => 'bg-slate-100 text-slate-600',
                        })
                        <span class="px-3 py-1 {{ $badge }} rounded-lg text-xs font-bold uppercase">{{ $status }}</span>
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600">
                        Rp {{ number_format($trx->total_price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-6 text-center text-slate-500">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Events Grid -->
<div class="mt-10">
    <h3 class="font-black text-xl mb-6">Event Terbaru</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[3/4]">
                @if($event->poster_path)
                <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                <img src="https://placehold.co/400x500" alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @endif
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                    {{ $event->category->name ?? 'Umum' }}
                </div>
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
                    <span class="text-2xl font-black text-indigo-600">
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    </span>
                    <a href="{{ route('admin.events.edit', $event->id) }}"
                        class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                        Kelola
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20">
            <p class="text-slate-500 text-lg">Belum ada event yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection