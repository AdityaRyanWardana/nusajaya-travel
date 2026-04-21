@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.armadas.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Kembali ke Daftar
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Edit Armada: {{ $armada->name }}</h2>
    <p class="text-slate-500 text-sm">Perbarui informasi kendaraan transportasi kamu.</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.armadas.update', $armada->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Kendaraan</label>
                    <input type="text" name="name" id="name" value="{{ $armada->name }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Tipe -->
                <div>
                    <label for="type" class="block text-sm font-bold text-slate-700 mb-2">Tipe Kendaraan</label>
                    <select name="type" id="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none bg-white">
                        <option value="Bus" {{ $armada->type == 'Bus' ? 'selected' : '' }}>Bus</option>
                        <option value="Coaster" {{ $armada->type == 'Coaster' ? 'selected' : '' }}>Coaster</option>
                        <option value="Hiace" {{ $armada->type == 'Hiace' ? 'selected' : '' }}>Hiace</option>
                        <option value="Elf" {{ $armada->type == 'Elf' ? 'selected' : '' }}>Elf</option>
                        <option value="Innova" {{ $armada->type == 'Innova' ? 'selected' : '' }}>Innova</option>
                        <option value="Lainnya" {{ $armada->type == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Kapasitas -->
                <div>
                    <label for="capacity" class="block text-sm font-bold text-slate-700 mb-2">Kapasitas (Orang)</label>
                    <input type="number" name="capacity" id="capacity" value="{{ $armada->capacity }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Harga Batam City Tour -->
                <div class="col-span-2">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Harga Batam City Tour</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="price_city_one_way" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">One Way Transfer</label>
                            <input type="number" name="price_city_one_way" id="price_city_one_way" value="{{ intval($armada->price_city_one_way) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                        </div>
                        <div>
                            <label for="price_city_half_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">Half Day (4H)</label>
                            <input type="number" name="price_city_half_day" id="price_city_half_day" value="{{ intval($armada->price_city_half_day) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                        </div>
                        <div>
                            <label for="price_city_one_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">One Day (8H)</label>
                            <input type="number" name="price_city_one_day" id="price_city_one_day" value="{{ intval($armada->price_city_one_day) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                        </div>
                        <div>
                            <label for="price_city_full_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">Full Day (12H)</label>
                            <input type="number" name="price_city_full_day" id="price_city_full_day" value="{{ intval($armada->price_city_full_day) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <label for="price_barelang" class="block text-sm font-bold text-slate-700 mb-2">Harga PP Barelang (Rp)</label>
                    <input type="number" name="price_barelang" id="price_barelang" value="{{ intval($armada->price_barelang) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Gambar Sampul -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">Foto Utama (Sampul)</label>
                    <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                    @if($armada->image)
                        <div class="relative group mt-4 w-32 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm">
                            <img src="{{ Str::startsWith($armada->image, 'http') ? $armada->image : asset('storage/' . $armada->image) }}" class="w-full h-full object-cover">
                            
                            <!-- Delete Button Trigger -->
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <button type="button" onclick="if(confirm('Hapus foto utama ini?')) { document.getElementById('delete-main-image').submit(); }" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg" title="Hapus Foto Utama">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Galeri Foto -->
                <div class="col-span-2">
                    <label for="gallery" class="block text-sm font-bold text-slate-700 mb-2">Galeri Foto (Bisa banyak)</label>
                    <input type="file" name="gallery[]" id="gallery" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                    @if($armada->images)
                        <div class="mt-4 flex flex-wrap gap-4">
                            @foreach($armada->images as $img)
                                <div class="relative group w-24 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm">
                                    <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                    
                                    <!-- Delete Button Trigger -->
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                        <button type="button" onclick="if(confirm('Hapus foto ini?')) { document.getElementById('delete-image-{{ $loop->index }}').submit(); }" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg" title="Hapus Foto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ $armada->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <!-- Hidden Delete Forms -->
    <form id="delete-main-image" action="{{ route('admin.armadas.delete-main-image', $armada->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @if($armada->images)
        @foreach($armada->images as $img)
            <form id="delete-image-{{ $loop->index }}" action="{{ route('admin.armadas.delete-image', $armada->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_path" value="{{ $img }}">
            </form>
        @endforeach
    @endif
</div>
@endsection
