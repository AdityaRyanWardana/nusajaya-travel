@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-20">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] mb-2">Resource Management</p>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight uppercase italic leading-none">{{ __('Fleet Scheduling') }}</h2>
            <p class="text-slate-400 font-medium mt-2">{{ __('Real-time availability tracking for transport and tour packages.') }}</p>
        </div>

        <div class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Ready
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Booked
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-red-500"></span> Maintenance
            </div>
        </div>
    </div>

    {{-- Scheduling Grid --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 border-b border-slate-100 sticky left-0 bg-white z-10 w-64 shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)]">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Fleet Type') }}</span>
                        </th>
                        @foreach($dates as $date)
                            <th class="p-6 border-b border-slate-100 text-center min-w-[120px]">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ \Carbon\Carbon::parse($date)->format('D') }}</p>
                                <p class="text-base font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($armadas as $armada)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="p-6 border-b border-slate-100 sticky left-0 bg-white group-hover:bg-slate-50/30 z-10 transition-colors shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)]">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                        <i data-lucide="bus" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-slate-800 leading-tight">{{ $armada->name }}</h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $armada->capacity }} {{ __('Seats') }}</p>
                                    </div>
                                </div>
                            </td>
                            @foreach($dates as $date)
                                @php
                                    $data = $scheduleData[$date][$armada->id];
                                    $statusColor = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                    if ($data['ready'] == 0) {
                                        $statusColor = 'bg-red-50 text-red-600 border-red-100';
                                    } elseif ($data['ready'] <= 2) {
                                        $statusColor = 'bg-amber-50 text-amber-600 border-amber-100';
                                    }
                                @endphp
                                <td class="p-3 border-b border-slate-100">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-full px-3 py-2.5 rounded-2xl border {{ $statusColor }} text-center transition-all hover:scale-105 group/cell relative">
                                            <p class="text-[10px] font-black leading-none">{{ $data['ready'] }} Ready</p>
                                            
                                            <!-- Tooltip on Hover -->
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-32 bg-slate-900 text-white p-3 rounded-2xl text-[9px] opacity-0 invisible group-hover/cell:opacity-100 group-hover/cell:visible transition-all z-50 pointer-events-none shadow-2xl">
                                                <div class="space-y-1.5">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-400">Total:</span>
                                                        <span class="font-bold">{{ $data['total'] }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-400">Booked:</span>
                                                        <span class="font-bold text-blue-400">{{ $data['booked'] }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-400">Maint:</span>
                                                        <span class="font-bold text-red-400">{{ $data['maintenance'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-slate-900"></div>
                                            </div>
                                        </div>
                                        
                                        @if($data['booked'] > 0)
                                            <div class="flex gap-1">
                                                @for($i = 0; $i < min($data['booked'], 3); $i++)
                                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                                @endfor
                                                @if($data['booked'] > 3)
                                                    <span class="text-[7px] font-black text-blue-400">+{{ $data['booked'] - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <i data-lucide="zap" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-1">Auto Optimization</h5>
                <p class="text-xs text-slate-400 font-medium leading-relaxed italic">System automatically calculates availability based on confirmed and pending bookings for each fleet type.</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 shadow-sm shrink-0">
                <i data-lucide="calendar" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-1">Dynamic View</h5>
                <p class="text-xs text-slate-400 font-medium leading-relaxed italic">Showing availability for the next 14 days. Hover over cells to see detailed breakdown of fleet status.</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 shadow-sm shrink-0">
                <i data-lucide="wrench" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-1">Maintenance Sync</h5>
                <p class="text-xs text-slate-400 font-medium leading-relaxed italic">Maintenance units are automatically deducted from the total available pool to ensure no overbooking.</p>
            </div>
        </div>
    </div>
</div>
@endsection
