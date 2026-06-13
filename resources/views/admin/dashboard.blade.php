@extends('layouts.admin')

@section('content')
<div class="space-y-8 print:space-y-4">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-[#0B2447]  tracking-tight italic uppercase">Dashboard ✨</h2>
            <p class="text-slate-500  font-medium mt-2 italic text-lg">Analysis & Performance Overview</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-4 no-print">
            <div class="relative" x-data="{ exportOpen: false }">
                <button @click="exportOpen = !exportOpen" class="px-6 py-4 bg-white text-slate-700  font-black rounded-2xl border border-slate-100  shadow-sm hover:shadow-xl transition-all duration-300 flex items-center gap-3 group">
                    <i data-lucide="download" class="w-5 h-5"></i>
                    {{ __('Export Report') }}
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform"></i>
                </button>
                <div x-show="exportOpen" 
                     @click.away="exportOpen = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-50 py-2 z-50"
                     x-cloak>
                    <a href="{{ route('admin.dashboard.export', ['type' => 'csv']) }}" class="flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-sky-500 transition-colors">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-3 text-emerald-500"></i>
                        Excel (.CSV)
                    </a>
                    <button @click="exportOpen = false; window.print()" class="w-full flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-sky-500 transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4 mr-3 text-red-500"></i>
                        PDF (Print)
                    </button>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100  flex items-center space-x-4">
                <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center text-sky-500">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-500  uppercase tracking-widest leading-none mb-1">{{ __('Real-time') }}</p>
                    <div id="real-time-clock" class="text-xs font-black text-[#0B2447] ">00:00:00</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('real-time-clock').innerText = now.toLocaleTimeString('en-GB', timeOptions);
        }
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        updateClock();
        setInterval(updateClock, 1000);
    </script>

    <!-- Rescheduling Notifications -->
    @if(count($stats['rescheduled_bookings']) > 0)
        <div class="space-y-6 animate-in fade-in slide-in-from-top-6 duration-700">
            <div class="flex items-center justify-between px-4">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-orange-500 animate-ping"></div>
                    <h3 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] italic flex items-center gap-3">
                        Urgent: Customer Rescheduling Requests
                        <span class="w-20 h-px bg-orange-200"></span>
                    </h3>
                </div>
                <span class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-orange-200 flex items-center gap-2 animate-bounce">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    {{ count($stats['rescheduled_bookings']) }} Action Required
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($stats['rescheduled_bookings'] as $rescheduled)
                    <div class="bg-white p-8 rounded-[2.5rem] border border-orange-100 shadow-2xl shadow-orange-500/5 relative overflow-hidden group hover:-translate-y-1 hover:shadow-orange-500/10 transition-all duration-500 cursor-pointer" onclick="window.location.href='{{ route('admin.bookings.show', $rescheduled) }}'">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-5 mb-8">
                                <div class="w-14 h-14 bg-orange-500 text-white rounded-[1.2rem] flex items-center justify-center shadow-xl shadow-orange-200 rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                    <i data-lucide="calendar-days" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-black text-[#0B2447]  uppercase italic leading-tight">{{ $rescheduled->user->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-300  uppercase tracking-widest mt-1">{{ $rescheduled->order_number }}</p>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-slate-50 rounded-[1.5rem] mb-8 border border-slate-100/50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">New Travel Date</p>
                                        <p class="text-sm font-black text-orange-600">{{ date('d M Y', strtotime($rescheduled->travel_date)) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Updated On</p>
                                        <p class="text-[10px] font-bold text-slate-500">{{ $rescheduled->rescheduled_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="flex-1 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-orange-500 transition-all duration-500 shadow-lg shadow-slate-900/10">
                                    Review Booking
                                </div>
                                @if(auth()->user()->role !== 'superadmin')
                                <form action="{{ route('admin.bookings.reschedule-noticed', $rescheduled) }}" method="POST" class="shrink-0 relative z-20" onclick="event.stopPropagation()">
                                    @csrf
                                    <button type="submit" class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all duration-500 shadow-sm group/btn" title="Mark as Seen">
                                        <i data-lucide="check-check" class="w-6 h-6 group-hover/btn:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Quick Stats & Balance Details Row -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Balance Card (Premium) -->
        <div class="lg:col-span-1 bg-gradient-to-br from-sky-500 to-sky-800 p-8 rounded-[3rem] shadow-2xl shadow-blue-200 relative overflow-hidden group min-h-[350px] animate-fade-in-up">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <p class="text-sky-100 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Current Balance</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter italic">
                        <span class="text-xl align-top mr-1 opacity-60">IDR</span>{{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </h3>
                </div>
                
                <div class="space-y-4 w-full">
                    <div class="flex items-center gap-3 p-4 bg-emerald-500/20 backdrop-blur-md border border-emerald-500/20 rounded-2xl">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-emerald-100 uppercase tracking-widest leading-none mb-1">Funds Secured</p>
                            <p class="text-xs font-bold text-emerald-200">Processed by Midtrans</p>
                        </div>
                    </div>

                    <div class="p-5 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 relative overflow-hidden group/card hover:bg-white/15 transition-all cursor-pointer" onclick="window.location.href='{{ route('admin.bookings.index', ['status' => 'paid']) }}'">
                        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-white/10 to-transparent"></div>
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-[9px] font-black text-sky-100 uppercase tracking-[0.2em]">Previous Month</p>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-sky-200/50 group-hover/card:translate-x-1 transition-transform"></i>
                        </div>
                        <p class="text-2xl font-black text-white italic tracking-tight">IDR {{ number_format($stats['last_month_revenue'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="lg:col-span-2 bg-white dark:bg-[#0F2038] p-8 rounded-[3rem] border border-slate-100 dark:border-[#1E3A5F] shadow-sm relative group animate-fade-in-up animation-delay-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-[#0B2447] dark:text-white uppercase italic tracking-tight">Booking Trends</h3>
                    <p class="text-slate-500 dark:text-slate-300 text-[10px] font-black uppercase tracking-widest mt-1">Monthly Tour Package Requests</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-widest">Tour Packages</span>
                    </div>
                </div>
            </div>
            
            <div class="h-[200px]">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-[#0F2038] p-6 rounded-3xl border border-slate-100 dark:border-[#1E3A5F] shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer animate-fade-in-up animation-delay-200" onclick="window.location.href='{{ route('admin.bookings.index') }}'">
                <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-500 group-hover:bg-sky-500 group-hover:text-white transition-all">
                    <i data-lucide="ticket" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-widest">Total Orders</p>
                    <h4 class="text-2xl font-black text-[#0B2447] dark:text-white">{{ $stats['total_bookings'] }}</h4>
                </div>
            </div>
            <div class="bg-white dark:bg-[#0F2038] p-6 rounded-3xl border border-slate-100 dark:border-[#1E3A5F] shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer animate-fade-in-up animation-delay-300" onclick="window.location.href='{{ route('admin.bookings.index', ['status' => 'pending']) }}'">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 group-hover:bg-orange-500 group-hover:text-white transition-all">
                    <i data-lucide="clock" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-widest">Waiting List</p>
                    <h4 class="text-2xl font-black text-[#0B2447] dark:text-white">{{ $stats['pending_bookings'] }}</h4>
                </div>
            </div>
            <div class="bg-white dark:bg-[#0F2038] p-6 rounded-3xl border border-slate-100 dark:border-[#1E3A5F] shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer animate-fade-in-up animation-delay-400" onclick="window.location.href='{{ route('admin.armadas.index') }}'">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i data-lucide="bus" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-widest">Active Fleets</p>
                    <h4 class="text-2xl font-black text-[#0B2447] dark:text-white">{{ $stats['available_armada'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-[#0F2038] rounded-[3rem] border border-slate-100 dark:border-[#1E3A5F] shadow-sm overflow-hidden animate-fade-in-up animation-delay-200">
            <div class="p-10 border-b border-slate-50 dark:border-[#1E3A5F] flex items-center justify-between">
                <h3 class="text-2xl font-black text-[#0B2447] dark:text-white italic uppercase tracking-tighter">{{ __('Recent Activity') }}</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-sky-500 dark:text-[#38BDF8] text-xs font-black uppercase tracking-widest">See More</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-[#152C4C]/30">
                            <th class="px-10 py-6 text-left text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-[0.2em]">Customer</th>
                            <th class="px-6 py-6 text-left text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-[0.2em]">Service</th>
                            <th class="px-10 py-6 text-right text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-[#1E3A5F]">
                        @forelse($stats['recent_bookings'] as $booking)
                        <tr class="hover:bg-slate-50/30 dark:hover:bg-[#152C4C]/20 transition-colors cursor-pointer group" onclick="window.location.href='{{ route('admin.bookings.show', $booking) }}'">
                            <td class="px-10 py-6">
                                <p class="text-sm font-black text-[#0B2447] dark:text-white">{{ $booking->user->name }}</p>
                                <p class="text-[9px] font-bold text-slate-500 dark:text-slate-400 italic">{{ $booking->order_number }}</p>
                            </td>
                            <td class="px-6 py-6 text-sm font-bold text-slate-600 dark:text-slate-300">{{ $booking->service_name }}</td>
                            <td class="px-10 py-6 text-right">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $booking->status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400' : 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-10 py-12 text-center text-slate-500  font-bold italic">No recent tour bookings.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-[#0F2038] rounded-[3rem] p-10 text-[#0B2447] dark:text-white relative overflow-hidden group shadow-xl border border-slate-100 dark:border-[#1E3A5F] animate-fade-in-up animation-delay-300">
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-skyblue/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <h4 class="text-xl font-black italic uppercase tracking-tighter mb-8">System Analysis</h4>
            <div class="space-y-10">
                <div>
                    <div class="flex justify-between mb-4">
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-[0.2em]">Package Popularity</span>
                        <span class="text-xs font-black text-skyblue">85%</span>
                    </div>
                    <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                        <div class="bg-skyblue h-full rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-4">
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-300 uppercase tracking-[0.2em]">Customer Satisfaction</span>
                        <span class="text-xs font-black text-emerald-400">98%</span>
                    </div>
                    <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-400 h-full rounded-full" style="width: 98%"></div>
                    </div>
                </div>
                
                <div class="pt-8 border-t border-slate-100 dark:border-[#1E3A5F] grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 dark:bg-[#1A365D] p-4 rounded-2xl border border-slate-100 dark:border-[#1E3A5F]">
                        <p class="text-[8px] font-black text-slate-500 dark:text-slate-300 uppercase mb-1">Active Tours</p>
                        <p class="text-xl font-black text-[#0B2447] dark:text-white italic">{{ $stats['total_tours'] }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-[#1A365D] p-4 rounded-2xl border border-slate-100 dark:border-[#1E3A5F]">
                        <p class="text-[8px] font-black text-slate-500 dark:text-slate-300 uppercase mb-1">Database</p>
                        <p class="text-xl font-black text-[#0B2447] dark:text-white italic">Stable</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingsChart').getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($stats['chart_labels']),
            datasets: [
                {
                    label: 'Tour Bookings',
                    data: @json($stats['tour_chart_data']),
                    borderColor: '#38BDF8',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#38BDF8'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { 
                        display: true,
                        color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        color: textColor,
                        font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: textColor,
                        font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endpush

<style>
    @media print {
        .no-print { display: none !important; }
        .print\:space-y-4 { margin-top: 0 !important; }
        body { background-color: white !important; }
        .shadow-sm, .shadow-xl, .shadow-2xl { box-shadow: none !important; }
        .rounded-\[3rem\], .rounded-\[2\.5rem\] { border-radius: 1rem !important; }
    }
</style>
@endsection
