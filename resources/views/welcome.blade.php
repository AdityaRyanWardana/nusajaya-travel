@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<header class="relative min-h-[700px] md:min-h-[600px] flex flex-col md:flex-row items-center justify-center pt-32 pb-16 md:pt-0 md:pb-0 overflow-hidden">
    <!-- Background Slider -->
    <div id="hero-slider" class="absolute inset-0 z-0">
        <!-- Slide 1: Barelang Bridge Sunset -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-100" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.7), rgba(11, 36, 71, 0.2)), url('{{ asset('images/hero_1.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 2: Harbour Bay Batam with Marriott -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.7), rgba(11, 36, 71, 0.2)), url('{{ asset('images/hero_2.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 3: Welcome to Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.7), rgba(11, 36, 71, 0.2)), url('{{ asset('images/hero_3.jpg') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 4: Marriott Hotel Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.7), rgba(11, 36, 71, 0.2)), url('{{ asset('images/hero_4.png') }}'); background-size: cover; background-position: center;"></div>
        <!-- Slide 5: Radisson Hotel Batam -->
        <div class="slider-item absolute inset-0 transition-opacity duration-1000 opacity-0" style="background: linear-gradient(to right, rgba(11, 36, 71, 0.7), rgba(11, 36, 71, 0.2)), url('{{ asset('images/hero_5.jpg') }}'); background-size: cover; background-position: center;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-10 w-full mb-8 md:mb-20">
        <div class="max-w-2xl">
            <!-- New Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-skyblue/20 backdrop-blur-md rounded-full border border-skyblue/30 mb-6 animate-fade-in-down">
                <span class="w-1.5 h-1.5 rounded-full bg-skyblue animate-pulse"></span>
                <span class="text-[10px] font-black text-skyblue uppercase tracking-[0.3em]">Established Since 1995</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-white leading-[0.9] mb-8 tracking-tighter italic animate-fade-up">
                Explore <span class="text-skyblue not-italic">Batam</span> 
                <span class="text-white/60 font-normal text-3xl md:text-5xl block mt-4 not-italic tracking-normal">
                    Discover <span id="typewriter" class="text-white font-black border-r-4 border-skyblue pr-2"></span>
                </span>
            </h1>
            <p class="text-base md:text-lg text-white/70 font-medium leading-relaxed max-w-lg mb-10 animate-fade-up delay-200">
                Premium transport and curated tour experiences. Trusted for over 25 years in providing the best hospitality in the Riau Islands.
            </p>
            
            <div class="flex gap-4 animate-fade-up delay-300">
                <a href="{{ route('tours.index') }}" class="px-6 md:px-8 py-3 md:py-4 bg-skyblue hover:bg-white hover:text-brandblue text-brandblue font-black rounded-2xl transition-all duration-500 shadow-xl shadow-skyblue/20 group text-sm md:text-base">
                    Start Your Trip
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating Search Box -->
    <div class="relative md:absolute md:bottom-10 md:right-32 z-20 w-[90%] md:w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 mt-4 md:mt-0">
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
<section class="max-w-7xl mx-auto px-8 py-32 pb-48 reveal">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
        <div class="max-w-2xl">
            <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Our Expertise</span>
            <h2 class="text-4xl md:text-5xl font-black text-brandblue uppercase italic leading-none mb-6">Premium Travel Solutions</h2>
            <p class="text-base text-slate-500 font-medium leading-relaxed max-w-lg">
                We bring a new standard to travel comfort. Choose our premium fleet, personalized tours, or highly private car rentals.
            </p>
        </div>
        <a href="{{ route('transport.index') }}" class="hidden md:flex items-center gap-4 bg-brandblue/5 hover:bg-brandblue text-brandblue hover:text-white px-8 py-4 rounded-full transition-all duration-500 group">
            <span class="text-xs font-black uppercase tracking-widest">Explore All</span>
            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    <!-- Expanding Flex Cards -->
    <div class="flex flex-col lg:flex-row h-[700px] lg:h-[550px] gap-4 lg:gap-6 w-full group/accordion">
        <!-- Transport Booking -->
        <a href="{{ route('transport.index') }}" class="group relative flex-1 hover:flex-[3] transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)] overflow-hidden rounded-[2.5rem] flex flex-col justify-end p-8 reveal-left shadow-2xl shadow-brandblue/10">
            <img src="{{ asset('images/hero_1.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-brandblue/40 to-black/30 group-hover:from-brandblue/90 group-hover:via-brandblue/10 transition-all duration-700"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-end">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-6 border border-white/20 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                
                <h3 class="text-3xl lg:text-4xl font-black text-white uppercase italic mb-2 shrink-0 drop-shadow-md">Transport</h3>
                
                <div class="overflow-hidden max-h-0 opacity-0 group-hover:max-h-64 group-hover:opacity-100 group-hover:mt-4 transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)]">
                    <p class="text-sm text-white/90 font-medium leading-relaxed mb-6 pr-4 lg:pr-12">
                        Airport and seaport pickup services with our latest fleet that is clean, well-maintained, and executive class.
                    </p>
                    <div class="inline-flex items-center gap-3 text-[10px] font-black text-brandblue uppercase tracking-[0.3em] bg-white hover:bg-skyblue hover:text-white px-6 py-3.5 rounded-full transition-all duration-300 shadow-xl">
                        Book Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Tour Packages -->
        <a href="{{ route('tours.index') }}" class="group relative flex-1 hover:flex-[3] transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)] overflow-hidden rounded-[2.5rem] flex flex-col justify-end p-8 reveal shadow-2xl shadow-skyblue/10">
            <img src="{{ asset('images/ranoh_island.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2447]/90 via-[#0B2447]/40 to-black/30 group-hover:from-[#0B2447]/90 group-hover:via-[#0B2447]/10 transition-all duration-700"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-end">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-6 border border-white/20 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                </div>
                
                <h3 class="text-3xl lg:text-4xl font-black text-white uppercase italic mb-2 shrink-0 drop-shadow-md">Tour Packages</h3>
                
                <div class="overflow-hidden max-h-0 opacity-0 group-hover:max-h-64 group-hover:opacity-100 group-hover:mt-4 transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)]">
                    <p class="text-sm text-white/90 font-medium leading-relaxed mb-6 pr-4 lg:pr-12">
                        Exploration of stunning destinations in Batam & Bintan with tour packages designed for limitless excitement.
                    </p>
                    <div class="inline-flex items-center gap-3 text-[10px] font-black text-brandblue uppercase tracking-[0.3em] bg-white hover:bg-skyblue hover:text-white px-6 py-3.5 rounded-full transition-all duration-300 shadow-xl">
                        Book Tour <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Private Car -->
        <div class="group relative flex-1 hover:flex-[3] transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)] overflow-hidden rounded-[2.5rem] flex flex-col justify-end p-8 reveal-right shadow-2xl shadow-slate-900/10">
            <img src="{{ asset('images/hero_5.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110 grayscale group-hover:grayscale-0">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-black/30 group-hover:from-slate-900/90 group-hover:via-slate-900/20 transition-all duration-700"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-end">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-6 border border-white/20 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                
                <h3 class="text-3xl lg:text-4xl font-black text-white uppercase italic mb-2 shrink-0 drop-shadow-md">Private Car</h3>
                
                <div class="overflow-hidden max-h-0 opacity-0 group-hover:max-h-64 group-hover:opacity-100 group-hover:mt-4 transition-all duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)]">
                    <p class="text-sm text-white/90 font-medium leading-relaxed mb-6 pr-4 lg:pr-12">
                        Daily car rental with personal drivers for business needs or highly private family holidays.
                    </p>
                    <div class="inline-flex items-center gap-3 text-[10px] font-black text-slate-500 uppercase tracking-widest bg-white/80 backdrop-blur px-6 py-3.5 rounded-full cursor-not-allowed">
                        Reserved for Soon
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bento Destinations Section Variation -->
<section class="max-w-7xl mx-auto px-8 pb-32 reveal">
    <div class="flex flex-col items-center text-center mb-16">
        <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4">Discover Batam</span>
        <h2 class="text-4xl md:text-5xl font-black text-brandblue uppercase italic">Top Destinations</h2>
    </div>
    
    <div class="grid grid-cols-4 grid-rows-2 gap-6 h-[700px]">
        <!-- Batam City (Large Vertical) -->
        @php $batamCity = $top_destinations['batam-city-highlights'] ?? null; @endphp
        <a href="{{ route('tours.show', 'batam-city-highlights') }}" class="col-span-2 row-span-2 relative rounded-[3rem] overflow-hidden group reveal-zoom">
            <img src="{{ asset('images/batam_city.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/70 via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-brandblue/20 opacity-0 group-hover:opacity-100 transition duration-500"></div>
            
            <div class="absolute bottom-10 left-10 right-10">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-4">Main Gate</span>
                <h3 class="text-3xl md:text-4xl font-black text-white mb-4 uppercase leading-none">Batam City <br><span class="text-skyblue">Experience</span></h3>
                <p class="text-sm text-white/70 font-medium line-clamp-2 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-500">
                    {{ $batamCity ? $batamCity->description : 'Discover the industrial heartbeat and shopping paradise of the Riau Islands.' }}
                </p>
            </div>
        </a>
        
        <!-- Ranoh Island (Wide Top) -->
        @php $ranoh = $top_destinations['ranoh-island'] ?? null; @endphp
        <a href="{{ route('tours.show', 'ranoh-island') }}" class="col-span-2 row-span-1 relative rounded-[3rem] overflow-hidden group reveal-zoom">
            <img src="{{ asset('images/ranoh_island.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-r from-brandblue/80 via-transparent to-transparent"></div>
            <div class="absolute top-8 right-8">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path></svg>
                </div>
            </div>
            <div class="absolute inset-y-0 left-10 flex flex-col justify-center max-w-xs">
                <h3 class="text-2xl md:text-3xl font-black text-white mb-2 uppercase italic">Ranoh Island</h3>
                <p class="text-sm text-white/80 font-medium tracking-tight line-clamp-2 group-hover:line-clamp-none transition-all">
                    {{ $ranoh ? $ranoh->description : 'Tropical paradise with crystal clear water.' }}
                </p>
            </div>
        </a>
        
        <!-- Maha Vihara (Standard Style) -->
        @php $mahaVihara = $top_destinations['maha-vihara'] ?? null; @endphp
        <a href="{{ route('tours.show', 'maha-vihara') }}" class="col-span-1 row-span-1 relative rounded-[3rem] overflow-hidden group">
            <img src="{{ asset('images/maha_vihara.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/70 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <p class="text-[9px] font-black text-skyblue uppercase tracking-widest mb-1 italic">Architecture</p>
                <h3 class="text-lg md:text-xl font-black text-white uppercase italic leading-none mb-2">Maha <br>Vihara</h3>
                <p class="text-[10px] text-white/60 font-medium line-clamp-2 opacity-0 group-hover:opacity-100 transition duration-500">
                    {{ $mahaVihara ? $mahaVihara->description : 'Visit one of the largest Buddhist temples in Southeast Asia.' }}
                </p>
            </div>
        </a>
        
        <!-- Barelang Bridge (Square Small) -->
        @php $barelang = $top_destinations['barelang-bridge'] ?? null; @endphp
        <a href="{{ route('tours.show', 'barelang-bridge') }}" class="col-span-1 row-span-1 relative rounded-[3rem] overflow-hidden group">
            <img src="{{ asset('images/barelang_bridge.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/70 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <h3 class="text-lg md:text-xl font-black text-white uppercase italic leading-none mb-2">Barelang <br>Bridge</h3>
                <p class="text-[10px] text-white/60 font-medium line-clamp-2 opacity-0 group-hover:opacity-100 transition duration-500">
                    {{ $barelang ? $barelang->description : 'The iconic landmark connecting the islands of Batam.' }}
                </p>
            </div>
        </a>
    </div>
</section>

<!-- Modern Promotions Section Variation -->
<section class="max-w-7xl mx-auto px-8 pb-32 reveal">
    <div class="text-center mb-16">
        <span class="text-red-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Seasonal Offers</span>
        <h2 class="text-4xl md:text-5xl font-black text-brandblue uppercase italic">Travel More, Spend Less</h2>
    </div>

    <!-- Flash Sale Banner / Main Promotion -->
    @if($main_promotion)
    <a href="{{ $main_promotion->tour_id ? route('tours.show', $main_promotion->tour->slug) : ($main_promotion->link ?? route('tours.index')) }}" class="relative bg-brandblue rounded-[3rem] p-12 overflow-hidden mb-12 group block">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-50 group-hover:scale-110 transition duration-1000">
            @if($main_promotion->image)
                <img src="{{ asset('storage/' . $main_promotion->image) }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover">
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-brandblue via-brandblue/40 to-transparent"></div>
        
        <div class="relative z-10 max-w-xl text-left">
            <div class="flex items-center gap-3 mb-6">
                @if($main_promotion->badge)
                    <span class="bg-red-500 text-white text-[10px] font-black px-4 py-1 rounded-full animate-pulse">{{ $main_promotion->badge }}</span>
                @endif
                @if($main_promotion->expires_at)
                    <span class="text-white/60 text-[10px] font-bold tracking-widest uppercase">Ends {{ $main_promotion->expires_at->diffForHumans() }}</span>
                @endif
            </div>
            <h3 class="text-4xl md:text-5xl font-black text-white mb-4 uppercase leading-none tracking-tighter">
                {!! str_replace(['<br>', ' '], ['<br>', ' <br>'], $main_promotion->title) !!}
            </h3>
            <p class="text-base text-slate-300 mb-6 font-medium leading-relaxed italic">{{ $main_promotion->description }}</p>
            <div class="bg-skyblue group-hover:bg-white group-hover:text-brandblue text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition shadow-2xl shadow-skyblue/30 inline-block">
                {{ $main_promotion->link_text ?? 'Learn More' }}
            </div>
        </div>
    </a>
    @else
    <a href="{{ route('tours.index') }}" class="relative bg-brandblue rounded-[3rem] p-12 overflow-hidden mb-12 group block">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-50 group-hover:scale-110 transition duration-1000">
            <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-brandblue via-brandblue/40 to-transparent"></div>
        
        <div class="relative z-10 max-w-xl text-left">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-red-500 text-white text-[10px] font-black px-4 py-1 rounded-full animate-pulse">FLASH SALE</span>
                <span class="text-white/60 text-[10px] font-bold tracking-widest uppercase">Ends in 24 Hours</span>
            </div>
            <h3 class="text-4xl md:text-5xl font-black text-white mb-4 uppercase leading-none tracking-tighter">Batam <br>Weekend <br><span class="text-skyblue">Gateaway</span></h3>
            <p class="text-base text-slate-300 mb-6 font-medium leading-relaxed italic">Book any tour for this weekend and get a free pickup from Batam Center or Harbour Bay Ferry Terminal.</p>
            <div class="bg-skyblue group-hover:bg-white group-hover:text-brandblue text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition shadow-2xl shadow-skyblue/30 inline-block">Book My Weekend</div>
        </div>
    </a>
    @endif

    <!-- Feature Promo Grid -->
    <div class="grid md:grid-cols-3 gap-8">
        @if(isset($grid_promotions) && $grid_promotions->count() > 0)
            @foreach($grid_promotions as $promo)
                <a href="{{ $promo->tour_id ? route('tours.show', $promo->tour->slug) : ($promo->link ?? '#') }}" class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition duration-500 
                        {{ $promo->type == 'tour' ? 'bg-blue-50 text-blue-500 group-hover:bg-blue-500' : ($promo->type == 'transport' ? 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500' : 'bg-red-50 text-red-500 group-hover:bg-red-500') }} group-hover:text-white">
                        @if($promo->type == 'tour')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                        @elseif($promo->type == 'transport')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        @endif
                    </div>
                    <h4 class="text-lg font-black text-brandblue uppercase mb-2">{{ $promo->title }}</h4>
                    <p class="text-xs text-slate-400 font-medium mb-6 flex-grow">{{ $promo->description }}</p>
                    <div class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all mt-auto">
                        {{ $promo->link_text ?? 'Learn More' }} 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            @endforeach
        @else
            <!-- Default Promos -->
            <a href="{{ route('tours.index') }}" class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500 block">
                <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 group-hover:text-white transition duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-lg font-black text-brandblue uppercase mb-2">Flash Sale</h4>
                <p class="text-xs text-slate-400 font-medium mb-6">Get 20% discount on all one-day tours this month.</p>
                <div class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">View Deals <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></div>
            </a>

            <a href="{{ route('transport.index') }}" class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500 block">
                <div class="w-14 h-14 bg-skyblue/10 text-skyblue rounded-2xl flex items-center justify-center mb-6 group-hover:bg-skyblue group-hover:text-white transition duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <h4 class="text-lg font-black text-brandblue uppercase mb-2">Transport Bundle</h4>
                <p class="text-xs text-slate-400 font-medium mb-6">10% Off when booking car + tour.</p>
                <div class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">Explore Fleet <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></div>
            </a>

            <a href="{{ route('about') }}" class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl group hover:-translate-y-2 transition duration-500 block">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 group-hover:text-white transition duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h4 class="text-lg font-black text-brandblue uppercase mb-2">Corporate Rates</h4>
                <p class="text-xs text-slate-400 font-medium mb-6">Custom pricing for group events.</p>
                <div class="text-[10px] font-black text-skyblue uppercase tracking-widest flex items-center gap-2 hover:gap-4 transition-all">Learn More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></div>
            </a>
        @endif
    </div>
</section>

<!-- Trusted Partner Section -->
<section class="max-w-7xl mx-auto px-8 py-20 relative reveal">
    <div class="bg-white rounded-3xl p-12 grid md:grid-cols-2 gap-12 items-center shadow-lg border border-slate-100">
        <div class="relative">
            <img src="{{ asset('images/fleet.png') }}" class="rounded-2xl shadow-md w-full h-[300px] object-cover">
            <div class="absolute -top-6 -left-6 bg-white p-4 rounded-xl shadow-lg text-center">
                <p class="text-3xl font-black text-brandblue">15+</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Years</p>
            </div>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-brandblue mb-4 leading-tight">PT Nusa Jaya Indofast T&T: Your Trusted Travel Partner</h2>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
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
