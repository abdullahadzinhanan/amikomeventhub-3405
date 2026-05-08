@extends('layouts.admin')
@section('title', 'Tambah Kategori - Admin')

@section('page_title', 'Tambah Kategori')
@section('page_subtitle', 'Buat kategori acara baru')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('name') border-red-500 @enderror" placeholder="Masukkan nama kategori">
                @error('name')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="image" class="block text-sm font-bold text-slate-700 mb-2">Gambar Kategori (Opsional)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('image') border-red-500 @enderror">
                @error('image')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.categories') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection