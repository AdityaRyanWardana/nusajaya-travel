@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.armadas.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        {{ __('Back to List') }}
    </a>
    <h2 class="text-2xl font-bold text-slate-800">{{ __('Add New Fleet') }}</h2>
    <p class="text-slate-500 text-sm">{{ __('Enter vehicle details to add to the service list.') }}</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.armadas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Vehicle Name') }}</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: Toyota Hiace Premio 2024') }}" required>
                </div>

                <!-- Tipe -->
                <div>
                    <label for="type" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Vehicle Type') }}</label>
                    <select name="type" id="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none bg-white">
                        <option value="Bus">Bus</option>
                        <option value="Coaster">Coaster</option>
                        <option value="Hiace">Hiace</option>
                        <option value="Private Car">Private Car</option>
                    </select>
                </div>

                <!-- Kapasitas -->
                <div>
                    <label for="capacity" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Capacity (People)') }}</label>
                    <input type="number" name="capacity" id="capacity" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="14" required>
                </div>

                <!-- Total Unit -->
                <div>
                    <label for="total_units" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Total Units') }}</label>
                    <input type="number" name="total_units" id="total_units" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="10" value="1" required>
                </div>

                <!-- Unit Under Maintenance -->
                <div>
                    <label for="maintenance_units" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Units Under Maintenance') }}</label>
                    <input type="number" name="maintenance_units" id="maintenance_units" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="0" value="0" required>
                </div>

                <!-- Harga Batam City Tour -->
                <div class="col-span-2">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">{{ __('Batam City Tour Price') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="price_city_one_way" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">One Way Transfer</label>
                            <input type="number" name="price_city_one_way" id="price_city_one_way" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="500000" required>
                        </div>
                        <div>
                            <label for="price_city_half_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">Half Day (4H)</label>
                            <input type="number" name="price_city_half_day" id="price_city_half_day" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="800000" required>
                        </div>
                        <div>
                            <label for="price_city_one_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">One Day (8H)</label>
                            <input type="number" name="price_city_one_day" id="price_city_one_day" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="1200000" required>
                        </div>
                        <div>
                            <label for="price_city_full_day" class="block text-[10px] font-bold text-slate-500 mb-2 uppercase">Full Day (12H)</label>
                            <input type="number" name="price_city_full_day" id="price_city_full_day" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="1500000" required>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <label for="price_barelang" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Barelang Round Trip Price (Rp)') }}</label>
                    <input type="number" name="price_barelang" id="price_barelang" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="1800000" required>
                </div>

                <!-- Gambar Sampul -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Main Photo (Cover)') }}</label>
                    <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                </div>

                <!-- Galeri Foto -->
                <div>
                    <label for="gallery" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Photo Gallery (Multiple)') }}</label>
                    <input type="file" name="gallery[]" id="gallery" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Short Description') }}</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Describe vehicle features or facilities...') }}"></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                {{ __('Save Fleet') }}
            </button>
        </div>
    </form>
</div>
@endsection
