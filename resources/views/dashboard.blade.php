@extends('layouts.app')

@section('content')

    <!-- Welcome Section -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Wisatawan' }}! 👋</h1>
            <p class="text-slate-500 font-medium">Siap untuk petualangan selanjutnya hari ini?</p>
        </div>
        <div>
            <button class="bg-primary hover:bg-sky-600 text-white font-semibold px-6 py-2.5 rounded-full shadow-lg shadow-sky-500/30 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Pesan Sekarang
            </button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center text-primary shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Perjalanan Aktif & Mendatang</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-slate-800">2</h3>
                    <span class="text-xs font-semibold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-md">Bulan Ini</span>
                </div>
            </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-secondary shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Total Pemesanan Anda</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-slate-800">12</h3>
                    <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">Sepanjang Waktu</span>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-gradient-to-br from-dark to-slate-800 p-6 rounded-3xl shadow-lg border border-slate-700 flex items-center gap-5 text-white justify-between">
            <div>
                <p class="text-sm font-medium text-slate-300 mb-1">Loyalty Points</p>
                <h3 class="text-2xl font-bold text-white mb-1">2,450 <span class="text-sm font-normal text-slate-400">Pts</span></h3>
                <p class="text-xs text-amber-400 font-semibold flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path></svg>
                    Loyalty Status
                </p>
            </div>
            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Panel: Upcoming Trip & Recent Bookings -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Next Trip Card -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 group relative">
                <div class="h-48 md:h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/40 to-transparent"></div>
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Mendatang
                    </div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <p class="text-sky-300 font-bold text-xs uppercase tracking-wider mb-2">Paket Tour</p>
                        <h2 class="text-3xl font-bold text-white mb-2">Eksplorasi VVIP Nusa Penida</h2>
                        <div class="flex items-center gap-6 text-sm text-slate-200 font-medium">
                            <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> 24 Oct 2026</span>
                            <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 3 Hari 2 Malam</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white flex justify-between items-center">
                    <div>
                        <p class="text-sm text-slate-500 font-medium mb-1">Kode Booking</p>
                        <p class="text-lg font-bold text-slate-800">#BK-NP7782X</p>
                    </div>
                    <button class="px-5 py-2.5 rounded-xl border-2 border-slate-200 text-slate-700 font-bold text-sm hover:border-primary hover:text-primary transition bg-slate-50">Lihat Itinerary</button>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-slate-800">Riwayat Pemesanan</h2>
                    <a href="#" class="text-sm font-semibold text-primary hover:text-sky-600">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3 pl-2">Layanan</th>
                                <th class="pb-3">Tanggal</th>
                                <th class="pb-3">Total</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100">
                            <!-- Row 1 -->
                            <tr class="group hover:bg-slate-50 transition">
                                <td class="py-4 pl-2 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">Tour Nusa Penida</p>
                                        <p class="text-xs text-slate-500 font-medium">BKN-NP7782X</p>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600 font-medium">24 Oct 2026</td>
                                <td class="py-4 font-bold text-slate-800">Rp 5.000.000</td>
                                <td class="py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        Paid
                                    </span>
                                </td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr class="group hover:bg-slate-50 transition">
                                <td class="py-4 pl-2 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-secondary">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">Sewa Innova Zenix</p>
                                        <p class="text-xs text-slate-500 font-medium">BKN-TR4419B</p>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600 font-medium">05 Nov 2026</td>
                                <td class="py-4 font-bold text-slate-800">Rp 1.200.000</td>
                                <td class="py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                        Pending
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Panel: Profile Completion & Promo -->
        <div class="space-y-8">
            <!-- Promo Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-xl group-hover:scale-150 transition duration-700"></div>
                <h3 class="text-xl font-bold mb-2 relative z-10">Promo Spesial Liburan! 🌴</h3>
                <p class="text-indigo-100 text-sm mb-5 relative z-10 font-medium">Dapatkan diskon 15% untuk penyewaan bus ukuran sedang bulan ini.</p>
                <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl p-3 flex justify-between items-center relative z-10">
                    <span class="font-mono font-bold tracking-widest">NUSAJAYA15</span>
                    <button class="text-xs font-bold bg-white text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition drop-shadow-sm">Copy</button>
                </div>
            </div>

            <!-- Suggested Destinies -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Mungkin Anda Suka</h3>
                <div class="space-y-4">
                    <!-- Suggestion Item -->
                    <a href="#" class="flex items-center gap-4 group">
                        <img src="https://images.unsplash.com/photo-1601058497548-f247dfe349d6?q=80&w=2070&auto=format&fit=crop" class="w-16 h-16 rounded-2xl object-cover">
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-primary transition">Open Trip Bromo VIP</p>
                            <p class="text-xs text-slate-500 font-medium mb-1">Mulai Rp 900Ribu</p>
                            <div class="flex items-center gap-1 text-amber-400 text-xs font-bold">
                                ★ 5.0
                            </div>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-4 group">
                        <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=2071&auto=format&fit=crop" class="w-16 h-16 rounded-2xl object-cover">
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-primary transition">Tour Budaya Jogja</p>
                            <p class="text-xs text-slate-500 font-medium mb-1">Mulai Rp 1.8Juta</p>
                            <div class="flex items-center gap-1 text-amber-400 text-xs font-bold">
                                ★ 4.8
                            </div>
                        </div>
                    </a>
                </div>
                <button class="w-full mt-6 py-2.5 rounded-xl bg-slate-50 text-slate-600 font-bold text-sm hover:bg-slate-100 transition border border-slate-200">Jelajahi Lainnya</button>
            </div>
            
        </div>
    </div>

@endsection
