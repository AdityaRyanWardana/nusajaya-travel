@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-20">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.bookings.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 border border-slate-100 shadow-sm transition-all group">
                <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight uppercase italic leading-none">{{ __('Booking Description') }}</h2>
                <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] tracking-[0.2em] italic">{{ $booking->order_number }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($booking->status == 'pending')
            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-200 hover:scale-105 transition-all">{{ __('Confirm Payment') }}</button>
            </form>
            @endif
            
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this record permanently?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-4 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <i data-lucide="trash-2" class="w-6 h-6"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Customer & Main Details --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Customer Card --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-3 relative z-10">
                    <span class="w-8 h-px bg-slate-100"></span> {{ __('Customer Profile') }}
                </h4>

                <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
                    <div class="w-32 h-32 rounded-[2.5rem] bg-slate-100 p-1 border-4 border-white shadow-xl overflow-hidden shrink-0">
                        @if($booking->user->avatar)
                            <img src="{{ asset('storage/' . $booking->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl font-black text-slate-300">
                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left space-y-2">
                        <h3 class="text-3xl font-black text-brandblue italic tracking-tight">{{ $booking->user->name }}</h3>
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-xs">{{ $booking->user->email }}</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-4">
                            <div class="px-5 py-3 bg-blue-50 rounded-2xl border border-blue-100">
                                <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest leading-none mb-1">{{ __('Phone Number') }}</p>
                                <p class="text-sm font-black text-blue-600">{{ $booking->user->phone ?? __('Not Set') }}</p>
                            </div>
                            <div class="px-5 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ __('User Status') }}</p>
                                <p class="text-sm font-black text-slate-700 uppercase">{{ $booking->user->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Trip & Service Details --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative group overflow-hidden">
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-50/30 rounded-full blur-3xl"></div>
                
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-10 flex items-center gap-3 relative z-10">
                    <span class="w-8 h-px bg-slate-100"></span> {{ __('Booking Description') }}
                </h4>

                <div class="grid md:grid-cols-2 gap-12 relative z-10">
                    
                    {{-- Route Info --}}
                    <div class="space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-3 h-3 text-emerald-500"></i> {{ __('Pickup Point') }}
                            </p>
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <p class="text-sm font-bold text-slate-800 leading-relaxed italic">"{{ $booking->pickup_point ?? __('Not specified') }}"</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i data-lucide="flag" class="w-3 h-3 text-red-500"></i> {{ __('Final Destination') }}
                            </p>
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <p class="text-sm font-bold text-slate-800 leading-relaxed italic">"{{ $booking->destination ?? $booking->service_name }}"</p>
                            </div>
                        </div>
                    </div>

                    {{-- Service Info --}}
                    <div class="space-y-8">
                        <div class="flex items-start gap-5 p-8 bg-blue-50/50 rounded-[2rem] border border-blue-100">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                                <i data-lucide="car" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">{{ __('Armada / Service') }}</p>
                                <h5 class="text-xl font-black text-brandblue italic leading-tight">{{ $booking->service_name }}</h5>
                                <span class="inline-block mt-2 px-3 py-1 bg-white text-blue-600 rounded-full text-[9px] font-black uppercase tracking-widest">{{ $booking->type }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('Travel Date') }}</p>
                                <p class="text-sm font-black text-brandblue">{{ $booking->travel_date?->format('d M Y') }}</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('Pickup Time') }}</p>
                                <p class="text-sm font-black text-brandblue">{{ $booking->pickup_time ?? __('Not Set') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right Column: Payment & Summary --}}
        <div class="space-y-8">
            
            {{-- Status Card --}}
            <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm overflow-hidden relative">
                @php
                    $statusConfig = match($booking->status) {
                        'paid'      => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'check-circle'],
                        'pending'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'icon' => 'clock'],
                        'cancelled' => ['bg' => 'bg-red-50',     'text' => 'text-red-500',     'icon' => 'x-circle'],
                        default     => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'icon' => 'info'],
                    };
                @endphp
                <div class="flex items-center justify-between mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Current Status') }}</p>
                    <span class="w-10 h-10 {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} rounded-xl flex items-center justify-center">
                        <i data-lucide="{{ $statusConfig['icon'] }}" class="w-6 h-6"></i>
                    </span>
                </div>
                <h3 class="text-4xl font-black {{ $statusConfig['text'] }} uppercase italic tracking-tighter">{{ $booking->status }}</h3>
                <p class="text-[10px] font-bold text-slate-400 mt-2 italic leading-tight">{{ __('Order received on') }} {{ $booking->created_at->format('l, d F Y') }}</p>
            </div>

            {{-- Payment Card --}}
            <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-900/20 relative overflow-hidden group">
                <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                
                <h4 class="text-[10px] font-black text-white/40 uppercase tracking-[0.3em] mb-10 flex items-center gap-3 relative z-10">
                    <span class="w-8 h-px bg-white/10"></span> {{ __('Payment Summary') }}
                </h4>

                <div class="space-y-6 relative z-10">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-1">{{ __('Service Fee') }}</p>
                            <p class="text-sm font-bold">IDR {{ number_format($booking->amount, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-[9px] font-black text-white/20">Qty: 1</p>
                    </div>
                    
                    <div class="h-px bg-white/5"></div>

                    <div class="flex justify-between items-center pt-4">
                        <p class="text-xs font-black uppercase tracking-widest">{{ __('Grand Total') }}</p>
                        <div class="text-right">
                            <p class="text-2xl font-black text-skyblue italic leading-none">IDR {{ number_format($booking->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                @if($booking->status == 'pending')
                <div class="mt-12 p-6 bg-white/5 rounded-[2rem] border border-white/10 relative z-10">
                    <p class="text-[9px] font-black text-white/50 uppercase tracking-widest mb-3 leading-relaxed">{{ __('Admin Action Required') }}</p>
                    <p class="text-[10px] font-bold text-white/30 italic">{{ __('Please verify the payment from the customer before confirming this booking.') }}</p>
                </div>
                @endif
            </div>

            {{-- Action History --}}
            <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">{{ __('Booking Actions') }}</h4>
                <div class="space-y-3">
                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="w-full py-4 text-xs font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 hover:bg-emerald-500 hover:text-white rounded-2xl transition-all duration-300">{{ __('Set as Paid') }}</button>
                    </form>
                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="w-full py-4 text-xs font-black uppercase tracking-widest text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-2xl transition-all duration-300">{{ __('Cancel Booking') }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
