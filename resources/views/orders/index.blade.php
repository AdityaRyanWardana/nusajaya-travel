@extends('layouts.public')

@section('content')
<main class="flex-1 bg-slate-50/50 px-6 py-16">
    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div class="relative">
                <div class="absolute -left-4 top-0 w-1 h-full bg-brandblue rounded-full"></div>
                <span class="text-skyblue font-black uppercase tracking-[0.4em] text-[10px] mb-3 block">Traveler Concierge</span>
                <h1 class="text-5xl font-black text-brandblue tracking-tighter uppercase italic leading-none">My <span class="text-slate-400 not-italic font-light">Orders</span></h1>
                <p class="text-slate-400 font-medium mt-4 max-w-md italic">Manage your premium travel experiences, rescheduling, and personal cancellations.</p>
            </div>
            
            <div class="flex items-center gap-4">
                @if(count($orders) > 0)
                    <form action="{{ route('orders.reset') }}" method="POST" onsubmit="return confirm('Are you sure? This will clear your entire order history.')">
                        @csrf
                        <button type="submit" class="group flex items-center gap-3 px-8 py-4 bg-white text-red-400 border border-red-50 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-500 shadow-sm">
                            <i data-lucide="refresh-cw" class="w-4 h-4 group-hover:rotate-180 transition-transform duration-700"></i>
                            Reset History
                        </button>
                    </form>
                @endif
                <a href="{{ route('tours.index') }}" class="group flex items-center gap-3 px-10 py-4 bg-brandblue text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-brandblue/20 hover:bg-slate-800 hover:-translate-y-1 transition-all duration-500">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Book New Journey
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-white border-l-4 border-emerald-500 p-6 rounded-2xl shadow-xl shadow-emerald-500/5 mb-10 animate-in slide-in-from-top duration-700">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-white border-l-4 border-red-500 p-6 rounded-2xl shadow-xl shadow-red-500/5 mb-10 animate-in slide-in-from-top duration-700">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center shrink-0">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Orders List --}}
        <div class="space-y-6">
            @forelse($orders as $order)
                @php
                    $statusStyles = match($order->status) {
                        'paid'      => ['bg' => 'bg-emerald-50/50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'dot' => 'bg-emerald-500'],
                        'pending'   => ['bg' => 'bg-amber-50/50',   'text' => 'text-amber-600',   'border' => 'border-amber-100',   'dot' => 'bg-amber-500 animate-pulse'],
                        'cancelled' => ['bg' => 'bg-slate-50',      'text' => 'text-slate-400',   'border' => 'border-slate-100',   'dot' => 'bg-slate-300'],
                        default     => ['bg' => 'bg-blue-50',       'text' => 'text-blue-600',    'border' => 'border-blue-100',    'dot' => 'bg-blue-500'],
                    };
                @endphp

                <div class="group relative bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-brandblue/5 transition-all duration-700 overflow-hidden">
                    {{-- Status Bar --}}
                    <div class="absolute left-0 top-0 w-1.5 h-full {{ $statusStyles['dot'] }}"></div>

                    <div class="p-8 md:p-10">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-10">
                            
                            {{-- Service Info --}}
                            <div class="flex items-center gap-6 lg:w-72 shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-brandblue shadow-inner group-hover:scale-110 transition duration-700">
                                    @if($order->type == 'tour')
                                        <i data-lucide="map" class="w-8 h-8"></i>
                                    @else
                                        <i data-lucide="car" class="w-8 h-8"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-brandblue uppercase italic leading-tight group-hover:text-skyblue transition duration-500">{{ $order->service_name }}</h3>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mt-1">{{ $order->order_number }}</p>
                                </div>
                            </div>

                            {{-- Stats Grid --}}
                            <div class="grid grid-cols-2 md:grid-cols-3 flex-1 gap-8">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Travel Date</p>
                                    <p class="text-sm font-black text-slate-700">{{ date('d M Y', strtotime($order->travel_date)) }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Party Size</p>
                                    <p class="text-sm font-black text-slate-700">{{ $order->guests }} {{ $order->guests > 1 ? 'Persons' : 'Person' }}</p>
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Total Investment</p>
                                    <p class="text-base font-black text-brandblue italic">IDR {{ number_format($order->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            {{-- Status & Action --}}
                            <div class="flex flex-row lg:flex-col items-center justify-between lg:justify-center gap-6 shrink-0 lg:w-48 lg:border-l lg:border-slate-50 lg:pl-10">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $statusStyles['bg'] }} {{ $statusStyles['text'] }} border {{ $statusStyles['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusStyles['dot'] }}"></span>
                                    {{ $order->status }}
                                </span>
                                
                                <button onclick="toggleModal('modal-{{ $order->id }}')" class="px-6 py-3 bg-slate-50 text-slate-500 hover:bg-brandblue hover:text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-500 italic">
                                    Manage Details
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal --}}
                    <div id="modal-{{ $order->id }}" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6 bg-slate-900/90 backdrop-blur-md transition-opacity">
                        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden text-left transform transition-all scale-95 opacity-0 duration-500" id="modal-content-{{ $order->id }}">
                            <div class="p-12">
                                <div class="flex justify-between items-start mb-10">
                                    <div class="relative">
                                        <div class="absolute -left-4 top-0 w-1 h-full bg-skyblue rounded-full"></div>
                                        <h3 class="text-3xl font-black text-brandblue leading-tight mb-1 uppercase italic tracking-tighter">Booking <span class="text-slate-400">File</span></h3>
                                        <p class="text-[10px] text-slate-300 font-black uppercase tracking-[0.3em]">{{ $order->order_number }}</p>
                                    </div>
                                    <button onclick="toggleModal('modal-{{ $order->id }}')" class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all duration-500">
                                        <i data-lucide="x" class="w-6 h-6"></i>
                                    </button>
                                </div>

                                <div class="grid md:grid-cols-2 gap-10">
                                    <div class="space-y-8">
                                        <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                                            <div class="space-y-6">
                                                <div>
                                                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mb-2 italic">Full Service</p>
                                                    <p class="text-lg font-black text-brandblue leading-tight">{{ $order->service_name }}</p>
                                                </div>
                                                <div class="flex justify-between border-t border-slate-200/50 pt-4">
                                                    <div>
                                                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mb-1 italic">Date</p>
                                                        <p class="text-sm font-black text-slate-600">{{ date('d M Y', strtotime($order->travel_date)) }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mb-1 italic">Investment</p>
                                                        <p class="text-sm font-black text-blue-600 italic">IDR {{ number_format($order->amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($order->status !== 'cancelled')
                                            <div class="p-8 bg-brandblue rounded-[2.5rem] shadow-xl shadow-brandblue/20">
                                                <h4 class="text-[10px] font-black text-skyblue uppercase tracking-[0.3em] mb-6 flex items-center gap-3">
                                                    <span class="w-6 h-px bg-skyblue/30"></span> Reschedule Trip
                                                </h4>
                                                <form action="{{ route('orders.reschedule', $order->id) }}" method="POST" class="space-y-4">
                                                    @csrf
                                                    <div class="relative">
                                                        <input type="date" name="new_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-white px-6 py-4 focus:ring-4 focus:ring-skyblue/20 focus:border-skyblue transition-all outline-none">
                                                    </div>
                                                    <button type="submit" class="w-full bg-skyblue hover:bg-white hover:text-brandblue text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-500 shadow-lg shadow-skyblue/20">
                                                        Apply New Date
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="space-y-6">
                                        @if($order->status == 'pending')
                                            <div class="bg-amber-50/50 border border-amber-100 p-8 rounded-[2.5rem]">
                                                <h5 class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-3 italic">Waiting for Approval</h5>
                                                <p class="text-xs text-amber-700/70 font-medium leading-relaxed italic mb-8">Our concierge team is verifying your payment. We will notify you once your premium access is confirmed.</p>
                                                <a href="{{ route('orders.payment', $order->id) }}" class="flex items-center justify-center gap-3 w-full py-4 bg-amber-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition shadow-lg shadow-amber-500/20 mb-3">
                                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                                    View Payment File
                                                </a>
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Release this booking? This cannot be undone.')">
                                                    @csrf
                                                    <button type="submit" class="w-full py-4 text-red-400 bg-white border border-red-50 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-500">
                                                        Withdraw Booking
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($order->status == 'paid')
                                            <div class="bg-emerald-50/50 border border-emerald-100 p-10 rounded-[3rem] text-center">
                                                <div class="w-20 h-20 bg-emerald-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-500/20 rotate-3">
                                                    <i data-lucide="award" class="w-10 h-10"></i>
                                                </div>
                                                <h5 class="text-xl font-black text-emerald-600 uppercase italic tracking-tighter mb-2">Access Granted</h5>
                                                <p class="text-xs text-emerald-700/60 font-medium leading-relaxed italic">Your premium journey is fully secured. Get ready for an extraordinary experience.</p>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 border border-slate-100 p-10 rounded-[3rem] text-center opacity-60">
                                                <div class="w-16 h-16 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                                    <i data-lucide="archive" class="w-8 h-8"></i>
                                                </div>
                                                <p class="text-xs text-slate-400 font-bold italic">This booking file has been closed.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-[3rem] border border-slate-100 py-32 text-center shadow-sm">
                    <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <i data-lucide="shopping-bag" class="w-12 h-12"></i>
                    </div>
                    <h3 class="text-2xl font-black text-brandblue uppercase italic mb-2 tracking-tighter">Your Portfolio is Empty</h3>
                    <p class="text-slate-400 font-medium mb-10 max-w-xs mx-auto italic">It seems you haven't secured any premium travel experiences yet.</p>
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-brandblue text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-brandblue/20 hover:bg-slate-800 hover:scale-105 transition-all duration-500">
                        Discover Destinations
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Footer Support --}}
        <div class="mt-20 group relative overflow-hidden bg-white p-10 rounded-[3rem] border border-slate-100 flex flex-col md:flex-row items-center gap-10 shadow-sm hover:shadow-xl transition-all duration-700">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-skyblue/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="w-16 h-16 rounded-2xl bg-skyblue/10 flex items-center justify-center text-skyblue shrink-0 border border-skyblue/20 shadow-inner group-hover:rotate-12 transition duration-500">
                <i data-lucide="help-circle" class="w-8 h-8"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h4 class="text-lg font-black text-brandblue uppercase italic tracking-tighter mb-1">Bespoke Concierge Support</h4>
                <p class="text-xs text-slate-400 font-medium leading-relaxed italic">
                    For bespoke rescheduling, special hospitality requests, or urgent inquiries, our elite support team is at your disposal at 
                    <a href="mailto:support@nusajaya.com" class="text-skyblue font-black hover:underline">support@nusajaya.com</a>.
                </p>
            </div>
            <div class="shrink-0 relative z-10">
                <a href="mailto:support@nusajaya.com" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-skyblue transition-all duration-500 shadow-xl shadow-slate-900/10">
                    Contact Specialist
                </a>
            </div>
        </div>
    </div>
</main>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = document.getElementById('modal-content-' + modalId.split('-')[1]);
        
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
                lucide.createIcons();
            }, 50);
        } else {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 500);
        }
    }

    // Close on click outside
    window.onclick = function(event) {
        if (event.target.id && event.target.id.startsWith('modal-')) {
            toggleModal(event.target.id);
        }
    }
</script>
@endsection
