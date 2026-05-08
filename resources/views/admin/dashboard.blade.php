@extends('layouts.admin')

@section('content')
<div class="space-y-8 print:space-y-4">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Dashboard ✨</h2>
            <p class="text-slate-400 font-medium mt-2 italic text-lg">Analysis & Performance Overview</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-4 no-print">
            <div class="relative group">
                <button class="px-6 py-4 bg-white text-slate-700 font-black rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center gap-3">
                    <i data-lucide="download" class="w-5 h-5"></i>
                    {{ __('Export Report') }}
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform"></i>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-50 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <a href="{{ route('admin.dashboard.export', ['type' => 'csv']) }}" class="flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-3 text-emerald-500"></i>
                        Excel (.CSV)
                    </a>
                    <button onclick="window.print()" class="w-full flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4 mr-3 text-red-500"></i>
                        PDF (Print)
                    </button>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ __('Real-time') }}</p>
                    <div id="real-time-clock" class="text-xs font-black text-slate-800">00:00:00</div>
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
                <span class="px-4 py-1.5 bg-orange-500 text-white rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg shadow-orange-200">
                    {{ count($stats['rescheduled_bookings']) }} Action Required
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($stats['rescheduled_bookings'] as $rescheduled)
                    <div class="bg-white p-8 rounded-[2.5rem] border border-orange-100 shadow-2xl shadow-orange-500/5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-5 mb-8">
                                <div class="w-14 h-14 bg-orange-500 text-white rounded-[1.2rem] flex items-center justify-center shadow-xl shadow-orange-200 rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                    <i data-lucide="calendar-days" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-black text-slate-800 uppercase italic leading-tight">{{ $rescheduled->user->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mt-1">{{ $rescheduled->order_number }}</p>
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
                                <a href="{{ route('admin.bookings.show', $rescheduled) }}" class="flex-1 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-orange-500 transition-all duration-500 shadow-lg shadow-slate-900/10">
                                    Review Booking
                                </a>
                                <form action="{{ route('admin.bookings.reschedule-noticed', $rescheduled) }}" method="POST" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all duration-500 shadow-sm group/btn" title="Mark as Seen">
                                        <i data-lucide="check-check" class="w-6 h-6 group-hover/btn:scale-110 transition-transform"></i>
                                    </button>
                                </form>
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
        <div class="lg:col-span-1 bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-[3rem] shadow-2xl shadow-blue-200 relative overflow-hidden group min-h-[350px]">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <p class="text-blue-100 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Current Balance</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter italic">
                        <span class="text-xl align-top mr-1 opacity-60">IDR</span>{{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10">
                        <p class="text-[8px] font-black text-blue-100 uppercase tracking-widest mb-1">Last Month</p>
                        <p class="text-lg font-black text-white italic">IDR {{ number_format($stats['last_month_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-1 p-4 bg-emerald-500/20 backdrop-blur-md rounded-2xl border border-emerald-500/20">
                            <p class="text-[8px] font-black text-emerald-100 uppercase tracking-widest mb-1">Growth</p>
                            <p class="text-sm font-black text-white">+{{ $stats['booking_growth'] }}%</p>
                        </div>
                        <div class="flex-1 p-4 bg-orange-500/20 backdrop-blur-md rounded-2xl border border-orange-500/20">
                            <p class="text-[8px] font-black text-orange-100 uppercase tracking-widest mb-1">Pending</p>
                            <p class="text-sm font-black text-white">IDR {{ number_format($stats['pending_revenue'] / 1000, 0) }}k</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative group">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 uppercase italic tracking-tight">Booking Statistics</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">Tour vs Transport Bookings</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-skyblue"></span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fleet</span>
                    </div>
                </div>
            </div>
            
            <div class="h-[200px]">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer" onclick="window.location.href='{{ route('admin.bookings.index') }}'">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i data-lucide="ticket" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Orders</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $stats['total_bookings'] }}</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer" onclick="window.location.href='{{ route('admin.bookings.index', ['status' => 'pending']) }}'">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 group-hover:bg-orange-500 group-hover:text-white transition-all">
                    <i data-lucide="clock" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Waiting List</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $stats['pending_bookings'] }}</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all cursor-pointer" onclick="window.location.href='{{ route('admin.armadas.index') }}'">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i data-lucide="bus" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Fleets</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $stats['available_armada'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-2xl font-black text-slate-800 italic uppercase tracking-tighter">{{ __('Recent Activity') }}</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 text-xs font-black uppercase tracking-widest">See More</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Customer</th>
                            <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Service</th>
                            <th class="px-10 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse(\App\Models\Booking::with('user')->latest()->take(5)->get() as $booking)
                        <tr class="hover:bg-slate-50/30 transition-colors cursor-pointer group" onclick="window.location.href='{{ route('admin.bookings.show', $booking) }}'">
                            <td class="px-10 py-6">
                                <p class="text-sm font-black text-slate-800">{{ $booking->user->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 italic">NJ-{{ $booking->id }}</p>
                            </td>
                            <td class="px-6 py-6 text-sm font-bold text-slate-600">{{ $booking->service_name }}</td>
                            <td class="px-10 py-6 text-right">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-[#0B2447] rounded-[3rem] p-10 text-white relative overflow-hidden group shadow-2xl">
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-skyblue/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <h4 class="text-xl font-black italic uppercase tracking-tighter mb-8">System Analysis</h4>
            <div class="space-y-10">
                <div>
                    <div class="flex justify-between mb-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Fleet Utilization</span>
                        <span class="text-xs font-black text-skyblue">{{ round(($stats['available_armada'] / max($stats['total_armada'], 1)) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        <div class="bg-skyblue h-full rounded-full" style="width: {{ ($stats['available_armada'] / max($stats['total_armada'], 1)) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Booking Success Rate</span>
                        <span class="text-xs font-black text-emerald-400">94%</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-400 h-full rounded-full" style="width: 94%"></div>
                    </div>
                </div>
                
                <div class="pt-8 border-t border-white/5 grid grid-cols-2 gap-4">
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                        <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Active Tours</p>
                        <p class="text-xl font-black text-white italic">{{ $stats['total_tours'] }}</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                        <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Database</p>
                        <p class="text-xl font-black text-white italic">Stable</p>
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
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($stats['chart_labels']),
            datasets: [
                {
                    label: 'Tour Bookings',
                    data: @json($stats['tour_chart_data']),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#2563eb'
                },
                {
                    label: 'Transport Bookings',
                    data: @json($stats['transport_chart_data']),
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#0ea5e9'
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
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
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
