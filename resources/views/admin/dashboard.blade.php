@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Hello, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
            <p class="text-slate-400 font-medium mt-2 italic text-lg">Here is your travel business performance overview today.</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-6">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                <i data-lucide="calendar" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">Today is</p>
                <p class="text-xl font-black text-slate-800">{{ date('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-500">
                    <i data-lucide="ticket" class="w-7 h-7"></i>
                </div>
                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">+12%</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Booked</p>
            <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ \App\Models\Booking::count() }}</h3>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-500">
                    <i data-lucide="clock" class="w-7 h-7"></i>
                </div>
                <span class="bg-orange-50 text-orange-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">Waiting</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Waiting List</p>
            <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ \App\Models\Booking::where('status', 'pending')->count() }}</h3>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-500">
                    <i data-lucide="check-circle" class="w-7 h-7"></i>
                </div>
                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">Success</span>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Completed</p>
            <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ \App\Models\Booking::where('status', 'completed')->count() }}</h3>
        </div>

        <div class="bg-blue-600 p-8 rounded-[2.5rem] shadow-2xl shadow-blue-200 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-white mb-8">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-100 uppercase tracking-[0.2em] mb-2">Active Admins</p>
                    <h3 class="text-4xl font-black text-white tracking-tighter">{{ \App\Models\User::whereIn('role', ['admin', 'superadmin'])->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings Table -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 italic uppercase tracking-tighter">Recent Booking Activity</h3>
                    <p class="text-slate-400 text-sm font-medium mt-1 italic">Real-time update from your customers</p>
                </div>
                <button class="px-6 py-3 text-xs font-black text-blue-600 bg-blue-50 rounded-2xl hover:bg-blue-600 hover:text-white transition-all duration-300 uppercase tracking-widest">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Customer Name</th>
                            <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Service Details</th>
                            <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Date</th>
                            <th class="px-10 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse(\App\Models\Booking::latest()->take(5)->get() as $booking)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-10 py-8">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black">
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $booking->user->name }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $booking->user->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-8">
                                <p class="text-sm font-black text-slate-700 leading-tight">{{ $booking->service_name }}</p>
                                <p class="text-[10px] font-bold text-blue-500 uppercase mt-1 tracking-wider">{{ $booking->type }}</p>
                            </td>
                            <td class="px-6 py-8 text-sm font-bold text-slate-500 italic">
                                {{ $booking->created_at->diffForHumans() }}
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $booking->status === 'pending' ? 'bg-orange-50 text-orange-600' : ($booking->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mb-4">
                                        <i data-lucide="inbox" class="w-10 h-10"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold italic">No booking data available yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Stats / Quick Actions -->
        <div class="space-y-8">
            <div class="bg-[#0B2447] rounded-[3rem] p-10 text-white relative overflow-hidden group shadow-2xl shadow-slate-200">
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-xl font-black italic uppercase tracking-tighter mb-2">Fleet Overview</h4>
                    <p class="text-slate-400 text-xs font-medium italic mb-8">Current active units in the system</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-300 uppercase tracking-widest">Available Units</span>
                            <span class="text-2xl font-black">{{ \App\Models\Armada::count() }}</span>
                        </div>
                        <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-400 h-full w-[85%] rounded-full shadow-lg shadow-blue-400/50"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-sm">
                <h4 class="text-xl font-black text-slate-800 italic uppercase tracking-tighter mb-8">System Status</h4>
                <div class="space-y-8">
                    <div class="flex items-center space-x-6">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Server Stable</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Uptime 99.9%</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                            <i data-lucide="database" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Database Synced</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Last backup: 1h ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
