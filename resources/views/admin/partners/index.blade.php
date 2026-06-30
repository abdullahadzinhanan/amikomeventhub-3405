@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Kelola mitra dan sponsor acara di sini')
@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="mb-6 flex flex-col gap-4">
    <div>
        <a href="{{ route('admin.partners.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap">
            + Tambah Partner
        </a>
    </div>

    <form method="GET" action="{{ route('admin.partners.index') }}" class="flex items-center gap-2 w-full">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari partner..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
        </div>
        
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-md hover:bg-indigo-700 active:scale-95 transition text-sm flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span>Cari</span>
        </button>

        @if($search)
        <a href="{{ route('admin.partners.index') }}" class="px-4 py-3 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition text-sm font-medium whitespace-nowrap">
            Reset
        </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Website</th>
                    <th class="px-8 py-4">Deskripsi</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $partners->firstItem() + $index }}</td>
                    <td class="px-8 py-6">
                        @if($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm">
                        @else
                        <div class="w-16 h-16 rounded-xl bg-slate-200 flex items-center justify-center">
                            <span class="text-slate-400 text-xs">No Logo</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $partner->name }}</p>
                    </td>
                    <td class="px-8 py-6 text-slate-500">{{ $partner->website ?? '-' }}</td>
                    <td class="px-8 py-6 text-slate-500">{{ Str::limit($partner->description, 50) ?? '-' }}</td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-500">Belum ada partner yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t items-center">
        {{ $partners->links() }}
    </div>
</div>
@endsection