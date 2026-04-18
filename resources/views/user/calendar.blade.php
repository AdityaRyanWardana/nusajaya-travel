@extends('layouts.public')

@section('content')
<section class="max-w-6xl mx-auto px-8 py-20 w-full">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="text-3xl font-black text-brandblue uppercase tracking-tight mb-2">My Travel Calendar</h1>
            <p class="text-slate-500 font-medium italic">Track your upcoming adventures and booking history.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border border-slate-100 rounded-xl text-[10px] font-black uppercase text-slate-400 hover:text-brandblue transition shadow-sm">Monthly</button>
            <button class="px-4 py-2 bg-brandblue rounded-xl text-[10px] font-black uppercase text-white shadow-lg">Schedule View</button>
        </div>
    </div>

    <div class="grid md:grid-cols-4 gap-8">
        <!-- Upcoming Events Summary -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-6">Upcoming Trips</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="bg-skyblue/10 w-12 h-12 rounded-2xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-black text-skyblue uppercase">Apr</span>
                            <span class="text-sm font-black text-brandblue leading-none">24</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-brandblue mb-1">Batam City Tour</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Full Day Service</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-brandblue/5 w-12 h-12 rounded-2xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-black text-slate-400 uppercase">May</span>
                            <span class="text-sm font-black text-slate-500 leading-none">02</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-500 mb-1">VIP Bus Booking</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Corporate Event</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-lightbg rounded-3xl p-8 text-center border-2 border-dashed border-slate-200">
                <p class="text-xs font-bold text-slate-400 mb-4 leading-relaxed">Planning a new journey?</p>
                <a href="{{ route('tours.index') }}" class="text-[10px] font-black text-skyblue uppercase tracking-[0.2em] hover:text-brandblue transition">Book New Package →</a>
            </div>
        </div>

        <!-- Main Calendar View (Visual Representation) -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-2xl relative overflow-hidden">
                <div class="grid grid-cols-7 gap-4 mb-8">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="text-center">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-4">
                    @for($i = 1; $i <= 31; $i++)
                        @php $hasTrip = ($i == 24 || $i == 25); @endphp
                        <div class="aspect-square rounded-2xl flex flex-col items-center justify-center relative transition hover:bg-lightbg group cursor-pointer {{ $hasTrip ? 'bg-skyblue shadow-xl shadow-skyblue/20' : 'bg-white' }}">
                            <span class="text-sm font-black {{ $hasTrip ? 'text-white' : 'text-slate-400 group-hover:text-brandblue' }}">
                                {{ $i }}
                            </span>
                            @if($hasTrip)
                                <div class="absolute bottom-2 w-1 h-1 rounded-full bg-white opacity-50"></div>
                            @endif
                        </div>
                    @endfor
                </div>

                <!-- Glow Effect -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-skyblue/5 rounded-full blur-3xl -z-10"></div>
            </div>
            
            <!-- Trip Legend -->
            <div class="mt-8 flex gap-6 px-4">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-skyblue"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Scheduled Tours</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-brandblue"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Transport Booking</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
