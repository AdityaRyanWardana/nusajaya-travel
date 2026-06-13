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

        @if(auth()->user()->role !== 'superadmin')
        <div class="flex items-center gap-3">
            @if($booking->status == 'pending')
            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-200 hover:scale-105 transition-all">{{ __('Confirm Payment') }}</button>
            </form>
            @endif
            
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                  data-confirm="{{ $booking->status === 'paid' ? 'WARNING: This booking is PAID. Delete it permanently?' : 'Delete this booking permanently? This cannot be undone.' }}"
                  data-confirm-title="Delete Booking"
                  data-confirm-ok="Yes, Delete">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-4 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <i data-lucide="trash-2" class="w-6 h-6"></i>
                </button>
            </form>
        </div>
        @endif
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

            {{-- Customer Biodata --}}
            @if($booking->customer_details)
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-50/50 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-3 relative z-10">
                    <span class="w-8 h-px bg-slate-100"></span> {{ __('Booking Biodata') }}
                </h4>

                <div class="grid md:grid-cols-2 gap-8 relative z-10">
                    <div class="space-y-4">
                        <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-4">{{ __('Participants / Guests') }}</p>
                            @if(isset($booking->customer_details['names']) && is_array($booking->customer_details['names']))
                                <div class="grid gap-4">
                                    @foreach($booking->customer_details['names'] as $index => $participant)
                                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-[10px] font-black flex items-center justify-center shrink-0 mt-1">{{ $index + 1 }}</span>
                                            <div class="space-y-1">
                                                @if(is_array($participant))
                                                    <p class="text-sm font-black text-slate-800 italic uppercase tracking-tighter">
                                                        <span class="text-blue-500 mr-1">{{ $participant['salutation'] ?? 'Mr' }}.</span> 
                                                        {{ $participant['name'] ?? 'No Name' }}
                                                    </p>
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                                        <i data-lucide="credit-card" class="w-3 h-3"></i>
                                                        ID: {{ $participant['identity'] ?? '-' }}
                                                    </p>
                                                @else
                                                    <p class="text-sm font-black text-slate-800 italic uppercase tracking-tighter">{{ $participant }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm font-black text-slate-800 italic uppercase tracking-tighter">{{ $booking->customer_details['name'] ?? $booking->user->name }}</p>
                            @endif
                        </div>
                        <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">{{ __('WhatsApp / Phone') }}</p>
                            <p class="text-sm font-black text-slate-800">{{ $booking->customer_details['phone'] ?? $booking->user->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="h-full">
                        <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 h-full">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">{{ __('Special Notes') }}</p>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed">{{ $booking->customer_details['notes'] ?: __('No special notes provided.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

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
                    
                    @if($booking->payment_method)
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mb-1">{{ __('Method') }}</p>
                            <p class="text-sm font-bold uppercase tracking-widest text-skyblue">{{ $booking->payment_method }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="h-px bg-white/5"></div>

                    <div class="flex justify-between items-center pt-4">
                        <p class="text-xs font-black uppercase tracking-widest">{{ __('Grand Total') }}</p>
                        <div class="text-right">
                            <p class="text-2xl font-black text-skyblue italic leading-none">IDR {{ number_format($booking->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                @if($booking->payment_proof)
                <div class="mt-10 pt-10 border-t border-white/5 relative z-10" x-data="{ showModal: false }">
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-6">{{ __('Payment Proof') }}</p>
                    <button @click="showModal = true" class="w-full text-left block group/proof relative rounded-2xl overflow-hidden border border-white/10 bg-white/5">
                        <img src="{{ asset('storage/' . $booking->payment_proof) }}" class="w-full h-48 object-cover group-hover/proof:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover/proof:opacity-100 transition-opacity">
                            <div class="px-4 py-2 bg-white text-slate-900 rounded-full text-[10px] font-black uppercase tracking-widest">
                                Click to Expand
                            </div>
                        </div>
                    </button>

                    <!-- Modal -->
                    <template x-teleport="body">
                        <div x-show="showModal" 
                             x-init="$watch('showModal', value => { if(value) { setTimeout(() => lucide.createIcons(), 10) } })"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/90 backdrop-blur-sm"
                             x-cloak>
                            
                            <div class="absolute inset-0 cursor-pointer" @click="showModal = false"></div>
                            
                            <div class="relative max-w-4xl w-full bg-white rounded-[3rem] p-4 shadow-2xl"
                                 x-show="showModal"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="scale-90 opacity-0"
                                 x-transition:enter-end="scale-100 opacity-100"
                                 @click.away="showModal = false">
                                
                                <button @click="showModal = false" class="absolute -top-4 -right-4 w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center shadow-xl hover:bg-red-500 hover:text-white transition-all z-20">
                                    <i data-lucide="x" class="w-6 h-6"></i>
                                </button>

                                <div class="rounded-[2.5rem] overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $booking->payment_proof) }}" class="w-full max-h-[80vh] object-contain">
                                </div>

                                <div class="mt-6 px-8 pb-4 flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Payment Method</p>
                                        <p class="text-sm font-black text-brandblue uppercase tracking-widest">{{ $booking->payment_method }}</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" download class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                        Download Proof
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                @elseif($booking->status == 'pending')
                <div class="mt-12 p-6 bg-white/5 rounded-[2rem] border border-white/10 relative z-10">
                    <p class="text-[9px] font-black text-white/50 uppercase tracking-widest mb-3 leading-relaxed">{{ __('Admin Action Required') }}</p>
                    <p class="text-[10px] font-bold text-white/30 italic">{{ __('Please verify the payment from the customer before confirming this booking.') }}</p>
                </div>
                @endif
            </div>

            {{-- Action History --}}
            @if(auth()->user()->role !== 'superadmin')
                @if($booking->status !== 'cancelled')
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">{{ __('Booking Actions') }}</h4>
                    <div class="space-y-3">
                        @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="w-full py-4 text-xs font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/30 hover:bg-emerald-500 hover:text-white rounded-2xl transition-all duration-300">{{ __('Set as Paid') }}</button>
                        </form>
                        @endif

                        <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST"
                              data-confirm="Are you sure you want to cancel this booking? This action cannot be undone."
                              data-confirm-type="warning"
                              data-confirm-title="Cancel Booking"
                              data-confirm-ok="Yes, Cancel Booking">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full py-4 text-xs font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30 hover:bg-amber-500 hover:text-white rounded-2xl transition-all duration-300">{{ __('Cancel Booking') }}</button>
                        </form>
                    </div>
                </div>
                @endif
            @else
            <div class="bg-sky-50/50 dark:bg-sky-950/20 rounded-[3rem] p-8 border border-sky-100 dark:border-sky-900/50 shadow-sm">
                <h4 class="text-[10px] font-black text-sky-500 dark:text-sky-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i data-lucide="shield-alert" class="w-4 h-4"></i> {{ __('Audit Mode Active') }}
                </h4>
                <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 leading-relaxed italic">
                    {{ __('As a Superadmin, your access to bookings and transaction logs is strictly "Audit Only" according to system access control protocols. No changes can be processed.') }}
                </p>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
