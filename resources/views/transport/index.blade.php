@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-16 pb-24">
    <div class="max-w-7xl mx-auto">
        <!-- Premium Header & Availability -->
        <div class="mb-20 grid lg:grid-cols-2 gap-12 items-end">
            <div>
                <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Fleet Services</span>
                <h1 class="text-5xl font-black text-brandblue uppercase italic mb-6 leading-[0.9]">Premium Fleet Solutions</h1>
                <p class="text-sm text-slate-500 font-medium max-w-lg leading-relaxed">Dari bus VIP mewah hingga antar-jemput eksekutif, armada kami siap menjamin kenyamanan perjalanan Anda di Batam.</p>
            </div>
            
            <form action="{{ route('transport.index') }}" method="GET" class="bg-white p-4 rounded-[2.5rem] shadow-2xl shadow-brandblue/5 border border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                <div class="flex-1 flex items-center gap-4 px-6 w-full sm:w-auto">
                    <svg class="w-5 h-5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Travel Date</span>
                        <input type="date" name="date" value="{{ $selectedDate }}" class="text-xs font-black text-brandblue uppercase border-none p-0 focus:ring-0 cursor-pointer">
                    </div>
                </div>
                <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-brandblue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all">Check Now</button>
            </form>
        </div>

        <!-- Fleet Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($transports as $transport)
                <div class="group relative bg-white rounded-[3rem] overflow-hidden border border-slate-100 hover:shadow-2xl hover:shadow-brandblue/5 transition-all duration-700">
                    <!-- Whole Card Link -->
                    <a href="{{ route('transport.show', $transport['slug']) }}" class="absolute inset-0 z-20" aria-label="View {{ $transport['name'] }} details"></a>
                    
                    <!-- Status Badge -->
                    @if(!$transport['available'])
                        <div class="absolute inset-x-0 top-0 h-1 bg-red-500 z-50"></div>
                        <div class="absolute top-8 right-8 z-50">
                            <span class="px-3 py-1 bg-red-500 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">Not Available</span>
                        </div>
                    @endif

                    <!-- Image Wrapper -->
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ $transport['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000 {{ !$transport['available'] ? 'grayscale opacity-50' : '' }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-brandblue/90 via-transparent to-transparent opacity-80"></div>
                        
                        <!-- Floating Category -->
                        <div class="absolute top-8 left-8">
                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[9px] font-black uppercase tracking-widest rounded-full">
                                {{ $transport['category'] }}
                            </span>
                        </div>

                        <!-- Info Overlay -->
                        <div class="absolute bottom-6 left-8 flex items-center gap-6 text-white/80">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">{{ $transport['capacity'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-10">
                        <h3 class="text-2xl font-black text-brandblue uppercase italic mb-4 leading-none group-hover:text-skyblue transition">{{ $transport['name'] }}</h3>
                        <p class="text-sm text-slate-500 font-medium line-clamp-2 leading-relaxed mb-8">{{ $transport['description'] }}</p>
                        
                        <div class="flex items-center justify-between pt-8 border-t border-slate-50 relative z-30 pointer-events-none">
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">{{ $transport['is_flagship'] ? 'Starting From' : 'Standard Rate' }}</p>
                                <p class="text-xl font-black text-brandblue italic">IDR {{ number_format($transport['price'], 0, ',', '.') }}{{ $transport['is_flagship'] ? '*' : '' }}</p>
                            </div>

                            @if($transport['available'])
                                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-brandblue shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </div>
                            @else
                                <span class="text-[9px] font-black text-red-400 uppercase tracking-widest italic">Fully Booked</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Trust Features -->
        <div class="grid md:grid-cols-3 gap-12 mt-32">
            <div class="p-10 bg-white rounded-[2.5rem] border border-slate-50 group hover:border-skyblue transition-all">
                <div class="w-12 h-12 bg-skyblue/10 text-skyblue rounded-2xl flex items-center justify-center mb-6 group-hover:bg-skyblue group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.813.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <h4 class="text-xs font-black text-brandblue uppercase tracking-widest mb-4">Five Star Drivers</h4>
                <p class="text-[10px] text-slate-500 font-medium leading-relaxed">Pengemudi terlatih yang memahami rute Batam dengan sempurna, menjamin ketepatan waktu Anda.</p>
            </div>
            <!-- ... repeated feature structures with updated text if needed ... -->
        </div>
    </div>
</main>
@endsection

@section('footer')
<footer class="bg-lightbg pb-8 pt-4">
    <div class="max-w-7xl mx-auto px-8 border-t border-slate-200 pt-8 flex justify-between items-center">
        <div>
            <h4 class="text-xs font-bold text-brandblue">PT Nusa Jaya Indofast T&T</h4>
            <p class="text-[10px] text-slate-400 mt-1">© 2024 The Architectural Voyager. All rights reserved.</p>
        </div>
        <div class="flex gap-6 text-xs font-bold text-slate-500">
            <a href="#" class="hover:text-brandblue">Privacy</a>
            <a href="#" class="hover:text-brandblue">Terms</a>
            <a href="#" class="hover:text-brandblue">Support</a>
            <a href="#" class="hover:text-brandblue">Sustainability</a>
        </div>
    </div>
</footer>
@endsection
