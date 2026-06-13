@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.armadas.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        {{ __('Back to List') }}
    </a>
    <h2 class="text-2xl font-bold text-slate-800">{{ __('Edit Fleet') }}: {{ $armada->name }}</h2>
    <p class="text-slate-500 text-sm">{{ __('Update your transportation vehicle information.') }}</p>
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
    <form action="{{ route('admin.armadas.update', $armada->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Column: Info & Pricing --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- General Info Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('General Information') }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Vehicle identity and specifications</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="name" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Vehicle Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ $armada->name }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Vehicle Type') }}</label>
                            <div class="relative">
                                <select name="type" id="type" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium appearance-none cursor-pointer">
                                    <option value="Bus" {{ $armada->type == 'Bus' ? 'selected' : '' }}>Bus</option>
                                    <option value="Coaster" {{ $armada->type == 'Coaster' ? 'selected' : '' }}>Coaster</option>
                                    <option value="Van" {{ $armada->type == 'Van' ? 'selected' : '' }}>Van</option>
                                    <option value="Private Car" {{ $armada->type == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="capacity" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Passenger Capacity') }}</label>
                            <input type="number" name="capacity" id="capacity" value="{{ $armada->capacity }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="total_units" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Total Units in Inventory') }}</label>
                            <input type="number" name="total_units" id="total_units" value="{{ $armada->total_units ?? 1 }}" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium" required>
                        </div>

                        <div>
                            <label for="maintenance_units" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Units Under Repair') }}</label>
                            <div class="relative">
                                <input type="number" name="maintenance_units" id="maintenance_units" value="{{ $armada->maintenance_units ?? 0 }}" class="w-full px-4 py-3 bg-slate-100/50 rounded-xl border border-slate-200 text-slate-400 cursor-not-allowed outline-none font-medium" readonly>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 italic">Managed via Maintenance Log below</p>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-xs font-semibold text-slate-600 mb-2">{{ __('Short Description / Notes') }}</label>
                            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-700 font-medium resize-none">{{ $armada->description }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Pricing Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                            <i data-lucide="banknote" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Pricing Details') }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Rates for city tours and external routes</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">City Tour Rates</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="price_city_one_way" class="block text-xs font-semibold text-slate-600 mb-2">One Way Transfer (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_one_way" id="price_city_one_way" value="{{ intval($armada->price_city_one_way) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_half_day" class="block text-xs font-semibold text-slate-600 mb-2">Half Day - 4H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_half_day" id="price_city_half_day" value="{{ intval($armada->price_city_half_day) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_one_day" class="block text-xs font-semibold text-slate-600 mb-2">One Day - 8H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_one_day" id="price_city_one_day" value="{{ intval($armada->price_city_one_day) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_full_day" class="block text-xs font-semibold text-slate-600 mb-2">Full Day - 12H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_full_day" id="price_city_full_day" value="{{ intval($armada->price_city_full_day) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">External Routes</p>
                            <div>
                                <label for="price_barelang" class="block text-xs font-semibold text-slate-600 mb-2">Barelang Round Trip (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                    <input type="number" name="price_barelang" id="price_barelang" value="{{ intval($armada->price_barelang) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-200 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all text-slate-700 font-medium" required>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Vehicle Cover') }}</h3>
                        </div>
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
                        <div x-show="!coverPreview && '{{ $armada->image }}'" class="relative group aspect-video rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                            <img src="{{ $armada->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <button type="button" onclick="if(confirm('{{ __('Delete this cover photo?') }}')) { document.getElementById('delete-main-image').submit(); }" class="w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center hover:bg-red-600 transition-all shadow-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="file" name="image" id="image" class="hidden" @change="handleCoverChange">
                            <label for="image" class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-400 transition-all group">
                                <div class="w-12 h-12 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-all mb-3 shadow-sm">
                                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                </div>
                                <span id="image-label" class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Upload Cover Photo') }}</span>
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
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Fleet Gallery') }}</h3>
                        </div>
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
                        @if($armada->images)
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($armada->images as $img)
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
                                            <button type="button" onclick="if(confirm('{{ __('Delete this gallery photo?') }}')) { document.getElementById('delete-image-{{ $loop->index }}').submit(); }" class="w-10 h-10 bg-red-500 text-white rounded-xl flex items-center justify-center hover:bg-red-600 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="relative">
                            <input type="file" name="gallery[]" id="gallery" multiple class="hidden" @change="handleGalleryChange">
                            <label for="gallery" class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-400 transition-all group">
                                <div class="w-12 h-12 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-all mb-3 shadow-sm">
                                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                                </div>
                                <span id="gallery-label" class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Add Gallery Photos') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5">
                        {{ __('Save All Changes') }}
                    </button>
                    <a href="{{ route('admin.armadas.index') }}" class="w-full py-4 bg-white text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all text-center border border-slate-200 shadow-sm">
                        {{ __('Cancel and Return') }}
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Maintenance Log Section --}}
    <div class="mt-8 bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 max-w-5xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-6 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl flex items-center justify-center text-red-600 shadow-sm border border-red-100">
                    <i data-lucide="wrench" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Maintenance Log') }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Manage vehicles that are currently under repair.</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-50/50 rounded-2xl p-6 mb-8 border border-slate-200 shadow-sm">
            <form action="{{ route('admin.armadas.maintenance.store', $armada->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Vehicle ID / Plate No.</label>
                    <input type="text" name="vehicle_name" placeholder="e.g. BP 1234 XY" class="w-full px-4 py-3 bg-white rounded-xl border border-slate-200 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm text-slate-700 font-medium" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Expected Finish Date</label>
                    <input type="date" name="expected_finish_date" class="w-full px-4 py-3 bg-white rounded-xl border border-slate-200 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm text-slate-700 font-medium" required>
                </div>
                <div>
                    <button type="submit" class="w-full py-3.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-all shadow-md hover:shadow-red-500/20">
                        + Send to Repair
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($armada->maintenances()->orderBy('created_at', 'desc')->get() as $log)
                <div class="flex flex-col sm:flex-row items-center justify-between p-5 bg-white border border-slate-200 rounded-xl {{ $log->status === 'completed' ? 'opacity-60 bg-slate-50' : 'shadow-sm' }}">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $log->status === 'completed' ? 'bg-slate-200 text-slate-500' : 'bg-red-50 text-red-500 border border-red-100' }}">
                            <i data-lucide="{{ $log->status === 'completed' ? 'check-circle' : 'tool' }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $log->vehicle_name }}</p>
                            <p class="text-xs text-slate-500 mt-1">Est. Finish: <span class="font-semibold text-slate-700">{{ $log->expected_finish_date->format('d M Y') }}</span></p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        @if($log->status === 'active')
                            <form action="{{ route('admin.armadas.maintenance.complete', [$armada->id, $log->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-white border border-emerald-500 text-emerald-600 hover:bg-emerald-50 rounded-lg text-xs font-semibold transition-all">
                                    Mark as Ready
                                </button>
                            </form>
                        @else
                            <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-xs font-semibold">
                                Completed
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-slate-500 text-sm">No active maintenance records.</p>
                </div>
            @endforelse
        </div>
    </div>

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
