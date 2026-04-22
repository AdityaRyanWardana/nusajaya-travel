@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-12">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-brandblue tracking-tight mb-2">My Orders</h1>
                <p class="text-slate-500 font-medium">Manage your travel bookings, rescheduling, and cancellations.</p>
            </div>
            <div class="flex gap-4">
                @if(count($orders) > 0)

                        @csrf
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-500 px-8 py-3 rounded-2xl font-black text-xs uppercase transition">
                            Reset History
                        </button>
                    </form>
                @endif
                <a href="{{ route('tours.index') }}" class="bg-brandblue text-white px-8 py-3 rounded-2xl font-bold text-xs uppercase shadow-lg shadow-brandblue/20 hover:bg-slate-800 transition">Book New Tour</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-2xl text-sm font-bold mb-8 flex items-center gap-3 border border-green-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl text-sm font-bold mb-8 flex items-center gap-3 border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                            <th class="py-5 px-8">Service</th>
                            <th class="py-5 px-6">Travel Date</th>
                            <th class="py-5 px-6">Guests</th>
                            <th class="py-5 px-6">Total Amount</th>
                            <th class="py-5 px-6">Status</th>
                            <th class="py-5 px-8 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition group">
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-skyblue/10 flex items-center justify-center text-skyblue">
                                        @if($order->type == 'tour')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-brandblue text-sm">{{ $order->service_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $order->order_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-6">
                                <p class="text-sm font-semibold text-slate-600">{{ date('d M Y', strtotime($order->travel_date)) }}</p>
                            </td>
                            <td class="py-6 px-6">
                                <p class="text-sm font-semibold text-slate-600">{{ $order->guests }} Person{{ $order->guests > 1 ? 's' : '' }}</p>
                            </td>
                            <td class="py-6 px-6">
                                <p class="text-sm font-bold text-brandblue">IDR {{ number_format($order->amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-6 px-6">
                                @if($order->status == 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> PAID
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> PENDING
                                    </span>
                                @elseif($order->status == 'cancelled')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-200 text-slate-600">
                                        CANCELLED
                                    </span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                <button onclick="toggleModal('modal-{{ $order->id }}')" class="text-xs font-bold text-brandblue hover:text-skyblue transition">Details</button>
                                
                                <!-- Modal -->
                                <div id="modal-{{ $order->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity">
                                    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden text-left transform transition-all scale-95 opacity-0 duration-300" id="modal-content-{{ $order->id }}">
                                        <div class="p-8">
                                            <div class="flex justify-between items-start mb-6">
                                                <div>
                                                    <h3 class="text-2xl font-black text-brandblue leading-tight mb-1">Booking Details</h3>
                                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ $order->order_number }}</p>
                                                </div>
                                                <button onclick="toggleModal('modal-{{ $order->id }}')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            <div class="bg-lightbg rounded-2xl p-6 mb-8">
                                                <div class="grid grid-cols-2 gap-y-4">
                                                    <div>
                                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">SERVICE</p>
                                                        <p class="text-sm font-bold text-brandblue">{{ $order->service_name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">STATUS</p>
                                                        <p class="text-sm font-bold {{ $order->status == 'paid' ? 'text-emerald-600' : ($order->status == 'pending' ? 'text-amber-600' : 'text-slate-600') }} uppercase tracking-widest">{{ $order->status }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">CURRENT DATE</p>
                                                        <p class="text-sm font-bold text-slate-600">{{ date('d M Y', strtotime($order->travel_date)) }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">TOTAL</p>
                                                        <p class="text-sm font-bold text-brandblue">IDR {{ number_format($order->amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($order->status !== 'cancelled')
                                            <!-- Reschedule Form -->
                                            <div class="mb-8 p-4 border border-slate-100 rounded-2xl">
                                                <h4 class="text-xs font-black text-brandblue uppercase tracking-widest mb-4">Update Travel Date</h4>
                                                <form action="{{ route('orders.reschedule', $order->id) }}" method="POST" class="flex gap-2">
                                                    @csrf
                                                    <input type="date" name="new_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="flex-1 bg-slate-50 border-none rounded-xl text-xs font-bold text-brandblue px-4 py-2.5 focus:ring-2 focus:ring-skyblue transition">
                                                    <button type="submit" class="bg-skyblue hover:bg-blue-400 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition">Update</button>
                                                </form>
                                            </div>

                                            <div class="flex flex-col gap-3">
                                                @if($order->status == 'pending')
                                                    <a href="{{ route('orders.payment', $order->id) }}" class="w-full py-4 bg-brandblue text-white hover:bg-slate-800 rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition text-center shadow-xl shadow-brandblue/20 mb-2">
                                                        Proceed to Payment
                                                    </a>
                                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                        @csrf
                                                        <button type="submit" class="w-full py-3.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-2xl text-xs font-black uppercase tracking-widest transition">Cancel This Booking</button>
                                                    </form>
                                                @endif
                                            </div>
                                            @else
                                            <div class="text-center p-6 bg-slate-50 rounded-2xl italic text-slate-400 text-sm font-medium">
                                                This booking has been cancelled and cannot be modified.
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-brandblue mb-1">No orders yet</h3>
                                <p class="text-sm text-slate-400 mb-6">You haven't made any bookings yet.</p>
                                <a href="{{ route('tours.index') }}" class="inline-block bg-brandblue text-white px-6 py-2 rounded-xl font-bold text-sm">Start Exploring</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4 p-6 bg-skyblue/10 rounded-2xl border border-skyblue/20">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-skyblue shrink-0 border border-skyblue/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-xs text-brandblue font-medium leading-relaxed">
                <span class="font-bold">Need help with your booking?</span><br>
                For urgent rescheduling or special requests, please contact our support team at <a href="#" class="underline font-bold">support@nusajaya.com</a>.
            </p>
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
            }, 10);
        } else {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
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
