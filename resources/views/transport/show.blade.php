@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-16 pb-24">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('transport.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 hover:text-brandblue transition group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Fleet
        </a>

        <div class="grid lg:grid-cols-3 gap-12" x-data="{ 
            route: 'city_tour', 
            duration: 'one_way',
            price() {
                if (this.route === 'barelang') return '1.800.000';
                if (this.route === 'city_tour') {
                    if (this.duration === 'one_way') return '900.000';
                    if (this.duration === 'half_day') return '1.400.000';
                    if (this.duration === 'one_day') return '1.900.000';
                    if (this.duration === 'full_day') return '2.200.000';
                }
                return '{{ number_format($transport['price'], 0, ',', '.') }}';
            }
        }">
            <!-- Left: Cinematic Content -->
            <div class="lg:col-span-2 space-y-12">
                <div class="relative h-[500px] rounded-[3rem] overflow-hidden shadow-2xl">
                    <img src="{{ $transport['image'] }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-brandblue via-transparent to-transparent opacity-90"></div>
                    <div class="absolute bottom-12 left-12 right-12">
                        <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 inline-block">
                            {{ $transport['category'] }}
                        </span>
                        <h1 class="text-5xl font-black text-white uppercase italic leading-[0.9] tracking-tighter">{{ $transport['name'] }}</h1>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-brandblue uppercase italic mb-6">Fleet Specification</h2>
                    <p class="text-slate-500 font-medium leading-relaxed mb-10">{{ $transport['description'] }}</p>
                    
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8">Premium Features</h3>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Full AC Climate Control</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Multimedia Entertainment</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">Reclining VIP Seats</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-skyblue shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-[11px] font-black text-brandblue uppercase">USB Charging Ports</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Premium Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-brandblue rounded-[3rem] p-10 text-white shadow-2xl sticky top-32">
                    <p class="text-[10px] font-black text-skyblue uppercase tracking-[0.4em] mb-4">
                        {{ $transport['slug'] === 'vip-high-deck' ? 'Configurable Rate' : 'Fixed Rate' }}
                    </p>
                    <div class="flex items-baseline gap-2 mb-10">
                        <span class="text-sm font-bold opacity-60">IDR</span>
                        <span class="text-4xl font-black italic tracking-tighter" x-text="price()"></span>
                    </div>

                    @auth
                    <form action="{{ route('transport.book', $transport['id']) }}" method="POST" class="space-y-6">
                        @csrf
                        @if($transport['slug'] === 'vip-high-deck')
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Select Route</label>
                            <select name="route_option" x-model="route" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none appearance-none cursor-pointer">
                                <option value="city_tour" class="text-brandblue">Batam City Tour</option>
                                <option value="barelang" class="text-brandblue">PP Barelang</option>
                            </select>
                        </div>
                        
                        <div x-show="route === 'city_tour'" x-transition class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Select Duration</label>
                            <select name="duration_option" x-model="duration" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none appearance-none cursor-pointer">
                                <option value="one_way" class="text-brandblue">One Way Transfer</option>
                                <option value="half_day" class="text-brandblue">Half Day (4 Hours)</option>
                                <option value="one_day" class="text-brandblue">One Day (8 Hours)</option>
                                <option value="full_day" class="text-brandblue">Full Day (12 Hours)</option>
                            </select>
                        </div>
                        @endif

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-widest">Travel Date</label>
                            <input type="date" name="travel_date" required class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue transition outline-none">
                        </div>

                        <button type="submit" class="w-full py-5 bg-skyblue hover:bg-white hover:text-brandblue text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] transition-all duration-500 shadow-xl shadow-skyblue/20">
                            Book Armada
                        </button>
                    </form>
                    @else
                    <div class="space-y-6 text-center">
                        <p class="text-xs font-medium text-white/60 leading-relaxed italic">Login to your account to unlock exclusive member rates and secure your booking.</p>
                        <a href="{{ route('login') }}" class="block w-full py-5 bg-white text-brandblue rounded-2xl text-xs font-black center uppercase tracking-[0.3em] hover:bg-skyblue hover:text-white transition-all duration-500 shadow-xl">
                            Login & Book
                        </a>
                    </div>
                    @endauth

                    <div class="mt-12 pt-12 border-t border-white/10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-8 h-8 rounded-full bg-skyblue/20 flex items-center justify-center text-skyblue">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest italic">All-In Service</p>
                        </div>
                        <p class="text-[9px] text-white/40 leading-relaxed font-medium capitalize">Fuel, Driver fees, and standard insurance are already included in the displayed rate.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
