@extends('layouts.public')

@section('content')
<section class="max-w-5xl mx-auto px-8 py-20 w-full" x-data="{ method: 'va', step: 'select' }">
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-black text-brandblue uppercase tracking-tight mb-4" x-text="step === 'select' ? 'Secure Checkout' : 'Complete Payment'"></h1>
        <p class="text-slate-500 font-medium" x-text="step === 'select' ? 'Please complete your payment to confirm your booking.' : 'Follow the instructions below to complete your transaction.'"></p>
    </div>

    <div class="grid md:grid-cols-5 gap-10">
        <!-- Order Summary (Left) -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl overflow-hidden relative">
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-brandblue/5 rounded-full blur-2xl"></div>
                <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-8 flex items-center gap-2">
                    <svg class="w-4 h-4 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Booking Summary
                </h3>
                
                <div class="space-y-4">
                    <!-- Order ID & Service Name -->
                    <div class="p-4 bg-brandblue rounded-2xl text-white">
                        <p class="text-[11px] font-black uppercase tracking-[0.2em] text-white/50 mb-1">Order ID</p>
                        <p class="text-xs font-black text-skyblue tracking-widest mb-3">{{ $order->order_number }}</p>
                        <p class="text-sm font-black leading-snug">{{ $order->service_name }}</p>
                    </div>

                    <!-- Detail Grid -->
                    <div class="space-y-3">
                        <!-- Kategori Sewa -->
                        @php
                            $serviceNameParts = explode(' - ', $order->service_name, 2);
                            $category = $serviceNameParts[1] ?? $order->service_name;
                        @endphp
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-7 h-7 bg-skyblue/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Rental Category') }}</p>
                                <p class="text-sm font-bold text-brandblue">{{ $category }}</p>
                            </div>
                        </div>

                        <!-- Pickup Point -->
                        @if($order->pickup_point)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Pickup Point') }}</p>
                                <p class="text-sm font-bold text-brandblue leading-relaxed">{{ $order->pickup_point }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Destination -->
                        @if($order->destination && $order->destination !== $order->service_name)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Destination') }}</p>
                                <p class="text-sm font-bold text-brandblue leading-relaxed">{{ $order->destination }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Travel Date -->
                        @if($order->travel_date)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Travel Date') }}</p>
                                <p class="text-sm font-bold text-brandblue">{{ \Carbon\Carbon::parse($order->travel_date)->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Pickup Time -->
                        @if($order->pickup_time)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ __('Pickup Time') }}</p>
                                <p class="text-sm font-bold text-brandblue">{{ $order->pickup_time }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Total -->
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400 font-medium">Subtotal</span>
                            <span class="text-slate-600 font-bold">IDR {{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400 font-medium">Taxes & Fees</span>
                            <span class="text-slate-600 font-bold">Included</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-brandblue/5">
                            <span class="text-sm font-black text-brandblue uppercase tracking-widest">Total Amount</span>
                            <span class="text-xl font-black text-brandblue">IDR {{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 flex gap-4 items-center">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <p class="text-[10px] text-emerald-700 font-bold leading-relaxed">Secure payment processed by Midtrans. Your data is encrypted and protected.</p>
            </div>
        </div>

        <!-- Payment Options (Right) -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-3xl p-10 border border-slate-100 shadow-2xl overflow-hidden relative text-center">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-brandblue/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-brandblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-brandblue mb-2">Complete Your Payment</h3>
                    <p class="text-slate-500 font-medium text-sm">Click the button below to proceed with the payment securely via Midtrans.</p>
                </div>

                @if($snapToken)
                <button id="pay-button" type="button" class="w-full py-5 bg-brandblue text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-brandblue/30 hover:bg-slate-800 transition transform hover:-translate-y-1">
                    Pay Now
                </button>
                @else
                <div class="p-4 bg-red-50 text-red-600 rounded-xl text-sm font-bold">
                    Failed to get payment token. Please try again or contact support.
                </div>
                @endif

                <p class="text-center mt-6 text-xs text-slate-400 font-medium italic">
                    By proceeding, you agree to our <a href="#" class="underline">Terms & Conditions</a>.
                </p>
            </div>
        </div>
    </div>
</section>

@if($snapToken)
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    // Show loading overlay
    function showLoadingOverlay(message) {
        const overlay = document.getElementById('status-overlay');
        const msg = document.getElementById('status-overlay-msg');
        if (overlay) {
            overlay.classList.remove('hidden');
            if (msg && message) msg.textContent = message;
        }
    }

    // Poll payment status from server and redirect when confirmed
    function pollPaymentStatus(orderId, token, maxAttempts) {
        let attempts = 0;
        const interval = setInterval(function() {
            attempts++;
            fetch('{{ route('orders.status', $order->id) }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'paid') {
                    clearInterval(interval);
                    window.location.href = '{{ route('orders.my') }}';
                } else if (data.status === 'cancelled') {
                    clearInterval(interval);
                    window.location.href = '{{ route('orders.my') }}';
                }
            })
            .catch(() => {});

            if (attempts >= maxAttempts) {
                clearInterval(interval);
                window.location.href = '{{ route('orders.my') }}';
            }
        }, 3000); // Poll every 3 seconds
    }

    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                showLoadingOverlay('Memverifikasi pembayaran, harap tunggu...');

                // Immediately submit to backend
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('orders.pay', $order->id) }}';

                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                let paymentType = document.createElement('input');
                paymentType.type = 'hidden';
                paymentType.name = 'payment_type';
                paymentType.value = result.payment_type || 'midtrans';
                form.appendChild(paymentType);

                let midtransOrderId = document.createElement('input');
                midtransOrderId.type = 'hidden';
                midtransOrderId.name = 'midtrans_order_id';
                midtransOrderId.value = result.order_id;
                form.appendChild(midtransOrderId);

                let status = document.createElement('input');
                status.type = 'hidden';
                status.name = 'status';
                status.value = 'paid';
                form.appendChild(status);

                document.body.appendChild(form);
                form.submit();
            },
            onPending: function(result) {
                showLoadingOverlay('Pembayaran pending, mengarahkan ke halaman pesanan...');
                // Start polling to catch when webhook arrives
                pollPaymentStatus({{ $order->id }}, '{{ $snapToken }}', 20);
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi atau hubungi support.');
            },
            onClose: function() {
                // User closed popup without completing payment - start polling briefly
                pollPaymentStatus({{ $order->id }}, '{{ $snapToken }}', 5);
            }
        });
    };
</script>

{{-- Loading / Status Overlay --}}
<div id="status-overlay" class="hidden fixed inset-0 z-[200] flex flex-col items-center justify-center bg-brandblue/95 backdrop-blur-md">
    <div class="text-center">
        <div class="w-20 h-20 border-4 border-white/20 border-t-skyblue rounded-full animate-spin mx-auto mb-6"></div>
        <p class="text-white font-black text-lg mb-2">Memproses Pembayaran</p>
        <p id="status-overlay-msg" class="text-white/60 text-sm font-medium">Harap tunggu sebentar...</p>
    </div>
</div>
@endif
@endsection
