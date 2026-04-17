@extends('layouts.admin')

@section('content')
<main class="flex-1 p-10 overflow-y-auto">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Kelola Kategori</h1>
            <p class="text-slate-500 font-medium">Atur kategori event seperti Seminar, Konser, Workshop.</p>
        </div>
        <button
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
            + Tambah Kategori
        </button>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b">
            <input type="text" placeholder="Cari kategori..."
                class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Deskripsi</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    {{-- Dummy Data --}}
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 font-bold text-slate-400">1</td>
                        <td class="px-8 py-6 font-black text-slate-800">Seminar</td>
                        <td class="px-8 py-6 text-slate-500">Kategori untuk acara edukasi dan presentasi.</td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    Edit
                                </button>
                                <button
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 font-bold text-slate-400">2</td>
                        <td class="px-8 py-6 font-black text-slate-800">Konser</td>
                        <td class="px-8 py-6 text-slate-500">Kategori untuk acara musik dan hiburan.</td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    Edit
                                </button>
                                <button
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 font-bold text-slate-400">3</td>
                        <td class="px-8 py-6 font-black text-slate-800">Workshop</td>
                        <td class="px-8 py-6 text-slate-500">Kategori untuk pelatihan dan praktik langsung.</td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    Edit
                                </button>
                                <button
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection