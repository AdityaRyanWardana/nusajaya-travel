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
                
                <div class="space-y-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-brandblue">{{ $order->service_name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <span class="text-xs font-bold text-slate-600 tracking-tight">{{ $order->guests }} Person{{ $order->guests > 1 ? 's' : '' }}</span>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-50 space-y-3">
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
            <div class="bg-white rounded-3xl p-10 border border-slate-100 shadow-2xl overflow-hidden relative">
                <div x-show="step === 'select'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-10">Select Payment Method</h3>
                    
                    <div class="space-y-4 mb-10">
                        <!-- Virtual Account -->
                        <label class="flex items-center justify-between p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300" 
                               :class="method === 'va' ? 'border-skyblue bg-skyblue/5' : 'border-slate-50 hover:border-slate-200'">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_type" value="va" x-model="method" class="sr-only">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition group-hover:scale-110">
                                    <svg class="w-5 h-5 text-brandblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-brandblue uppercase tracking-widest">Virtual Account</p>
                                    <p class="text-[10px] text-slate-400 font-medium">BCA, Mandiri, BNI, BRI</p>
                                </div>
                            </div>
                            <div :class="method === 'va' ? 'text-skyblue' : 'text-slate-200'">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="flex items-center justify-between p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300" 
                               :class="method === 'wallet' ? 'border-skyblue bg-skyblue/5' : 'border-slate-50 hover:border-slate-200'">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_type" value="wallet" x-model="method" class="sr-only">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition group-hover:scale-110">
                                    <svg class="w-5 h-5 text-brandblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-brandblue uppercase tracking-widest">E-Wallet</p>
                                    <p class="text-[10px] text-slate-400 font-medium">OVO, GoPay, Dana, LinkAja</p>
                                </div>
                            </div>
                            <div :class="method === 'wallet' ? 'text-skyblue' : 'text-slate-200'">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>

                        <!-- QRIS -->
                        <label class="flex items-center justify-between p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300" 
                               :class="method === 'qris' ? 'border-skyblue bg-skyblue/5' : 'border-slate-50 hover:border-slate-200'">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_type" value="qris" x-model="method" class="sr-only">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition group-hover:scale-110">
                                    <svg class="w-5 h-5 text-brandblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-brandblue uppercase tracking-widest">QRIS</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Scan using any payment app</p>
                                </div>
                            </div>
                            <div :class="method === 'qris' ? 'text-skyblue' : 'text-slate-200'">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                    </div>

                    <button @click="step = 'generate'" type="button" class="w-full py-5 bg-brandblue text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-brandblue/30 hover:bg-slate-800 transition transform hover:-translate-y-1">
                        Continue Payment
                    </button>
                </div>

                <!-- Generated Payment Info -->
                <div x-show="step === 'generate'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <button @click="step = 'select'" type="button" class="mb-8 flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-brandblue transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Change Method
                    </button>

                    <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-8">Payment Instructions</h3>
                    
                    <!-- VA Details -->
                    <div x-show="method === 'va'" class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Virtual Account Number</p>
                            <p class="text-3xl font-black text-brandblue tracking-widest italic">8473 0000 00{{ $order->id }}</p>
                            <p class="text-[10px] text-skyblue font-bold mt-2 uppercase">BCA Virtual Account</p>
                        </div>
                        <ul class="text-[10px] space-y-3 text-slate-500 font-medium">
                            <li class="flex gap-3">
                                <span class="w-5 h-5 rounded-full bg-brandblue text-white flex items-center justify-center shrink-0">1</span>
                                <span>Pilih menu <span class="font-bold text-brandblue">Transfer > Virtual Account</span> di ATM atau M-Banking Anda.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="w-5 h-5 rounded-full bg-brandblue text-white flex items-center justify-center shrink-0">2</span>
                                <span>Masukkan nomor virtual account yang tertera di atas.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="w-5 h-5 rounded-full bg-brandblue text-white flex items-center justify-center shrink-0">3</span>
                                <span>Periksa nominal pembayaran dan konfirmasi transaksi.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- E-Wallet Details -->
                    <div x-show="method === 'wallet'" class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Confirm in App</p>
                            <div class="flex justify-center gap-4 mb-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" class="h-6 grayscale opacity-50">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" class="h-6 grayscale opacity-50">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" class="h-6 grayscale opacity-50">
                            </div>
                            <p class="text-xs font-bold text-brandblue">A payment notification will be sent to your registered phone number.</p>
                        </div>
                        <p class="text-[10px] text-center text-slate-400 font-medium leading-relaxed italic">Make sure you have enough balance in your digital wallet to complete this transaction.</p>
                    </div>

                    <!-- QRIS Details -->
                    <div x-show="method === 'qris'" class="space-y-6 text-center">
                        <div class="bg-white p-4 inline-block rounded-3xl shadow-xl border border-slate-100">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" class="w-48 h-48 opacity-80 mix-blend-multiply">
                        </div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest italic">Scan QR with your payment app</p>
                    </div>

                    <form action="{{ route('orders.pay', $order->id) }}" method="POST" class="mt-10">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-emerald-500 text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] shadow-2xl shadow-emerald-500/30 hover:bg-emerald-600 transition transform hover:-translate-y-1">
                            I Have Paid
                        </button>
                    </form>
                </div>

                <p class="text-center mt-6 text-[10px] text-slate-400 font-medium italic">
                    By clicking the button above, you agree to our <a href="#" class="underline">Terms & Conditions</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
