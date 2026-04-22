@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        {{ __('Back to List') }}
    </a>
    <h2 class="text-2xl font-bold text-slate-800">{{ __('Add New Tour Package') }}</h2>
    <p class="text-slate-500 text-sm">{{ __('Enter travel destination details to add to the service list.') }}</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Tour Package Name') }}</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: Bali Travel Package 3 Days 2 Nights') }}" required>
                </div>

                <!-- Destinasi -->
                <div>
                    <label for="destination" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Destination') }}</label>
                    <input type="text" name="destination" id="destination" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: Denpasar, Bali') }}" required>
                </div>

                <!-- Durasi -->
                <div>
                    <label for="duration" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Duration') }}</label>
                    <input type="text" name="duration" id="duration" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: 3 Days 2 Nights') }}" required>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Price per Person (Rp)') }}</label>
                    <input type="number" name="price" id="price" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="2500000" required>
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
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Trip Description') }}</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Explain trip details, facilities, and schedule...') }}"></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                {{ __('Save Tour Package') }}
            </button>
        </div>
    </form>
</div>
@endsection
