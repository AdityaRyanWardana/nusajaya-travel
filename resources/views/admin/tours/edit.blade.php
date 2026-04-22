@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        {{ __('Back to List') }}
    </a>
    <h2 class="text-2xl font-bold text-slate-800">{{ __('Edit Tour Package') }}: {{ $tour->title }}</h2>
    <p class="text-slate-500 text-sm">{{ __('Update destination details and tour package prices.') }}</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Tour Package Name') }}</label>
                    <input type="text" name="title" id="title" value="{{ $tour->title }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Destinasi -->
                <div>
                    <label for="destination" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Destination') }}</label>
                    <input type="text" name="destination" id="destination" value="{{ $tour->destination }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Durasi -->
                <div>
                    <label for="duration" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Duration') }}</label>
                    <input type="text" name="duration" id="duration" value="{{ $tour->duration }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Price per Person (Rp)') }}</label>
                    <input type="number" name="price" id="price" value="{{ intval($tour->price) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <!-- Gambar Sampul -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Main Photo (Cover)') }}</label>
                    <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                    @if($tour->image)
                        <div class="relative group mt-4 w-32 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm">
                            <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset('storage/' . $tour->image) }}" class="w-full h-full object-cover">
                            
                            <!-- Delete Button Trigger -->
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <button type="button" onclick="if(confirm('{{ __('Delete this main photo?') }}')) { document.getElementById('delete-main-image').submit(); }" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg" title="{{ __('Delete Main Photo') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Galeri Foto -->
                <div>
                    <label for="gallery" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Photo Gallery (Multiple)') }}</label>
                    <input type="file" name="gallery[]" id="gallery" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                    @if($tour->images)
                        <div class="mt-4 flex flex-wrap gap-4">
                            @foreach($tour->images as $img)
                                <div class="relative group w-24 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm">
                                    <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                    
                                    <!-- Delete Button Trigger -->
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                        <button type="button" onclick="if(confirm('{{ __('Delete this photo?') }}')) { document.getElementById('delete-image-{{ $loop->index }}').submit(); }" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg" title="{{ __('Delete Photo') }}">
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
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Trip Description') }}</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ $tour->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>

    <!-- Hidden Delete Forms -->
    <form id="delete-main-image" action="{{ route('admin.tours.delete-main-image', $tour->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @if($tour->images)
        @foreach($tour->images as $img)
            <form id="delete-image-{{ $loop->index }}" action="{{ route('admin.tours.delete-image', $tour->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_path" value="{{ $img }}">
            </form>
        @endforeach
    @endif
</div>
@endsection
