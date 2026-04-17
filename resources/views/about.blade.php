@extends('layouts.public')

@section('content')
<!-- Hero Section About -->
<header class="relative bg-brandblue py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-40">
        <img src="{{ asset('images/about_hero.jpg') }}" class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-8 text-center">
        <h1 class="text-5xl font-black text-white mb-6 uppercase tracking-tight">About Us</h1>
        <p class="text-xl text-skyblue font-bold max-w-2xl mx-auto">Serving unforgettable travel experiences since 1995.</p>
    </div>
</header>

<!-- Main Profile Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <span class="text-skyblue font-black uppercase tracking-widest text-xs mb-4 block">Our Story</span>
            <h2 class="text-4xl font-black text-brandblue mb-8 leading-tight italic">PT Nusa Jaya Indofast Tour & Travel</h2>
            <div class="space-y-6 text-slate-600 leading-relaxed font-medium">
                <p>
                    Established in 1995, PT Nusa Jaya Indofast (Nusajaya 168) has grown to become one of the most trusted and comprehensive travel service providers in Batam and the Riau Islands region.
                </p>
                <p>
                    Under the brand <span class="text-brandblue font-bold italic">VisitToBatam.com</span>, we specialize in creating seamless travel experiences, connecting thousands of local and international tourists to the beauty of Indonesia, Singapore, and Malaysia.
                </p>
                <p>
                    With over 25 years of experience, we maintain a vast network of partnerships with premium hotels, resorts, and ferry operators to ensure our clients receive only the best quality at competitive prices.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-4">
                <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="rounded-3xl shadow-lg h-60 w-full object-cover">
                <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=2071&auto=format&fit=crop" class="rounded-3xl shadow-lg h-40 w-full object-cover">
            </div>
            <div class="space-y-4 pt-8">
                <img src="{{ asset('images/fleet.png') }}" class="rounded-3xl shadow-lg h-40 w-full object-cover">
                <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop" class="rounded-3xl shadow-lg h-60 w-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Values & Stats -->
<section class="bg-lightbg py-20 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-4 gap-8">
        <div class="text-center p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
            <p class="text-4xl font-black text-brandblue mb-2">25+</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Years Experience</p>
        </div>
        <div class="text-center p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
            <p class="text-4xl font-black text-brandblue mb-2">50+</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Premium Fleet</p>
        </div>
        <div class="text-center p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
            <p class="text-4xl font-black text-brandblue mb-2">10k+</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Happy Travelers</p>
        </div>
        <div class="text-center p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
            <p class="text-4xl font-black text-brandblue mb-2">100%</p>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Official & Licensed</p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-brandblue mb-4 uppercase italic">Our Core Services</h2>
            <div class="h-1.5 w-24 bg-skyblue mx-auto rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-10 bg-lightbg rounded-3xl hover:bg-brandblue hover:text-white transition duration-500 group">
                <div class="w-14 h-14 bg-skyblue/20 rounded-2xl flex items-center justify-center text-brandblue mb-6 group-hover:bg-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Inbound & Outbound Tours</h3>
                <p class="text-sm opacity-60 leading-relaxed font-medium">Customized travel packages for individuals, families, and corporate groups across Asia.</p>
            </div>
            
            <div class="p-10 bg-lightbg rounded-3xl hover:bg-brandblue hover:text-white transition duration-500 group">
                <div class="w-14 h-14 bg-skyblue/20 rounded-2xl flex items-center justify-center text-brandblue mb-6 group-hover:bg-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Transport Solutions</h3>
                <p class="text-sm opacity-60 leading-relaxed font-medium">A diverse fleet including SUVs, luxury minivans (Hiace), and big buses for all group sizes.</p>
            </div>
            
            <div class="p-10 bg-lightbg rounded-3xl hover:bg-brandblue hover:text-white transition duration-500 group">
                <div class="w-14 h-14 bg-skyblue/20 rounded-2xl flex items-center justify-center text-brandblue mb-6 group-hover:bg-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Corporate & Golf</h3>
                <p class="text-sm opacity-60 leading-relaxed font-medium">Specialized corporate gatherings, seminars, and premium golf/spa destination packages.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Bar -->
<section class="max-w-7xl mx-auto px-8 pb-20">
    <div class="bg-brandblue rounded-3xl p-12 text-white flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-md">
                <svg class="w-8 h-8 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-skyblue mb-1">Visit Our Office</p>
                <p class="text-lg font-bold leading-tight">Kawasan Pantai Indah Mutiara, Blok B No 36-37, Tj. Buntung, Kota Batam, Kepulauan Riau, Batam, Riau, Indonesia 29432</p>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="tel:+62778457168" class="bg-white text-brandblue px-8 py-4 rounded-2xl font-black text-sm hover:bg-skyblue hover:text-white transition">CALL US</a>
            <a href="mailto:reservation@nusajaya168.com" class="bg-skyblue text-white px-8 py-4 rounded-2xl font-black text-sm hover:bg-white hover:text-brandblue transition">EMAIL NOW</a>
        </div>
    </div>
</section>
@endsection
