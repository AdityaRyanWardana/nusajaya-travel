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

<div class="max-w-5xl" x-data="{ 
    coverPreview: null,
    galleryPreviews: [],
    handleCoverChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.coverPreview = URL.createObjectURL(file);
            document.getElementById('image-label').innerText = file.name;
        }
    },
    handleGalleryChange(e) {
        const files = Array.from(e.target.files);
        this.galleryPreviews = files.map(file => URL.createObjectURL(file));
        document.getElementById('gallery-label').innerText = files.length + ' new files selected';
    }
}">
    <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Column: Main Details --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- Package Information Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 shadow-sm">
                            <i data-lucide="map" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Package Details') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <label for="title" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Package Title') }}</label>
                            <input type="text" name="title" id="title" value="{{ $tour->title }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="destination" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Primary Destination') }}</label>
                            <input type="text" name="destination" id="destination" value="{{ $tour->destination }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="duration" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Package Duration') }}</label>
                            <input type="text" name="duration" id="duration" value="{{ $tour->duration }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="price" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Price Per Guest (IDR)') }}</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                <input type="number" name="price" id="price" value="{{ intval($tour->price) }}" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                            </div>
                        </div>

                        <div>
                            <label for="armada_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Auto-Assigned Fleet') }}</label>
                            <div class="relative">
                                <select name="armada_id" id="armada_id" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">{{ __('No specific fleet') }}</option>
                                    @foreach($armadas as $armada)
                                        <option value="{{ $armada->id }}" {{ $tour->armada_id == $armada->id ? 'selected' : '' }}>
                                            {{ $armada->name }} ({{ $armada->capacity }} Seats)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="bus" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Full Itinerary Description') }}</label>
                            <textarea name="description" id="description" rows="6" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium text-slate-600 resize-none leading-relaxed">{{ $tour->description }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Inclusions Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 shadow-sm">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Package Inclusions') }}</h3>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($availableInclusions as $inclusion)
                            @php
                                $isChecked = false;
                                if ($tour->inclusions) {
                                    foreach($tour->inclusions as $tourInc) {
                                        if (is_array($tourInc) && isset($tourInc['id']) && $tourInc['id'] === $inclusion['id']) {
                                            $isChecked = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            <label class="group relative flex flex-col items-center p-6 bg-slate-50 border border-slate-100 rounded-[2rem] cursor-pointer hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300">
                                <input type="checkbox" name="inclusions[]" value="{{ json_encode($inclusion) }}" {{ $isChecked ? 'checked' : '' }} class="hidden peer">
                                
                                {{-- Checkmark --}}
                                <div class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:bg-blue-600 peer-checked:border-blue-600 flex items-center justify-center transition-all">
                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                </div>

                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-4 text-slate-400 group-hover:text-blue-500 transition-colors peer-checked:text-blue-600 peer-checked:shadow-blue-100">
                                    <i data-lucide="{{ $inclusion['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                
                                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest text-center peer-checked:text-blue-700 transition-colors">
                                    {{ __($inclusion['label']) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Media --}}
            <div class="space-y-12">
                {{-- Main Photo Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 shadow-sm">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Cover View') }}</h3>
                    </div>

                    <div class="space-y-6">
                        {{-- New Preview --}}
                        <template x-if="coverPreview">
                            <div class="relative group aspect-video rounded-3xl overflow-hidden border-4 border-blue-500 shadow-xl animate-in zoom-in-95 duration-300">
                                <img :src="coverPreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-blue-600/20 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg">New Selection</span>
                                </div>
                            </div>
                        </template>

                        {{-- Existing Image --}}
                        <div x-show="!coverPreview && '{{ $tour->image }}'" class="relative group aspect-video rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                            <img src="{{ $tour->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <button type="button" onclick="if(confirm('{{ __('Delete cover?') }}')) { document.getElementById('delete-main-image').submit(); }" class="w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center hover:bg-red-600 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="file" name="image" id="image" class="hidden" @change="handleCoverChange">
                            <label for="image" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group text-center px-4">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <span id="image-label" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Set New Cover Image') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Gallery Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 shadow-sm">
                            <i data-lucide="images" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Experience Gallery') }}</h3>
                    </div>

                    <div class="space-y-8">
                        {{-- New Gallery Previews --}}
                        <div class="grid grid-cols-2 gap-4" x-show="galleryPreviews.length > 0">
                            <template x-for="(preview, index) in galleryPreviews" :key="index">
                                <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 border-blue-500 shadow-lg animate-in zoom-in-95">
                                    <img :src="preview" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-blue-600/10"></div>
                                </div>
                            </template>
                        </div>

                        {{-- Existing Gallery --}}
                        @if($tour->images)
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($tour->images as $img)
                                    <div class="relative group aspect-square rounded-2xl overflow-hidden border border-slate-50 shadow-sm">
                                    @php
                                        $gallerySrc = $img;
                                        if (!Str::startsWith($gallerySrc, 'http')) {
                                            if (Str::startsWith($gallerySrc, 'images/')) {
                                                $gallerySrc = asset($gallerySrc);
                                            } else {
                                                $gallerySrc = asset('storage/' . $gallerySrc);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $gallerySrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                            <button type="button" onclick="if(confirm('{{ __('Delete photo?') }}')) { document.getElementById('delete-image-{{ $loop->index }}').submit(); }" class="w-10 h-10 bg-red-500 text-white rounded-xl flex items-center justify-center hover:bg-red-600 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="relative">
                            <input type="file" name="gallery[]" id="gallery" multiple class="hidden" @change="handleGalleryChange">
                            <label for="gallery" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group text-center px-4">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                                </div>
                                <span id="gallery-label" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Add Experience Photos') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-3xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20">
                        {{ __('Update Experience') }}
                    </button>
                    <a href="{{ route('admin.tours.index') }}" class="w-full py-6 bg-white text-slate-400 text-xs font-black uppercase tracking-widest rounded-3xl hover:bg-slate-50 transition-all text-center border border-slate-100">
                        {{ __('Cancel and Return') }}
                    </a>
                </div>
            </div>
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
