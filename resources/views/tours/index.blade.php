@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-16 pb-24">
    <div class="max-w-7xl mx-auto">
        <!-- Premium Header & Search -->
        <div class="mb-20 grid lg:grid-cols-2 gap-12 items-end">
            <div class="reveal-left">
                <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">{{ __('Official Curator') }}</span>
                <h1 class="text-5xl font-black text-brandblue uppercase italic mb-6 leading-[0.9]">{{ __('Batam Tour Packages') }}</h1>
                <p class="text-sm text-slate-500 font-medium max-w-lg leading-relaxed">{{ __('Explore our carefully curated tour packages for an unforgettable experience in Batam and its surrounding islands.') }}</p>
            </div>
            
            <form action="{{ route('tours.index') }}" method="GET" class="bg-white p-6 rounded-[3rem] shadow-2xl shadow-brandblue/5 border border-slate-50 flex flex-col sm:flex-row items-center gap-6 reveal-right">
                <div class="flex-1 flex items-center gap-6 px-8 w-full sm:w-auto">
                    <svg class="w-8 h-8 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <div class="flex flex-col gap-1 w-full">
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Search Destination') }}</span>
                        <input type="text" name="category" value="{{ request('category') != 'All' ? request('category') : '' }}" placeholder="{{ __('E.g. Ranoh Island') }}" class="text-base font-black text-brandblue uppercase border-none p-0 focus:ring-0 placeholder:text-slate-200 w-full outline-none">
                    </div>
                </div>
                <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-brandblue text-white rounded-[2rem] text-[11px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all">{{ __('Find Tours') }}</button>
            </form>
        </div>

        <!-- Tours Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($tours as $tour)
                <div class="group relative bg-white rounded-[3rem] overflow-hidden border border-slate-100 hover:shadow-2xl hover:shadow-brandblue/5 transition-all duration-700 reveal">
                    <!-- Whole Card Link -->
                    <a href="{{ route('tours.show', $tour->slug) }}" class="absolute inset-0 z-20" aria-label="View {{ $tour->title }} details"></a>
                    
                    <!-- Image Wrapper -->
                    <div class="h-80 overflow-hidden relative">
                        @php
                            $imageSrc = 'https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop'; // Default
                            
                            if (!$tour->image && Str::contains(Str::lower($tour->title), 'ranoh')) {
                                $imageSrc = asset('images/ranoh_island.jpg');
                            }

                            if ($tour->image) {
                                if (Str::startsWith($tour->image, 'http')) {
                                    $imageSrc = $tour->image;
                                } elseif (file_exists(public_path($tour->image))) {
                                    $imageSrc = asset($tour->image);
                                } else {
                                    $imageSrc = asset('storage/' . $tour->image);
                                }
                            }
                        @endphp
                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent opacity-80"></div>
                        
                        <!-- Floating Category Label -->
                        <div class="absolute top-8 left-8">
                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[9px] font-black uppercase tracking-widest rounded-full">
                                {{ __($tour->destination) }}
                            </span>
                        </div>

                        <!-- Price Tag -->
                        <div class="absolute bottom-8 right-8">
                            <p class="text-[10px] text-white/60 font-black uppercase tracking-widest text-right mb-1">{{ __('From') }}</p>
                            <p class="text-xl font-black text-skyblue italic">IDR {{ number_format($tour->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-10">
                        <h3 class="text-2xl font-black text-brandblue uppercase italic mb-4 leading-none group-hover:text-skyblue transition">{{ __($tour->title) }}</h3>
                        <p class="text-sm text-slate-500 font-medium line-clamp-2 leading-relaxed mb-8">{{ __($tour->description) }}</p>
                        
                        <div class="flex items-center justify-between w-full p-2 pl-6 bg-slate-50 rounded-2xl group/btn hover:bg-brandblue transition-all duration-500 relative z-30 pointer-events-none">
                            <span class="text-[10px] font-black text-brandblue uppercase tracking-[0.2em] group-hover/btn:text-white transition">{{ __('Full Details') }}</span>
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-brandblue shadow-sm group-hover/btn:bg-skyblue group-hover/btn:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-400 font-bold">{{ __('No tours found in this category.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</main>
@endsection
