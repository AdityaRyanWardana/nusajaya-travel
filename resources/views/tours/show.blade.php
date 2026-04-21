@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-16 pb-24">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 hover:text-brandblue transition group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to All Packages
        </a>

        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Left: Cinematic Content -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Main Slider -->
                <div class="relative h-[500px] rounded-[3rem] overflow-hidden shadow-2xl group/slider">
                    <div class="swiper mySwiper h-full w-full">
                        <div class="swiper-wrapper">
                            <!-- Main Image -->
                            <div class="swiper-slide">
                                <img src="{{ $tour->image ? (Str::startsWith($tour->image, 'http') ? $tour->image : asset('storage/' . $tour->image)) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2070&auto=format&fit=crop' }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-brandblue via-transparent to-transparent opacity-90"></div>
                            </div>
                            
                            <!-- Gallery Images -->
                            @if($tour->images)
                                @foreach($tour->images as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-brandblue via-transparent to-transparent opacity-90"></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="swiper-button-next !text-white !w-12 !h-12 bg-white/10 backdrop-blur-md rounded-full opacity-0 group-hover/slider:opacity-100 transition-all after:!text-sm"></div>
                        <div class="swiper-button-prev !text-white !w-12 !h-12 bg-white/10 backdrop-blur-md rounded-full opacity-0 group-hover/slider:opacity-100 transition-all after:!text-sm"></div>
                        <div class="swiper-pagination !bottom-12"></div>
                    </div>

                    <!-- Overlay Info -->
                    <div class="absolute bottom-12 left-12 right-12 z-50 pointer-events-none">
                        <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 inline-block">
                            {{ $tour->destination }}
                        </span>
                        <h1 class="text-5xl font-black text-white uppercase italic leading-[0.9] tracking-tighter">{{ $tour->title }}</h1>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-brandblue uppercase italic mb-6">About the Experience</h2>
                    <p class="text-slate-500 font-medium leading-relaxed mb-10">{{ $tour->description }}</p>
                    
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8">Package Inclusions</h3>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Expert Local Guide</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">VIP Transport</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.703 2.703 0 01-3 0 2.703 2.703 0 01-3 0 2.703 2.703 0 01-3 0 2.701 2.701 0 01-1.5-.454M9 16v2m3-6v6m3-8v8m-9-6a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Gourmet Dinner</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Digital Memories</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Premium Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-brandblue rounded-[3rem] p-10 text-white shadow-2xl sticky top-32">
                    <p class="text-[10px] font-black text-skyblue uppercase tracking-[0.4em] mb-4">Base Package</p>
                    <div class="flex items-baseline gap-2 mb-10">
                        <span class="text-sm font-bold opacity-60">IDR</span>
                        <span class="text-4xl font-black italic tracking-tighter">{{ number_format($tour->price, 0, ',', '.') }}</span>
                        <span class="text-xs font-bold opacity-60">/ pax</span>
                    </div>

                    @auth
                    <form action="{{ route('tours.book', $tour->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Select Date</label>
                            <input type="date" name="date" required class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Total Guests</label>
                            <select name="guests" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none appearance-none cursor-pointer">
                                @for($i=1; $i<=10; $i++) <option value="{{ $i }}" class="text-brandblue">{{ $i }} Person{{ $i > 1 ? 's' : '' }}</option> @endfor
                            </select>
                        </div>
                        <button type="submit" class="w-full py-5 bg-skyblue hover:bg-white hover:text-brandblue text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] transition-all duration-500 shadow-xl shadow-skyblue/20">
                            Book Experience
                        </button>
                    </form>
                    @else
                    <div class="space-y-6">
                        <p class="text-xs font-medium text-white/60 leading-relaxed italic">Login to your account to unlock exclusive member rates and secure your spot.</p>
                        <a href="{{ route('login') }}" class="block w-full py-5 bg-white text-brandblue rounded-2xl text-xs font-black text-center uppercase tracking-[0.3em] hover:bg-skyblue hover:text-white transition-all duration-500 shadow-xl">
                            Login & Book
                        </a>
                        <p class="text-[10px] text-center font-bold text-white/40 uppercase tracking-widest leading-none">Not a member? <a href="{{ route('register') }}" class="text-skyblue border-b border-skyblue/30">Join the club</a></p>
                    </div>
                    @endauth

                    <div class="mt-12 pt-12 border-t border-white/10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-8 h-8 rounded-full bg-skyblue/20 flex items-center justify-center text-skyblue">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest italic">Safety Certified</p>
                        </div>
                        <p class="text-[9px] text-white/40 leading-relaxed font-medium">All-in service includes professional guide, premium transport, and insurance coverage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 0,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
@endpush
