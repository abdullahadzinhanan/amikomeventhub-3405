@extends('layouts.admin')
@section('title', 'Edit Partner - Admin')

@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Perbarui informasi mitra')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" id="name" value="{{ old('name', $partner->name) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('name') border-red-500 @enderror" placeholder="Masukkan nama partner">
                @error('name')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="logo" class="block text-sm font-bold text-slate-700 mb-2">Logo Partner (Opsional)</label>
                <input type="file" name="logo" id="logo" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('logo') border-red-500 @enderror">
                @if($partner->logo)
                <p class="text-sm text-slate-500 mt-2">Logo saat ini: <a href="{{ asset('storage/' . $partner->logo) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a></p>
                @endif
                @error('logo')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="website" class="block text-sm font-bold text-slate-700 mb-2">Website (Opsional)</label>
                <input type="url" name="website" id="website" value="{{ old('website', $partner->website) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('website') border-red-500 @enderror" placeholder="https://example.com">
                @error('website')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi partner">{{ old('description', $partner->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.partners') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection