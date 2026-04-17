@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-10 pb-20">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-black text-brandblue mb-2 tracking-tight">Available Transport</h1>
        <p class="text-sm text-slate-500 mb-8">Premium fleet for your comfortable journey in Batam.</p>

        <!-- Date Availability Check -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 mb-12 flex flex-col md:flex-row items-center gap-6">
            <div class="flex-1">
                <h2 class="text-xl font-black text-brandblue mb-1">Check Availability</h2>
                <p class="text-xs text-slate-400">Select a date to see if our fleet is ready for you.</p>
            </div>
            <form action="{{ route('transport.index') }}" method="GET" class="flex gap-4 w-full md:w-auto">
                <input type="date" name="date" value="{{ $selectedDate }}" class="bg-lightbg border-none rounded-xl px-6 py-3 text-sm font-bold text-brandblue focus:ring-2 focus:ring-skyblue transition">
                <button type="submit" class="bg-brandblue hover:bg-slate-800 text-white px-8 py-3 rounded-xl font-black text-sm transition">Check Now</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($transports as $transport)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-xl hover:shadow-brandblue/5 transition-all duration-300 relative">
                <a href="{{ route('transport.show', $transport['slug']) }}" class="absolute inset-0 z-10" aria-label="View {{ $transport['name'] }} details"></a>
                <div class="h-48 overflow-hidden relative">
                    @if(!$transport['available'])
                        <div class="absolute inset-0 bg-slate-900/60 z-30 flex items-center justify-center backdrop-blur-sm">
                            <span class="bg-red-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest">Booked Out</span>
                        </div>
                    @endif
                    <img src="{{ $transport['image'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 right-4 z-20">
                        <span class="bg-white/90 backdrop-blur text-[9px] font-black text-brandblue px-3 py-1 rounded-full uppercase tracking-tighter">{{ $transport['category'] }}</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-brandblue mb-3 group-hover:text-skyblue transition-colors italic">{{ $transport['name'] }}</h3>
                    <div class="flex gap-4 text-[10px] font-bold text-slate-400 mb-6">
                        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> {{ $transport['capacity'] }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $transport['description'] }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-slate-50 relative z-20">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Per Day Rate</p>
                            <p class="text-lg font-black text-brandblue italic">IDR {{ number_format($transport['price'], 0, ',', '.') }}</p>
                        </div>
                        @if($transport['available'])
                            <form action="{{ route('transport.book', $transport['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="travel_date" value="{{ $selectedDate }}">
                                <button type="submit" class="bg-brandblue hover:bg-slate-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-brandblue/20">Book Now</button>
                            </form>
                        @else
                            <button disabled class="bg-slate-100 text-slate-400 text-sm font-bold px-6 py-2.5 rounded-xl cursor-not-allowed">Full</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <!-- Features -->
        <div class="grid md:grid-cols-3 gap-12 mt-12">
            <div>
                <div class="w-10 h-10 bg-skyblue/20 rounded-xl flex items-center justify-center text-skyblue mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brandblue mb-2">Professional Drivers</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Our drivers are multi-lingual, highly trained, and deeply knowledgeable about Indonesian routes and destinations.</p>
            </div>
            <div>
                <div class="w-10 h-10 bg-skyblue/20 rounded-xl flex items-center justify-center text-skyblue mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brandblue mb-2">Safety First</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Every vehicle in our fleet undergoes daily safety inspections and regular maintenance at authorized service centers.</p>
            </div>
            <div>
                <div class="w-10 h-10 bg-skyblue/20 rounded-xl flex items-center justify-center text-skyblue mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brandblue mb-2">Reliable Scheduling</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Punctuality is our priority. We track traffic in real-time to ensure your transport is always ready before you are.</p>
            </div>
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
