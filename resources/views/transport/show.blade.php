@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-16 pb-24">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('transport.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 hover:text-brandblue transition group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            {{ __('Back to Fleet') }}
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
                                 <img src="{{ $transport->image ? (Str::startsWith($transport->image, 'http') ? $transport->image : asset('storage/' . $transport->image)) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2070&auto=format&fit=crop' }}" class="w-full h-full object-cover">
                                 <div class="absolute inset-0 bg-gradient-to-t from-brandblue via-transparent to-transparent opacity-90"></div>
                             </div>
                             
                             <!-- Gallery Images -->
                             @if($transport->images)
                                 @foreach($transport->images as $img)
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
                            {{ __($transport->type) }}
                        </span>
                        <h1 class="text-5xl font-black text-white uppercase italic leading-[0.9] tracking-tighter">{{ __($transport->name) }}</h1>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-brandblue uppercase italic mb-6">{{ __('Fleet Specification') }}</h2>
                    <p class="text-slate-500 font-medium leading-relaxed mb-10">{{ __($transport->description) }}</p>
                    
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8">{{ __('Premium Features') }}</h3>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">{{ __('Full AC Climate Control') }}</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">{{ __('Multimedia Entertainment') }}</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">{{ __('Reclining VIP Seats') }}</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">{{ __('USB Charging Ports') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Premium Booking Sidebar -->
            <div class="lg:col-span-1" x-data="{ 
                category: 'Batam City Tour', 
                duration: 'one_day',
                pickup: '',
                loadingLocation: false,
                detectLocation() {
                    this.loadingLocation = true;
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const lat = position.coords.latitude;
                                const lon = position.coords.longitude;
                                this.pickup = `Detecting... (${lat.toFixed(4)}, ${lon.toFixed(4)})`;
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        this.pickup = data.display_name;
                                        this.loadingLocation = false;
                                    })
                                    .catch(() => {
                                        this.pickup = `${lat}, ${lon}`;
                                        this.loadingLocation = false;
                                    });
                            },
                            () => {
                                alert('Geolocation failed. Please enter manually.');
                                this.loadingLocation = false;
                            }
                        );
                    } else {
                        alert('Geolocation not supported.');
                        this.loadingLocation = false;
                    }
                },
                prices: {
                    city_one_way: {{ $transport->price_city_one_way ?? 0 }},
                    city_half_day: {{ $transport->price_city_half_day ?? 0 }},
                    city_one_day: {{ $transport->price_city_one_day ?? 0 }},
                    city_full_day: {{ $transport->price_city_full_day ?? 0 }},
                    barelang: {{ $transport->price_barelang ?? 0 }}
                },
                get currentPrice() {
                    if (this.category === 'PP Barelang') return this.prices.barelang;
                    if (this.category === 'Transfer Only') return this.prices.city_one_way;
                    return this.prices['city_' + this.duration];
                },
                destination: '',
                get computedDestination() {
                    if (this.category === 'PP Barelang') return this.barelangDest;
                    if (this.category === 'Transfer Only') return this.transferDest;
                    return '';
                },
                barelangDest: '',
                transferDest: '',
            }">
                <div class="bg-brandblue rounded-[3rem] p-10 text-white shadow-2xl sticky top-32">
                    <div class="mb-10 p-8 bg-white/5 rounded-3xl border border-white/10 group hover:border-skyblue/30 transition-all text-center">
                        <p class="text-[10px] font-black text-skyblue uppercase tracking-[0.4em] mb-4" 
                           x-text="category === 'Batam City Tour' ? '{{ __('Batam City Tour Rate') }}' : (category === 'PP Barelang' ? '{{ __('PP Barelang — Flat Rate') }}' : '{{ __('Transfer Rate') }}')"></p>
                        <div class="flex items-baseline justify-center gap-2">
                            <span class="text-sm font-bold opacity-60">IDR</span>
                            <span class="text-4xl font-black italic tracking-tighter" x-text="new Intl.NumberFormat('id-ID').format(currentPrice)"></span>
                        </div>
                    </div>

                    <form action="{{ route('transport.book', $transport->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Rental Category') }}</label>
                            <select name="category" x-model="category" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none appearance-none cursor-pointer">
                                <option value="Batam City Tour" class="text-brandblue">Batam City Tour</option>
                                <option value="PP Barelang" class="text-brandblue">PP Barelang (Bridge 1-6)</option>
                                <option value="Transfer Only" class="text-brandblue">Transfer (One Way)</option>
                            </select>
                        </div>

                        <!-- Duration Selector (Only for City Tour) -->
                        <div class="space-y-2" x-show="category === 'Batam City Tour'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Select Duration') }}</label>
                            <select name="duration" x-model="duration" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none appearance-none cursor-pointer">
                                <option value="half_day" class="text-brandblue">{{ __('Half Day (4 Hours)') }}</option>
                                <option value="one_day" class="text-brandblue">{{ __('One Day (8 Hours)') }}</option>
                                <option value="full_day" class="text-brandblue">{{ __('Full Day (12 Hours)') }}</option>
                            </select>
                        </div>

                        <div class="space-y-2" x-data="{ locType: 'preset' }">
                            <div class="flex justify-between items-center mb-1">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Pickup Point') }}</label>
                                <div class="flex gap-4">
                                    <button type="button" @click="locType = 'preset'" :class="locType === 'preset' ? 'text-skyblue' : 'text-white/40'" class="text-[8px] font-black uppercase tracking-widest transition">Preset</button>
                                    <button type="button" @click="locType = 'manual'" :class="locType === 'manual' ? 'text-skyblue' : 'text-white/40'" class="text-[8px] font-black uppercase tracking-widest transition">Manual</button>
                                    <button type="button" @click="detectLocation(); locType = 'manual'" class="text-[8px] font-black text-white hover:text-skyblue transition flex items-center gap-1 uppercase tracking-widest">
                                        <svg x-show="!loadingLocation" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <svg x-show="loadingLocation" class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        {{ __('Detect') }}
                                    </button>
                                </div>
                            </div>
                                                       <!-- Pickup Selection -->
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open" x-show="locType === 'preset'" 
                                    class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold text-left focus:ring-2 focus:ring-skyblue transition outline-none flex items-center justify-between group">
                                    <span :class="pickup ? 'text-white' : 'text-white/40'" x-text="pickup || '-- {{ __('Select Location') }} --'"></span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-white/20 group-hover:text-skyblue transition-colors"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute z-50 mt-2 w-full bg-brandblue/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                                    
                                    <div class="p-2 space-y-1">
                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest">Seaports</div>
                                        <button type="button" @click="pickup = 'Batam Centre Ferry Terminal'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Batam Centre Ferry Terminal</button>
                                        <button type="button" @click="pickup = 'Harbour Bay Ferry Terminal'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Harbour Bay Ferry Terminal</button>
                                        <button type="button" @click="pickup = 'Sekupang Ferry Terminal'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Sekupang Ferry Terminal</button>
                                        
                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Airports</div>
                                        <button type="button" @click="pickup = 'Hang Nadim International Airport'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Hang Nadim International Airport</button>
                                        
                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Hotels</div>
                                        <button type="button" @click="pickup = 'Nagoya Hill Hotel'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Nagoya Hill Hotel</button>
                                        <button type="button" @click="pickup = 'Radisson Golf & Convention'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Radisson Golf & Convention</button>
                                        <button type="button" @click="pickup = 'Swiss-Belhotel Harbour Bay'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Swiss-Belhotel Harbour Bay</button>
                                    </div>
                                </div>
                            </div>

                            <input x-show="locType === 'manual'" type="text" x-model="pickup" placeholder="{{ __('Enter full address...') }}" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none placeholder:text-white/20">
                            <!-- Hidden input to ensure pickup is sent -->
                            <input type="hidden" name="pickup_point" :value="pickup">
                        </div>

                        <!-- Barelang Destination Selector (only for PP Barelang) -->
                        <div class="space-y-2" x-show="category === 'PP Barelang'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Barelang Destination') }}</label>
                            
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open" 
                                    class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold text-left focus:ring-2 focus:ring-skyblue transition outline-none flex items-center justify-between group">
                                    <span :class="barelangDest ? 'text-white' : 'text-white/40'" x-text="barelangDest || '-- {{ __('Select Destination') }} --'"></span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-white/20 group-hover:text-skyblue transition-colors"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute z-50 mt-2 w-full bg-brandblue/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden max-h-64 overflow-y-auto custom-scrollbar">
                                    
                                    <div class="p-2 space-y-1">
                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest">Jembatan 1 — Barelang</div>
                                        <button type="button" @click="barelangDest = 'Pantai Melayu (Jembatan 1 – Barelang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Melayu</button>
                                        <button type="button" @click="barelangDest = 'Pantai Nongsa (Jembatan 1 – Barelang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Nongsa</button>
                                        
                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Jembatan 2 — Rempang</div>
                                        <button type="button" @click="barelangDest = 'Pantai Glory Melur (Jembatan 2 – Rempang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Glory Melur</button>
                                        <button type="button" @click="barelangDest = 'Pantai Mirota (Jembatan 2 – Rempang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Mirota</button>

                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Jembatan 3 — Galang</div>
                                        <button type="button" @click="barelangDest = 'Pantai Viovio (Jembatan 3 – Galang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Viovio</button>
                                        <button type="button" @click="barelangDest = 'Pantai Campa (Jembatan 3 – Galang)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Campa</button>

                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Jembatan 4 — Galang Baru</div>
                                        <button type="button" @click="barelangDest = 'Pantai Pulau Abang (Jembatan 4 – Galang Baru)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Pulau Abang</button>
                                        <button type="button" @click="barelangDest = 'Pantai Sijantung (Jembatan 4 – Galang Baru)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Sijantung</button>

                                        <div class="px-4 py-2 text-[8px] font-black text-skyblue uppercase tracking-widest mt-2 border-t border-white/5 pt-4">Jembatan 5 - 6</div>
                                        <button type="button" @click="barelangDest = 'Pantai Sembulang (Jembatan 5 – Galang Baru)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Pantai Sembulang</button>
                                        <button type="button" @click="barelangDest = 'Tanjung Piayu (Jembatan 6 – Galang Baru)'; open = false" class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 text-xs font-bold transition-all">Tanjung Piayu</button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[9px] text-white/40 italic leading-relaxed">{{ __('PP Barelang rate is a') }} <span class="font-black text-skyblue">{{ __('flat rate') }}</span> {{ __('for all destinations above.') }}</p>
                        </div>

                        <!-- Transfer Destination (only for Transfer Only) -->
                        <div class="space-y-2" x-show="category === 'Transfer Only'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Drop Off Point') }}</label>
                            <input type="text" x-model="transferDest" placeholder="{{ __('Example: Hang Nadim Airport') }}" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none placeholder:text-white/20">
                        </div>

                        <!-- Single hidden input sends the correct destination value -->
                        <input type="hidden" name="destination" :value="computedDestination">

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">{{ __('Pickup Time') }}</label>
                            <div class="grid gap-3" :class="category === 'Transfer Only' ? 'grid-cols-3' : 'grid-cols-2'">
                                <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border border-white/20 bg-white/5 cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="radio" name="pickup_time" value="Morning (08:00 - 11:00)" required class="absolute opacity-0">
                                    <div class="w-2 h-2 rounded-full border border-white/40 mb-2 group-has-[:checked]:bg-skyblue group-has-[:checked]:border-skyblue transition-all"></div>
                                    <span class="text-[9px] font-black uppercase text-white/60 group-hover:text-white transition-colors">{{ __('Morning') }}</span>
                                    <span class="text-[8px] font-bold text-white/30 uppercase mt-1">08:00-11:00</span>
                                </label>
                                <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border border-white/20 bg-white/5 cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="radio" name="pickup_time" value="Afternoon (12:00 - 15:00)" class="absolute opacity-0">
                                    <div class="w-2 h-2 rounded-full border border-white/40 mb-2 group-has-[:checked]:bg-skyblue group-has-[:checked]:border-skyblue transition-all"></div>
                                    <span class="text-[9px] font-black uppercase text-white/60 group-hover:text-white transition-colors">{{ __('Afternoon') }}</span>
                                    <span class="text-[8px] font-bold text-white/30 uppercase mt-1">12:00-15:00</span>
                                </label>
                                <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border border-white/20 bg-white/5 cursor-pointer hover:bg-white/10 transition-all group"
                                    x-show="category === 'Transfer Only'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90">
                                    <input type="radio" name="pickup_time" value="Evening (17:00 - 20:00)" :required="category === 'Transfer Only'" class="absolute opacity-0">
                                    <div class="w-2 h-2 rounded-full border border-white/40 mb-2 group-has-[:checked]:bg-skyblue group-has-[:checked]:border-skyblue transition-all"></div>
                                    <span class="text-[9px] font-black uppercase text-white/60 group-hover:text-white transition-colors">{{ __('Evening') }}</span>
                                    <span class="text-[8px] font-bold text-white/30 uppercase mt-1">17:00-20:00</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Travel Date</label>
                            <input type="date" name="travel_date" required class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none cursor-pointer">
                        </div>

                        @auth
                            <button type="submit" class="w-full py-5 bg-skyblue hover:bg-white hover:text-brandblue text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] transition-all duration-500 shadow-xl shadow-skyblue/20">
                                {{ __('Book Armada') }}
                            </button>
                        @else
                            <div class="pt-4 border-t border-white/10 space-y-4">
                                <p class="text-[10px] text-white/40 text-center italic leading-relaxed">Please login to secure your booking and check availability.</p>
                                <a href="{{ route('login') }}" class="block w-full py-5 bg-white text-brandblue rounded-2xl text-xs font-black text-center uppercase tracking-[0.3em] hover:bg-skyblue hover:text-white transition-all duration-500 shadow-xl">
                                    Login & Book
                                </a>
                            </div>
                        @endauth
                    </form>

                    <div class="mt-12 pt-12 border-t border-white/10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-8 h-8 rounded-full bg-skyblue/20 flex items-center justify-center text-skyblue">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest italic">{{ __('All-In Service') }}</p>
                        </div>
                        <p class="text-[9px] text-white/40 leading-relaxed font-medium capitalize">{{ __('Fuel, Driver fees, and standard insurance are already included in the displayed rate.') }}</p>
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
