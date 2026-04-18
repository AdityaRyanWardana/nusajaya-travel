@extends('layouts.public')

@section('content')
<!-- Premium Hero Section -->
<header class="relative h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover scale-110 blur-[2px] opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-brandblue via-brandblue/80 to-transparent"></div>
    </div>
    <div class="relative z-10 text-center max-w-4xl px-8">
        <span class="inline-block px-4 py-1.5 bg-skyblue/20 backdrop-blur-md border border-white/20 text-white rounded-full text-[10px] font-black uppercase tracking-[0.4em] mb-6 animate-pulse shadow-sm">Established 1995</span>
        <h1 class="text-6xl font-black text-white mb-6 uppercase tracking-tighter leading-none italic drop-shadow-2xl">Defining Travel <br><span class="text-skyblue">Excellence</span></h1>
        <p class="text-xl text-white font-bold drop-shadow-lg opacity-100">PT Nusa Jaya Indofast Tour & Travel is Batam's premier gateway to extraordinary experiences in the Riau Islands.</p>
    </div>
</header>

<!-- Story & Vision -->
<section class="relative z-20 -mt-20">
    <div class="max-w-7xl mx-auto px-8">
        <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl border border-slate-50 grid md:grid-cols-2 gap-20">
            <div>
                <h2 class="text-4xl font-black text-brandblue mb-10 leading-none uppercase">Our Journey <br>& Legacy</h2>
                <div class="space-y-8 text-slate-500 font-medium leading-relaxed text-lg">
                    <p>
                        Born from a vision to revolutionize tourism in the Riau Islands, <span class="text-brandblue font-bold">PT Nusa Jaya Indofast (Nusajaya 168)</span> has spent over 25 years perfecting the art of hospitality.
                    </p>
                    <p>
                        As the pioneers behind <span class="italic font-bold text-skyblue">VisitToBatam.com</span>, we bridge the gap between world-class standards and local authenticity, serving thousands of travelers across Southeast Asia.
                    </p>
                </div>
                
                <div class="mt-16 grid grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <div class="h-1 w-12 bg-skyblue rounded-full"></div>
                        <h4 class="text-brandblue font-black uppercase text-xs tracking-widest">Our Vision</h4>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">To be the undisputed leader in innovative and sustainable travel solutions across the region.</p>
                    </div>
                    <div class="space-y-2">
                        <div class="h-1 w-12 bg-skyblue rounded-full"></div>
                        <h4 class="text-brandblue font-black uppercase text-xs tracking-widest">Our Mission</h4>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">Providing seamless, high-quality, and secure travel experiences for every client we serve.</p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop" class="rounded-[2.5rem] shadow-xl h-80 object-cover mt-12 hover:-translate-y-2 transition duration-500">
                    <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop" class="rounded-[2.5rem] shadow-xl h-80 object-cover hover:-translate-y-2 transition duration-500">
                </div>
                <div class="absolute -bottom-10 -left-10 bg-brandblue p-10 rounded-[2rem] shadow-2xl text-white hidden md:block">
                    <p class="text-5xl font-black text-skyblue mb-2 leading-none">25+</p>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em]">Golden Years of <br>Pure Excellence</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-xl">
                <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Why Nusajaya?</span>
                <h2 class="text-5xl font-black text-brandblue uppercase leading-none italic">The Pillars of <br>Our Service</h2>
            </div>
            <p class="text-slate-400 font-medium text-sm max-w-sm mb-2">We don't just sell tours; we curate moments that last a lifetime through our core values.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-12">
            <!-- Value Card -->
            <div class="group relative p-12 bg-lightbg rounded-[3rem] overflow-hidden hover:shadow-2xl transition duration-500">
                <div class="absolute top-0 right-0 w-32 h-32 bg-skyblue/5 rounded-bl-[4rem] group-hover:bg-skyblue/10 transition"></div>
                <div class="relative z-10 uppercase">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-brandblue mb-8 group-hover:scale-110 transition duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-brandblue mb-4 tracking-tight">Legal & Secure</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed italic">Fully licensed operations ensuring peace of mind for every transaction.</p>
                </div>
            </div>

            <div class="group relative p-12 bg-brandblue rounded-[3rem] overflow-hidden hover:shadow-2xl transition duration-500">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[4rem]"></div>
                <div class="relative z-10 uppercase">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur rounded-2xl shadow-sm flex items-center justify-center text-skyblue mb-8 group-hover:scale-110 transition duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white mb-4 tracking-tight">Rapid Support</h3>
                    <p class="text-sm text-slate-300 font-medium leading-relaxed italic">Our dedicated concierge team is ready to assist your needs 24 hours a day.</p>
                </div>
            </div>

            <div class="group relative p-12 bg-lightbg rounded-[3rem] overflow-hidden hover:shadow-2xl transition duration-500">
                <div class="absolute top-0 right-0 w-32 h-32 bg-skyblue/5 rounded-bl-[4rem] group-hover:bg-skyblue/10 transition"></div>
                <div class="relative z-10 uppercase">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-brandblue mb-8 group-hover:scale-110 transition duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-brandblue mb-4 tracking-tight">Best Pricing</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed italic">Premium experiences made accessible through our extensive partner network.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Glassmorphism Location Section -->
<section class="max-w-7xl mx-auto px-8 pb-32">
    <div class="relative rounded-[4rem] overflow-hidden min-h-[500px] flex items-center group">
        <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
        <div class="absolute inset-0 bg-brandblue/40 backdrop-blur-[2px]"></div>
        
        <div class="relative z-10 p-12 md:p-20 w-full">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-12 rounded-[3rem] shadow-2xl">
                    <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-8 block">Connect With Us</span>
                    <h3 class="text-3xl font-black text-white mb-10 leading-tight uppercase">Located in the Heart <br>of Batam City</h3>
                    
                    <div class="space-y-8">
                        <div class="flex gap-6">
                            <div class="w-12 h-12 bg-skyblue text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-skyblue/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <p class="text-sm text-white/90 font-medium leading-relaxed">
                                Kawasan Pantai Indah Mutiara, Blok B No 36-37, Tj. Buntung, Batam, RI, 29432 Indonesia
                            </p>
                        </div>
                        
                        <div class="flex gap-4 pt-4">
                            <a href="tel:+62778457168" class="flex-1 bg-white text-brandblue py-4 rounded-2xl font-black text-xs uppercase text-center hover:bg-skyblue hover:text-white transition shadow-xl">Call Head Office</a>
                            <a href="mailto:reservation@nusajaya168.com" class="flex-1 bg-skyblue text-white py-4 rounded-2xl font-black text-xs uppercase text-center hover:bg-white hover:text-brandblue transition shadow-xl">Send Inquiry</a>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <h4 class="text-2xl font-black text-white uppercase tracking-tighter italic mb-4">"Creating Memories, <br>One Journey at a Time."</h4>
                    <p class="text-slate-300 font-medium italic opacity-80">Experience the difference with Batam's most trusted travel partner since 1995.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
