@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Kembali ke Daftar
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Tambah Paket Tour Baru</h2>
    <p class="text-slate-500 text-sm">Masukkan detail destinasi wisata untuk ditambahkan ke daftar layanan.</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Nama Paket Tour</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: Paket Wisata Bali 3 Hari 2 Malam" required>
                </div>

                <!-- Destinasi -->
                <div>
                    <label for="destination" class="block text-sm font-bold text-slate-700 mb-2">Destinasi</label>
                    <input type="text" name="destination" id="destination" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: Denpasar, Bali" required>
                </div>

                <!-- Durasi -->
                <div>
                    <label for="duration" class="block text-sm font-bold text-slate-700 mb-2">Durasi</label>
                    <input type="text" name="duration" id="duration" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: 3 Hari 2 Malam" required>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Harga per Orang (Rp)</label>
                    <input type="number" name="price" id="price" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="2500000" required>
                </div>

                <!-- Gambar Sampul -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">Foto Utama (Sampul)</label>
                    <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                </div>

                <!-- Galeri Foto -->
                <div>
                    <label for="gallery" class="block text-sm font-bold text-slate-700 mb-2">Galeri Foto (Bisa banyak)</label>
                    <input type="file" name="gallery[]" id="gallery" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Perjalanan</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Jelaskan rincian perjalanan, fasilitas, dan jadwal..."></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                Simpan Paket Tour
            </button>
        </div>
    </form>
</div>
@endsection
