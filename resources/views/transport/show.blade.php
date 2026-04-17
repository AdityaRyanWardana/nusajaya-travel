@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-10 pb-20">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <!-- Hero Image -->
        <div class="relative h-[400px]">
            <img src="{{ $transport['image'] }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-brandblue/80 to-transparent"></div>
            <div class="absolute bottom-10 left-10 text-white">
                <span class="bg-skyblue text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Premium Fleet</span>
                <h1 class="text-4xl font-black tracking-tight italic">{{ $transport['name'] }}</h1>
            </div>
        </div>

        <div class="p-10 grid md:grid-cols-3 gap-10">
            <!-- Left: Description -->
            <div class="md:col-span-2">
                <h2 class="text-xl font-bold text-brandblue mb-4">Description</h2>
                <p class="text-slate-600 leading-relaxed mb-8">
                    {{ $transport['description'] }}
                    <br><br>
                    Nikmati perjalanan yang nyaman dan aman di Batam dengan armada bus terbaru kami. Kendaraan kami selalu dalam kondisi prima dan dioperasikan oleh diver yang berpengalaman.
                </p>
                
                <h3 class="text-lg font-bold text-brandblue mb-4">Fasilitas Utama</h3>
                <ul class="grid grid-cols-2 gap-4 mb-8">
                    <li class="flex items-center gap-3 text-sm text-slate-500">
                        <svg class="w-5 h-5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Full AC
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-500">
                        <svg class="w-5 h-5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Multimedia (TV/Audio)
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-500">
                        <svg class="w-5 h-5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Reclining Seats
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-500">
                        <svg class="w-5 h-5 text-skyblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        USB Charger
                    </li>
                </ul>
            </div>

            <!-- Right: Booking Menu -->
            <div class="md:col-span-1">
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 sticky top-24">
                    <p class="text-[10px] text-slate-400 font-black tracking-widest uppercase mb-1">PER DAY RATE</p>
                    <p class="text-2xl font-black text-brandblue italic mb-6">IDR {{ number_format($transport['price'], 0, ',', '.') }}</p>
                    
                    @if(session('success'))
                        <div class="bg-green-50 text-green-600 p-3 rounded-lg text-xs font-bold mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @auth
                    <form action="{{ route('transport.book', $transport['slug']) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Travel Date</label>
                            <input type="date" name="travel_date" required class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-brandblue">
                        </div>
                        <button type="submit" class="w-full bg-brandblue hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-brandblue/20">
                            Book Now
                        </button>
                    </form>
                    @else
                    <div class="space-y-4">
                        <p class="text-xs text-slate-500 text-center mb-4">Silakan login terlebih dahulu untuk melakukan pemesanan kendaraan.</p>
                        <a href="{{ route('login') }}" class="w-full bg-brandblue hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-brandblue/20 text-center block">
                            Login to Book
                        </a>
                        <p class="text-[10px] text-center text-slate-400">Belum punya akun? <a href="{{ route('register') }}" class="text-brandblue font-bold">Daftar sekarang</a></p>
                    </div>
                    @endauth

                    <p class="text-[9px] text-slate-400 text-center mt-6 uppercase font-bold tracking-widest italic">All-in service includes fuel & driver</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
