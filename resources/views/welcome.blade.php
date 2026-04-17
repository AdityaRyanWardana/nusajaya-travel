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
<section class="max-w-7xl mx-auto px-8 py-20">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-bold text-brandblue mb-4">Our Premium Services</h2>
            <p class="text-sm text-slate-500 max-w-md leading-relaxed">
                We provide a wide selection of transportation and tour packages specifically designed for your comfort on every journey.
            </p>
        </div>
        <button class="w-10 h-10 rounded-full bg-brandblue text-white flex items-center justify-center hover:bg-slate-800 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Transport Booking -->
        <a href="{{ route('transport.index') }}" class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
            <div class="w-12 h-12 bg-brandblue rounded-xl flex items-center justify-center text-white mb-6 group-hover:bg-skyblue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-brandblue mb-3 group-hover:text-skyblue transition-colors">Transport Booking</h3>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed flex-grow">Airport and seaport pickup service with the latest fleet that is clean and comfortable.</p>
            <span class="text-xs font-bold text-brandblue flex items-center gap-1">View Transport Booking <svg class="w-3 u-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
        </a>

        <!-- Tour Packages -->
        <a href="{{ route('tours.index') }}" class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
            <div class="w-12 h-12 bg-brandblue rounded-xl flex items-center justify-center text-white mb-6 group-hover:bg-skyblue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-brandblue mb-3 group-hover:text-skyblue transition-colors">Tour Packages</h3>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed flex-grow">Exploration of exciting destinations in Batam & Bintan with integrated tour packages that are economical and fun.</p>
            <span class="text-xs font-bold text-brandblue flex items-center gap-1">View Tour Packages <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
        </a>

        <!-- Private Car -->
        <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm flex flex-col opacity-80 cursor-default">
            <div class="w-12 h-12 bg-slate-200 rounded-xl flex items-center justify-center text-slate-400 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-400 mb-3">Private Car</h3>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed flex-grow">Daily car rental with professional drivers for your business needs or family holidays.</p>
            <span class="text-xs font-bold text-slate-400 flex items-center gap-1 italic">Coming Soon</span>
        </div>
    </div>
</section>

<!-- Top Destinations Section -->
<section class="max-w-7xl mx-auto px-8 pb-20">
    <h2 class="text-2xl font-bold text-brandblue mb-8 text-center">Top Destinations</h2>
    
    <div class="grid grid-cols-3 gap-6 h-[500px]">
        <!-- Batam (Large) -->
        <a href="{{ route('tours.show', 'batam-city-highlights') }}" class="col-span-1 row-span-2 relative rounded-2xl overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-brandblue/20 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <span class="bg-skyblue/80 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">Gate to Riau Islands</span>
                <h3 class="text-2xl font-bold text-white mb-2">Batam City</h3>
                <p class="text-xs text-slate-200 line-clamp-2">Center for industry, shopping, and the main international tourism gateway to the Riau Islands.</p>
            </div>
        </a>
        
        <!-- Bintan (Wide) - Link to a generic tour or Bintan package if exists -->
        <a href="{{ route('tours.show', 'ranoh-island') }}" class="col-span-2 row-span-1 relative rounded-2xl overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <h3 class="text-2xl font-bold text-white mb-2">Bintan Island</h3>
                <p class="text-xs text-slate-200 line-clamp-1">World-class resorts and exotic white sand beaches.</p>
            </div>
        </a>
        
        <!-- Bali (Small) -->
        <a href="{{ route('tours.show', 'maha-vihara') }}" class="col-span-1 row-span-1 relative rounded-2xl overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=2071&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent"></div>
            <div class="absolute bottom-4 left-4 right-4">
                <h3 class="text-lg font-bold text-white">Maha Vihara</h3>
            </div>
        </a>
        
        <!-- Jakarta -> Change to Barelang for more Batam focus (Small) -->
        <a href="{{ route('tours.show', 'barelang-bridge') }}" class="col-span-1 row-span-1 relative rounded-2xl overflow-hidden group">
            <img src="{{ asset('images/barelang.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent"></div>
            <div class="absolute bottom-4 left-4 right-4">
                <h3 class="text-lg font-bold text-white">Barelang</h3>
            </div>
        </a>
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
