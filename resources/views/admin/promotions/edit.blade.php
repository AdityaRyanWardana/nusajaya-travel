@extends('layouts.admin')

@section('content')
<div class="mb-10">
    <a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors mb-6 group">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
        {{ __('Back to Campaigns') }}
    </a>
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-600 rounded-[2rem] flex items-center justify-center text-white shadow-xl shadow-blue-100">
            <i data-lucide="edit-3" class="w-7 h-7"></i>
        </div>
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ __('Edit Campaign') }}</h2>
            <p class="text-slate-500 text-sm font-medium">{{ __('Modify campaign details and scheduling.') }}</p>
        </div>
    </div>
</div>

<div class="max-w-5xl" x-data="{ 
    coverPreview: null,
    handleCoverChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.coverPreview = URL.createObjectURL(file);
        }
    }
}">
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Left Side: Main Info --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- Campaign Content Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 shadow-sm">
                            <i data-lucide="type" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Campaign Content') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label for="title" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Campaign Title') }}</label>
                            <input type="text" name="title" id="title" value="{{ $promotion->title }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" placeholder="{{ __('Example: Batam Weekend Getaway') }}" required>
                        </div>

                        <div>
                            <label for="description" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Campaign Description') }}</label>
                            <textarea name="description" id="description" rows="4" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium text-slate-600 resize-none leading-relaxed" placeholder="{{ __('Describe the promotion details...') }}">{{ $promotion->description }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Targeting & Links Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm">
                            <i data-lucide="target" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Strategy & Links') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="type" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Promotion Strategy') }}</label>
                            <div class="relative">
                                <select name="type" id="type" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="general" {{ $promotion->type == 'general' ? 'selected' : '' }}>{{ __('General / Manual') }}</option>
                                    <option value="tour" {{ $promotion->type == 'tour' ? 'selected' : '' }}>{{ __('Tour Package') }}</option>
                                    <option value="transport" {{ $promotion->type == 'transport' ? 'selected' : '' }}>{{ __('Transport') }}</option>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="tour_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Link to Tour Package') }}</label>
                            <div class="relative">
                                <select name="tour_id" id="tour_id" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">{{ __('--- Select Tour Package ---') }}</option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}" {{ $promotion->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->title }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="link" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Custom URL (Optional)') }}</label>
                            <input type="text" name="link" id="link" value="{{ $promotion->link }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" placeholder="{{ __('Example: /tours') }}">
                        </div>

                        <div>
                            <label for="link_text" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Button Text') }}</label>
                            <input type="text" name="link_text" id="link_text" value="{{ $promotion->link_text }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" placeholder="{{ __('Example: Book Now') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Visuals & Schedule --}}
            <div class="space-y-12">
                {{-- Media Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 shadow-sm">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Campaign Visual') }}</h3>
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
                        <div x-show="!coverPreview && '{{ $promotion->image }}'" class="relative group aspect-video rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                            <img src="{{ $promotion->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <button type="button" onclick="if(confirm('{{ __('Delete promotion image?') }}')) { document.getElementById('delete-promo-image').submit(); }" class="w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center hover:bg-red-600 transition-all shadow-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="file" name="image" id="image" class="hidden" @change="handleCoverChange">
                            <label for="image" class="flex flex-col items-center justify-center w-full py-12 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-50 transition-all group px-4 text-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:text-blue-500 transition-all mb-4">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Change Banner Image') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Settings & Schedule Section --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 shadow-sm">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">{{ __('Schedule') }}</h3>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label for="badge" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Campaign Badge') }}</label>
                            <input type="text" name="badge" id="badge" value="{{ $promotion->badge }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-black text-red-500" placeholder="{{ __('Example: FLASH SALE') }}">
                        </div>

                        <div>
                            <label for="expires_at" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Expiration Date') }}</label>
                            <input type="datetime-local" name="expires_at" id="expires_at" value="{{ $promotion->expires_at ? $promotion->expires_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700">
                        </div>

                        <label class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all border border-slate-100">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $promotion->is_active ? 'checked' : '' }} class="w-6 h-6 text-blue-600 border-slate-300 rounded-lg focus:ring-blue-500 transition-all">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest leading-none mb-1">{{ __('Publish Live') }}</span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ __('Visible on website immediately') }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-[2rem] hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20">
                        {{ __('Update Campaign') }}
                    </button>
                    <a href="{{ route('admin.promotions.index') }}" class="w-full py-6 bg-white text-slate-400 text-xs font-black uppercase tracking-widest rounded-[2rem] hover:bg-slate-50 transition-all text-center border border-slate-100">
                        {{ __('Cancel Changes') }}
                    </a>
                </div>
            </div>
        </div>
    </form>

    <form id="delete-promo-image" action="{{ route('admin.promotions.delete-image', $promotion->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tourSelect = document.getElementById('tour_id');
        const typeSelect = document.getElementById('type');
        const manualLinkInput = document.getElementById('link');

        function updateState() {
            if (tourSelect.value) {
                typeSelect.value = 'tour';
                manualLinkInput.placeholder = 'Locked (linked to tour)';
                manualLinkInput.readOnly = true;
                manualLinkInput.classList.add('opacity-50');
            } else {
                manualLinkInput.placeholder = 'Example: /tours';
                manualLinkInput.readOnly = false;
                manualLinkInput.classList.remove('opacity-50');
            }
        }

        tourSelect.addEventListener('change', updateState);
        updateState(); // Initialize on load
    });
</script>
@endpush

