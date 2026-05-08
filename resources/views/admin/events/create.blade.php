@extends('layouts.admin')
@section('title', 'Tambah Event Baru - Admin')
@section('page_title', 'Tambah Event Baru')
@section('page_subtitle', 'Masukkan detail acara baru yang akan
diselenggarakan.')
@section('content')
<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm
max-w-3xl">
    <form action="{{ route('admin.events.store') }}" method="POST"
        enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Event</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl
                focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none
                transition font-medium" required>
            @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase
            tracking-wide">Kategori</label>
            <select name="category_id" class="w-full px-5 py-4 bg-slate-50
            border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10
            focus:border-indigo-600 outline-none transition font-medium" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') ==
                $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @if($categories->isEmpty())
            <p class="text-xs text-slate-400 mt-1">Belum ada kategori. <a href="{{ route('admin.categories.create') }}" class="text-indigo-600 hover:underline">Tambah kategori</a></p>
            @endif
            @error('category_id') <span class="text-red-500 text-sm mt-1">{{
            $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase
            tracking-wide">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full px-5 py-4
                bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4
                focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition
                font-medium">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm mt-1">{{
            $message }}</span> @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2
                uppercase tracking-wide">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" value="{{ old('date')
                    }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl
                    focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none
                    transition font-medium" required>
                @error('date') <span class="text-red-500 text-sm mt-1">{{
$message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2
uppercase tracking-wide">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl
focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none
transition font-medium" required>
                @error('location') <span class="text-red-500 text-sm mt-1">{{
$message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2
uppercase tracking-wide">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', 0) }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl
focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none
transition font-medium" required min="0">
                @error('price') <span class="text-red-500 text-sm mt-1">{{
$message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2
uppercase tracking-wide">Kapasitas (Stok)</label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl
focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none
transition font-medium" required min="1">
                @error('stock') <span class="text-red-500 text-sm mt-1">{{
$message }}</span> @enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase
tracking-wide">Poster Event (Opsional)</label>
            <input type="file" name="poster" accept="image/*" class="w-full px-5
py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4
focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition
font-medium">
            @error('poster') <span class="text-red-500 text-sm mt-1">{{ $message
}}</span> @enderror
        </div>
        <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.events.index') }}" class="px-6 py-4
text-slate-500 font-bold hover:text-slate-800 transition">Batal</a>
            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white
rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700
transition">Simpan Event</button>
        </div>
    </form>
</div>
@endsection