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
    <form action="{{ route('admin.armadas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Column: Info & Pricing --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- General Info Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 shadow-sm">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('General Information') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Vehicle Name') }}</label>
                            <input type="text" name="name" id="name" placeholder="{{ __('Example: Toyota Van Premio 2024') }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="type" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Vehicle Type') }}</label>
                            <div class="relative">
                                <select name="type" id="type" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="Bus">Bus</option>
                                    <option value="Coaster">Coaster</option>
                                    <option value="Van">Van</option>
                                    <option value="Private Car">Private Car</option>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="capacity" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Passenger Capacity') }}</label>
                            <input type="number" name="capacity" id="capacity" placeholder="14" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="total_units" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Total Units in Inventory') }}</label>
                            <input type="number" name="total_units" id="total_units" value="1" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div>
                            <label for="maintenance_units" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Units Under Repair') }}</label>
                            <input type="number" name="maintenance_units" id="maintenance_units" value="0" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Short Description / Notes') }}</label>
                            <textarea name="description" id="description" rows="4" placeholder="{{ __('Describe vehicle features or facilities...') }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 resize-none"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Pricing Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm">
                            <i data-lucide="banknote" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Pricing Details') }}</h3>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-6 border-b border-slate-50 pb-2">City Tour Rates</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="price_city_one_way" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">One Way Transfer (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_one_way" id="price_city_one_way" placeholder="500000" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_half_day" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Half Day - 4H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_half_day" id="price_city_half_day" placeholder="800000" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_one_day" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">One Day - 8H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_one_day" id="price_city_one_day" placeholder="1200000" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="price_city_full_day" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Full Day - 12H (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="price_city_full_day" id="price_city_full_day" placeholder="1500000" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-6 border-b border-slate-50 pb-2">External Routes</p>
                            <div>
                                <label for="price_barelang" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Barelang Round Trip (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                    <input type="number" name="price_barelang" id="price_barelang" placeholder="1800000" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-black text-slate-700" required>
                                </div>
                            </div>
                        </div>
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
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Vehicle Cover') }}</h3>
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
                            <label for="image" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <span id="image-label" class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center px-4">{{ __('Upload Main Photo') }}</span>
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
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Fleet Gallery') }}</h3>
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
                            <label for="gallery" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                                </div>
                                <span id="gallery-label" class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center px-4">{{ __('Add Gallery Photos') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-3xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20">
                        {{ __('Save and Publish') }}
                    </button>
                    <a href="{{ route('admin.armadas.index') }}" class="w-full py-6 bg-white text-slate-400 text-xs font-black uppercase tracking-widest rounded-3xl hover:bg-slate-50 transition-all text-center border border-slate-100">
                        {{ __('Cancel and Return') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
