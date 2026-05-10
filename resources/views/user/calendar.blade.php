@extends('layouts.public')

@section('content')
<section class="max-w-6xl mx-auto px-8 py-20 w-full" x-data="{ activeView: 'monthly' }">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="text-3xl font-black text-brandblue uppercase tracking-tight mb-2">My Travel Calendar</h1>
            <p class="text-slate-500 font-medium italic">Track your upcoming adventures and booking history.</p>
        </div>
        <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
            <button @click="activeView = 'monthly'" 
                    :class="activeView === 'monthly' ? 'bg-white text-brandblue shadow-md' : 'text-slate-400 hover:text-slate-600'"
                    class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">Monthly</button>
            <button @click="activeView = 'schedule'" 
                    :class="activeView === 'schedule' ? 'bg-white text-brandblue shadow-md' : 'text-slate-400 hover:text-slate-600'"
                    class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">Schedule View</button>
        </div>
    </div>

    <div class="grid md:grid-cols-4 gap-12">
        <!-- Upcoming Events Summary -->
        <div class="md:col-span-1 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-8 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-skyblue"></span>
                    Upcoming Trips
                </h3>
                <div class="space-y-8">
                    @forelse($bookings->where('travel_date', '>=', now()->startOfDay())->take(3) as $trip)
                        <div class="flex gap-5 group">
                            <div class="bg-skyblue/10 w-14 h-14 rounded-2xl flex flex-col items-center justify-center shrink-0 group-hover:bg-skyblue group-hover:text-white transition-colors duration-500 shadow-sm">
                                <span class="text-[10px] font-black uppercase opacity-60">{{ $trip->travel_date->format('M') }}</span>
                                <span class="text-base font-black leading-none">{{ $trip->travel_date->format('d') }}</span>
                            </div>
                            <div class="overflow-hidden py-1">
                                <h4 class="text-xs font-black text-brandblue mb-1 truncate tracking-tight">{{ $trip->service_name }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $trip->status === 'paid' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">{{ $trip->status }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center space-y-4">
                            <div class="w-12 h-12 bg-slate-50 rounded-full mx-auto flex items-center justify-center text-slate-200">
                                <i data-lucide="calendar-off" class="w-6 h-6"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">No upcoming trips</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-[2.5rem] p-10 text-center border-2 border-dashed border-slate-200 group hover:border-skyblue transition-colors duration-500">
                <p class="text-xs font-bold text-slate-400 mb-6 leading-relaxed">Ready for your next adventure?</p>
                <a href="{{ route('tours.index') }}" class="inline-flex px-8 py-4 bg-white border border-slate-100 rounded-2xl text-[10px] font-black text-brandblue uppercase tracking-[0.2em] hover:bg-brandblue hover:text-white transition-all duration-500 shadow-sm">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="md:col-span-3">
            {{-- Monthly Calendar View --}}
            <div x-show="activeView === 'monthly'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[3.5rem] p-12 border border-slate-100 shadow-2xl relative overflow-hidden">
                
                <div class="flex items-center justify-between mb-12">
                    <h2 class="text-xl font-black text-brandblue uppercase italic tracking-tighter">{{ now()->format('F Y') }}</h2>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-skyblue"></div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tours</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-brandblue"></div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Transport</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-6 mb-8">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="text-center">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-6">
                    @php
                        $currentMonth = now()->month;
                        $currentYear = now()->year;
                        $daysInMonth = now()->daysInMonth;
                        $firstDayOfMonth = now()->startOfMonth()->dayOfWeek;
                        $tripDates = $bookings->filter(fn($b) => $b->travel_date->month == $currentMonth && $b->travel_date->year == $currentYear)
                                              ->groupBy(fn($b) => $b->travel_date->day);
                    @endphp

                    {{-- Empty slots for previous month --}}
                    @for($i = 0; $i < $firstDayOfMonth; $i++)
                        <div class="aspect-square opacity-0"></div>
                    @endfor

                    @for($i = 1; $i <= $daysInMonth; $i++)
                        @php 
                            $dayTrips = $tripDates->get($i);
                            $hasTrip = !is_null($dayTrips);
                        @endphp
                        <div class="aspect-square rounded-[1.5rem] flex flex-col items-center justify-center relative transition-all duration-500 hover:scale-110 group cursor-pointer {{ $hasTrip ? 'bg-skyblue shadow-xl shadow-skyblue/30 ring-4 ring-skyblue/5' : 'bg-slate-50/50 hover:bg-white hover:shadow-xl hover:shadow-slate-100' }}">
                            <span class="text-sm font-black {{ $hasTrip ? 'text-white' : 'text-slate-400 group-hover:text-brandblue' }}">
                                {{ $i }}
                            </span>
                            @if($hasTrip)
                                <div class="absolute bottom-3 w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
                                
                                {{-- Tooltip --}}
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-48 bg-brandblue text-white p-4 rounded-2xl text-[9px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-2xl">
                                    <div class="space-y-2">
                                        @foreach($dayTrips as $dt)
                                            <div class="flex flex-col border-b border-white/10 last:border-0 pb-1 last:pb-0">
                                                <span class="font-black uppercase tracking-widest text-skyblue">{{ $dt->type }}</span>
                                                <span class="font-bold opacity-80 truncate">{{ $dt->service_name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-brandblue"></div>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Detailed Schedule View --}}
            <div x-show="activeView === 'schedule'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6" x-cloak>
                @forelse($bookings as $booking)
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center gap-8 group hover:shadow-xl transition-all duration-500">
                        <div class="bg-slate-50 w-24 h-24 rounded-[2rem] flex flex-col items-center justify-center shrink-0 border border-slate-100 group-hover:bg-brandblue group-hover:text-white transition-colors duration-500">
                            <span class="text-[10px] font-black uppercase opacity-60">{{ $booking->travel_date->format('M') }}</span>
                            <span class="text-2xl font-black italic">{{ $booking->travel_date->format('d') }}</span>
                        </div>
                        <div class="flex-grow text-center md:text-left space-y-2">
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                                <span class="px-3 py-1 bg-skyblue/10 text-skyblue text-[8px] font-black uppercase tracking-[0.2em] rounded-full">{{ $booking->type }}</span>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $booking->travel_date->format('Y') }}</span>
                            </div>
                            <h4 class="text-lg font-black text-brandblue uppercase italic tracking-tight">{{ $booking->service_name }}</h4>
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="users" class="w-3 h-3 text-slate-400"></i>
                                    <span class="text-[10px] font-bold text-slate-400">{{ $booking->guests }} Guests</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                                    <span class="text-[10px] font-bold text-slate-400 truncate max-w-[150px]">{{ $booking->pickup_point ?? 'Batam Terminal' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="shrink-0 text-center md:text-right px-8">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] mb-2">Status</p>
                            <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[3rem] p-20 text-center border border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 rounded-full mx-auto flex items-center justify-center text-slate-200 mb-6">
                            <i data-lucide="calendar-x" class="w-10 h-10"></i>
                        </div>
                        <h4 class="text-xl font-black text-brandblue uppercase italic mb-2">No Bookings Found</h4>
                        <p class="text-slate-400 font-medium">Your travel history is currently empty.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
