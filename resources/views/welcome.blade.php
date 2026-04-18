@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<header class="relative min-h-[600px] flex items-center overflow-hidden">
    <!-- Background Slider -->
    <div id="hero-slider" class="absolute inset-0 z-0">
        <!-- Slide 1: Barelang Bridge Sunset -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-100" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.9), rgba(11, 36, 71, 0.3)), url('{{ asset('images/hero_1.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 2: Harbour Bay Batam with Marriott -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.9), rgba(11, 36, 71, 0.3)), url('{{ asset('images/hero_2.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 3: Welcome to Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.9), rgba(11, 36, 71, 0.3)), url('{{ asset('images/hero_3.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 4: Marriott Hotel Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.9), rgba(11, 36, 71, 0.3)), url('{{ asset('images/hero_4.png') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 5: Radisson Hotel Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.9), rgba(11, 36, 71, 0.3)), url('{{ asset('images/hero_5.jpg') }}'); background-size: cover; background-position: center;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-10 w-full mb-20">
        <div class="max-w-2xl">
            <!-- New Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-skyblue/20 backdrop-blur-md rounded-full border border-skyblue/30 mb-6 animate-fade-in-down">
                <span class="w-1.5 h-1.5 rounded-full bg-skyblue animate-pulse"></span>
                <span class="text-[10px] font-black text-skyblue uppercase tracking-[0.3em]">Established Since 1995</span>
            </div>

            <h1 class="text-6xl md:text-8xl font-black text-white leading-[0.9] mb-8 tracking-tighter italic animate-fade-up">
                Explore <span class="text-skyblue not-italic">Batam</span> 
                <span class="text-white/60 font-normal text-4xl md:text-5xl block mt-4 not-italic tracking-normal">
                    Discover <span id="typewriter" class="text-white font-black border-r-4 border-skyblue pr-2"></span>
                </span>
            </h1>
            <p class="text-lg text-white/70 font-medium leading-relaxed max-w-lg mb-10 animate-fade-up delay-200">
                Premium transport and curated tour experiences. Trusted for over 25 years in providing the best hospitality in the Riau Islands.
            </p>
            
            <div class="flex gap-4 animate-fade-up delay-300">
                <a href="{{ route('tours.index') }}" class="px-8 py-4 bg-skyblue hover:bg-white hover:text-brandblue text-brandblue font-black rounded-2xl transition-all duration-500 shadow-xl shadow-skyblue/20 group">
                    Start Your Trip
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating Search Box -->
    <div class="absolute bottom-10 right-10 md:right-32 z-20 w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6">
        <div class="flex gap-2 mb-6">
            <a href="{{ route('transport.index') }}" class="flex-1 py-1.5 text-xs font-bold text-white bg-brandblue rounded-full text-center block">Vehicles</a>
            <a href="{{ route('tours.index') }}" class="flex-1 py-1.5 text-xs font-bold text-slate-500 bg-slate-100 rounded-full hover:bg-slate-200 text-center block">Tour Packages</a>
        </div>
        
        <form action="{{ route('transport.index') }}" method="GET" class="space-y-4 mb-6">
            <div class="bg-lightbg rounded-lg p-3 relative group">
                <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-1">PICK UP</p>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brandblue animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="text" id="pickup_location" name="location" readonly 
                           value="Detecting location..." 
                           class="bg-transparent border-none text-sm text-slate-700 font-bold p-0 focus:ring-0 w-full cursor-not-allowed">
                </div>
                <div id="loc-status" class="absolute right-3 top-3">
                    <div class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></div>
                </div>
            </div>
            <div class="bg-lightbg rounded-lg p-3">
                <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-1">DATE</p>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                           class="bg-transparent border-none text-sm text-slate-700 font-bold p-0 focus:ring-0 w-full">
                </div>
            </div>
            
            <button type="submit" class="w-full py-3.5 bg-brandblue hover:bg-slate-800 text-white rounded-xl text-sm font-black uppercase tracking-widest flex items-center justify-center gap-3 transition-all duration-300 shadow-xl shadow-brandblue/20">
                Find Availability 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </button>
        </form>
    </div>

    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in-down {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 1s ease-out forwards; }
        .animate-fade-in-down { animation: fade-in-down 0.8s ease-out forwards; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.4s; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Typewriter Logic
            const words = ['Luxury Fleet', 'Island Paradise', 'Premium Tours', 'Batam Beauty'];
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            const typewriter = document.getElementById('typewriter');

            function type() {
                const currentWord = words[wordIndex];
                if (isDeleting) {
                    typewriter.textContent = currentWord.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    typewriter.textContent = currentWord.substring(0, charIndex + 1);
                    charIndex++;
                }

                let typeSpeed = isDeleting ? 100 : 200;

                if (!isDeleting && charIndex === currentWord.length) {
                    isDeleting = true;
                    typeSpeed = 2000; // Pause at end
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % words.length;
                    typeSpeed = 500;
                }

                setTimeout(type, typeSpeed);
            }
            type();

            // Slider Logic
            const slides = document.querySelectorAll('.slider-item');
            let currentSlide = 0;

            function nextSlide() {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }

            setInterval(nextSlide, 5000);

            // Geolocation Logic
            const pickupInput = document.getElementById('pickup_location');
            const locStatus = document.getElementById('loc-status');

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // Reverse geocoding using Nominatim (Free)
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.address.city || data.address.town || data.address.state || "Batam Area";
                            const suburb = data.address.suburb || data.address.village || "";
                            pickupInput.value = `${suburb}${suburb ? ', ' : ''}${address}`;
                            locStatus.innerHTML = '<div class="w-2 h-2 rounded-full bg-emerald-500"></div>';
                            pickupInput.classList.remove('cursor-not-allowed');
                            pickupInput.readOnly = false;
                        })
                        .catch(err => {
                            pickupInput.value = "Batam Centre Terminal";
                            locStatus.innerHTML = '<div class="w-2 h-2 rounded-full bg-slate-300"></div>';
                        });
                }, function(error) {
                    pickupInput.value = "Batam Centre Terminal";
                    locStatus.innerHTML = '<div class="w-2 h-2 rounded-full bg-red-400"></div>';
                });
            } else {
                pickupInput.value = "Batam Centre Terminal";
                locStatus.innerHTML = '';
            }
        });
    </script>
</header>

<!-- Premium Services Section -->
<section class="max-w-7xl mx-auto px-8 py-32 pb-48">
    <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
        <div class="max-w-xl">
            <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Our Expertise</span>
            <h2 class="text-5xl font-black text-brandblue uppercase italic leading-none mb-6">Premium Travel Solutions</h2>
            <p class="text-sm text-slate-500 font-medium leading-relaxed">
                We bring a new standard to travel comfort. From the most complete VIP bus fleet to personally designed tour packages for an unforgettable experience in Batam.
            </p>
        </div>
        <button class="w-16 h-16 rounded-[2rem] bg-brandblue text-white flex items-center justify-center hover:bg-skyblue hover:rotate-90 transition-all duration-700 shadow-2xl shadow-brandblue/20 group">
            <svg class="w-6 h-6 group-hover:scale-125 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </button>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Transport Booking -->
        <a href="{{ route('transport.index') }}" class="group relative bg-white rounded-[4rem] p-12 border border-slate-100 shadow-2xl shadow-brandblue/5 hover:-translate-y-4 transition-all duration-700 flex flex-col overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brandblue/5 rounded-bl-[4rem] -mr-10 -mt-10 group-hover:scale-150 group-hover:bg-brandblue transition-all duration-700"></div>
            
            <div class="w-16 h-16 bg-brandblue rounded-3xl flex items-center justify-center text-white mb-10 group-hover:rotate-12 transition-all shadow-xl shadow-brandblue/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            
            <h3 class="text-2xl font-black text-brandblue mb-4 uppercase italic transition group-hover:text-skyblue">Transport Booking</h3>
            <p class="text-sm text-slate-500 mb-10 leading-relaxed font-medium">Airport and seaport pickup services with our latest fleet that is clean, well-maintained, and executive class.</p>
            
            <div class="mt-auto flex items-center justify-between">
                <span class="text-[10px] font-black text-brandblue uppercase tracking-[0.3em] group-hover:tracking-[0.5em] transition-all">Book Transport</span>
                <div class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center group-hover:bg-skyblue group-hover:border-skyblue group-hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </div>
        </a>

        <!-- Tour Packages -->
        <a href="{{ route('tours.index') }}" class="group relative bg-brandblue rounded-[4rem] p-12 shadow-2xl shadow-brandblue/30 hover:-translate-y-4 transition-all duration-700 flex flex-col overflow-hidden text-white">
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            
            <div class="w-16 h-16 bg-skyblue rounded-3xl flex items-center justify-center text-white mb-10 group-hover:-rotate-12 transition-all shadow-xl shadow-skyblue/40">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
            </div>
            
            <h3 class="text-2xl font-black mb-4 uppercase italic">Tour Packages</h3>
            <p class="text-sm text-white/70 mb-10 leading-relaxed font-medium">Exploration of stunning destinations in Batam & Bintan with tour packages designed for limitless excitement.</p>
            
            <div class="mt-auto flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] group-hover:tracking-[0.5em] transition-all">Book Tour</span>
                <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white group-hover:text-brandblue transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </div>
        </a>

        <!-- Private Car (Soon) -->
        <div class="group relative bg-slate-50/50 rounded-[4rem] p-12 border border-dashed border-slate-200 flex flex-col opacity-80 overflow-hidden">
            <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-400 mb-10 grayscale">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            </div>
            
            <h3 class="text-2xl font-black text-slate-400 mb-4 uppercase italic">Private Car</h3>
            <p class="text-sm text-slate-400 mb-10 leading-relaxed font-medium">Daily car rental with personal drivers for business needs or highly private family holidays.</p>
            
            <div class="mt-auto">
                <span class="px-6 py-2 bg-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest rounded-full inline-block italic">Reserved for Soon</span>
            </div>
        </div>
    </div>
</section>

<!-- Bento Destinations Section Variation -->
<section class="max-w-7xl mx-auto px-8 pb-32">
    <div class="flex flex-col items-center text-center mb-16">
        <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4">Discover Batam</span>
        <h2 class="text-5xl font-black text-brandblue uppercase italic">Top Destinations</h2>
    </div>
    
    <div class="grid grid-cols-4 grid-rows-2 gap-6 h-[700px]">
        <!-- Batam City (Large Vertical) -->
        <a href="{{ route('tours.show', 'batam-city-highlights') }}" class="col-span-2 row-span-2 relative rounded-[3rem] overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-brandblue/20 opacity-0 group-hover:opacity-100 transition duration-500"></div>
            
            <div class="absolute bottom-10 left-10 right-10">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-4">Main Gate</span>
                <h3 class="text-4xl font-black text-white mb-4 uppercase leading-none">Batam City <br><span class="text-skyblue">Experience</span></h3>
                <p class="text-sm text-white/70 font-medium line-clamp-2 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-500">Discover the industrial heartbeat and shopping paradise of the Riau Islands.</p>
            </div>
        </a>
        
        <!-- Ranoh Island (Wide Top) -->
        <a href="{{ route('tours.show', 'ranoh-island') }}" class="col-span-2 row-span-1 relative rounded-[3rem] overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-r from-brandblue/80 via-transparent to-transparent"></div>
            <div class="absolute top-8 right-8">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path></svg>
                </div>
            </div>
            <div class="absolute inset-y-0 left-10 flex flex-col justify-center max-w-xs">
                <h3 class="text-3xl font-black text-white mb-2 uppercase italic">Ranoh Island</h3>
                <p class="text-xs text-white/80 font-medium tracking-tight">Tropical paradise with crystal clear water.</p>
            </div>
        </a>
        
        <!-- Maha Vihara (Standard Style) -->
        <a href="{{ route('tours.show', 'maha-vihara') }}" class="col-span-1 row-span-1 relative rounded-[3rem] overflow-hidden group">
            <img src="{{ asset('images/maha_vihara.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <p class="text-[9px] font-black text-skyblue uppercase tracking-widest mb-1 italic">Architecture</p>
                <h3 class="text-lg font-black text-white uppercase italic leading-none">Maha <br>Vihara</h3>
            </div>
        </a>
        
        <!-- Barelang Bridge (Square Small) -->
        <a href="{{ route('tours.show', 'barelang-bridge') }}" class="col-span-1 row-span-1 relative rounded-[3rem] overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <h3 class="text-lg font-black text-white uppercase italic leading-none">Barelang <br>Bridge</h3>
            </div>
        </a>
    </div>
</section>

<!-- Modern Promotions Section Variation -->
<section class="max-w-7xl mx-auto px-8 pb-32">
    <div class="text-center mb-16">
        <span class="text-red-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Seasonal Offers</span>
        <h2 class="text-4xl font-black text-brandblue uppercase italic">Travel More, Spend Less</h2>
    </div>

    <!-- Flash Sale Banner -->
    <div class="relative bg-brandblue rounded-[3rem] p-12 overflow-hidden mb-12 group">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-20 group-hover:scale-110 transition duration-1000">
            <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-brandblue via-brandblue/80 to-transparent"></div>
        
        <div class="relative z-10 max-w-xl">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-red-500 text-white text-[10px] font-black px-4 py-1 rounded-full animate-pulse">FLASH SALE</span>
                <span class="text-white/60 text-[10px] font-bold tracking-widest uppercase">Ends in 24 Hours</span>
            </div>
            <h3 class="text-5xl font-black text-white mb-6 uppercase leading-none tracking-tighter">Batam <br>Weekend <br><span class="text-skyblue">Gateaway</span></h3>
            <p class="text-slate-300 mb-8 font-medium leading-relaxed italic">Book any tour for this weekend and get a free pickup from Batam Center or Harbour Bay Ferry Terminal.</p>
            <a href="{{ route('tours.index') }}" class="bg-skyblue hover:bg-white hover:text-brandblue text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition shadow-2xl shadow-skyblue/30 inline-block">Book My Weekend</a>
        </div>
    </div>

    <!-- Feature Promo Grid -->
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-500 group-hover:text-white transition duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
            </div>
            <h4 class="text-lg font-black text-brandblue uppercase mb-2">Registration Bonus</h4>
            <p class="text-xs text-slate-400 font-medium mb-6">IDR 50k credit for new members.</p>
            <a href="{{ route('register') }}" class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">Register Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-skyblue/10 text-skyblue rounded-2xl flex items-center justify-center mb-6 group-hover:bg-skyblue group-hover:text-white transition duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </div>
            <h4 class="text-lg font-black text-brandblue uppercase mb-2">Transport Bundle</h4>
            <p class="text-xs text-slate-400 font-medium mb-6">10% Off when booking car + tour.</p>
            <a href="{{ route('transport.index') }}" class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">Explore Fleet <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 group-hover:text-white transition duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h4 class="text-lg font-black text-brandblue uppercase mb-2">Corporate Rates</h4>
            <p class="text-xs text-slate-400 font-medium mb-6">Custom pricing for group events.</p>
            <a href="{{ route('about') }}" class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">Learn More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></a>
        </div>
    </div>
</section>

<!-- Trusted Partner Section -->
<section class="max-w-7xl mx-auto px-8 py-20 relative">
    <div class="bg-white rounded-3xl p-12 grid md:grid-cols-2 gap-12 items-center shadow-lg border border-slate-100">
        <div class="relative">
            <img src="{{ asset('images/fleet.png') }}" class="rounded-2xl shadow-md w-full h-[300px] object-cover">
            <div class="absolute -top-6 -left-6 bg-white p-4 rounded-xl shadow-lg text-center">
                <p class="text-3xl font-black text-brandblue">15+</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Years of Service</p>
            </div>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-brandblue mb-6 leading-tight">PT Nusa Jaya Indofast T&T: Your Trusted Travel Partner</h2>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                Since our establishment, we have been committed to providing unforgettable travel experiences. As a one-stop travel service provider in the Riau Islands, we prioritize safety, comfort, and punctuality in every service we provide.
            </p>
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="flex gap-3">
                    <div class="text-brandblue"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <div>
                        <h4 class="text-xs font-bold text-brandblue mb-1">Legal & Licensed</h4>
                        <p class="text-[10px] text-slate-500">Fully official operations complying with government regulations.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="text-brandblue"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                    <div>
                        <h4 class="text-xs font-bold text-brandblue mb-1">24/7 Support</h4>
                        <p class="text-[10px] text-slate-500">Our dedicated team is ready to assist your needs anytime.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('about') }}" class="bg-brandblue hover:bg-slate-800 text-white px-6 py-3 rounded-lg text-xs font-bold transition flex items-center gap-2 inline-flex">
                Learn More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection
