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
        document.getElementById('gallery-label').innerText = files.length + ' files selected';
    }
}">
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Column: Main Details --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- Package Information Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                            <i data-lucide="map" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('New Experience') }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Tour details and specifications</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="title" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Package Title') }}</label>
                            <input type="text" name="title" id="title" placeholder="{{ __('Example: Magical Batam Sunset Tour') }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="destination" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Primary Destination') }}</label>
                            <input type="text" name="destination" id="destination" placeholder="{{ __('Example: Barelang Bridge') }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="duration" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Package Duration') }}</label>
                            <input type="text" name="duration" id="duration" placeholder="{{ __('Example: 3 Days 2 Nights') }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="price" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Price Per Guest (IDR)') }}</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                <input type="number" name="price" id="price" placeholder="2500000" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                            </div>
                        </div>

                        <div>
                            <label for="armada_id" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Auto-Assigned Fleet') }}</label>
                            <div class="relative">
                                <select name="armada_id" id="armada_id" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium appearance-none cursor-pointer">
                                    <option value="">{{ __('No specific fleet') }}</option>
                                    @foreach($armadas as $armada)
                                        <option value="{{ $armada->id }}">
                                            {{ $armada->name }} ({{ $armada->capacity }} Seats)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Full Itinerary Description') }}</label>
                            <textarea name="description" id="description" rows="6" placeholder="{{ __('Explain trip details, facilities, and schedule...') }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium resize-none"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Inclusions Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-amber-500"></div>
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-xl flex items-center justify-center text-amber-600 shadow-sm border border-amber-100">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Package Inclusions') }}</h3>
                            <p class="text-xs text-slate-400 mt-1">What's included in this tour</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($availableInclusions as $inclusion)
                            <label class="group relative flex flex-col items-center p-6 bg-slate-50 border border-slate-100 rounded-[2rem] cursor-pointer hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300">
                                <input type="checkbox" name="inclusions[]" value="{{ json_encode($inclusion) }}" class="hidden peer">
                                
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
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-purple-500"></div>
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl flex items-center justify-center text-purple-600 shadow-sm border border-purple-100">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Cover View') }}</h3>
                        </div>
                    </div>

                    <div class="space-y-6">
                        {{-- New Preview --}}
                        <template x-if="coverPreview">
                            <div class="relative group aspect-video rounded-3xl overflow-hidden border-4 border-blue-500 shadow-xl animate-in zoom-in-95 duration-300">
                                <img :src="coverPreview" class="w-full h-full object-cover">
                            </div>
                        </template>

                        <div class="relative">
                            <input type="file" name="image" id="image" class="hidden" @change="handleCoverChange" required>
                            <label for="image" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group text-center px-4">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <span id="image-label" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Upload Package Cover') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Gallery Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange-500"></div>
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-xl flex items-center justify-center text-orange-600 shadow-sm border border-orange-100">
                            <i data-lucide="images" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Experience Gallery') }}</h3>
                        </div>
                    </div>

                    <div class="space-y-8">
                        {{-- New Gallery Previews --}}
                        <div class="grid grid-cols-2 gap-4" x-show="galleryPreviews.length > 0">
                            <template x-for="(preview, index) in galleryPreviews" :key="index">
                                <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 border-blue-500 shadow-lg animate-in zoom-in-95">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>

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
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5">
                        {{ __('Save and Publish') }}
                    </button>
                    <a href="{{ route('admin.tours.index') }}" class="w-full py-4 bg-white text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all text-center border border-slate-200 shadow-sm">
                        {{ __('Cancel and Return') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
