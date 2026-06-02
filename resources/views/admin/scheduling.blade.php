@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-20" x-data="{ activeTab: 'tours' }">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
        <div>
            <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.3em] mb-2">Operations Center</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Resource Scheduling') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Real-time availability tracking for tour packages and transport fleet.') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-6">
            {{-- Tab Switcher --}}
            <div class="bg-slate-100 dark:bg-slate-800 p-1.5 rounded-[2rem] flex items-center shadow-inner">
                <button @click="activeTab = 'tours'" 
                        :class="activeTab === 'tours' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300'"
                        class="px-8 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                    <i data-lucide="map" class="w-4 h-4"></i>
                    Tours
                </button>
                <button @click="activeTab = 'fleets'" 
                        :class="activeTab === 'fleets' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300'"
                        class="px-8 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                    <i data-lucide="bus" class="w-4 h-4"></i>
                    Fleets
                </button>
            </div>

            {{-- Legend --}}
            <div class="flex items-center gap-4 bg-white dark:bg-slate-900 p-2 px-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <template x-if="activeTab === 'tours'">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-slate-300 dark:bg-slate-700"></span> Empty
                        </div>
                        <div class="flex items-center gap-2 text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Booked
                        </div>
                    </div>
                </template>
                <template x-if="activeTab === 'fleets'">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Ready
                        </div>
                        <div class="flex items-center gap-2 text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Full
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- Tour Scheduling Tab --}}
    <div x-show="activeTab === 'tours'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="p-6 border-b border-slate-100 dark:border-slate-800 sticky left-0 bg-white dark:bg-slate-900 z-10 w-80 shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)] dark:shadow-[10px_0_15px_-10px_rgba(0,0,0,0.5)]">
                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Tour Package') }}</span>
                        </th>
                        @foreach($dates as $date)
                            <th class="p-6 border-b border-slate-100 dark:border-slate-800 text-center min-w-[120px]">
                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-0.5">{{ \Carbon\Carbon::parse($date)->format('D') }}</p>
                                <p class="text-base font-black text-slate-800 dark:text-white leading-none">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($tours as $tour)
                        <tr class="group hover:bg-slate-50/30 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="p-6 border-b border-slate-100 dark:border-slate-800 sticky left-0 bg-white dark:bg-slate-900 group-hover:bg-slate-50/30 dark:group-hover:bg-slate-800/30 z-10 transition-colors shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)] dark:shadow-[10px_0_15px_-10px_rgba(0,0,0,0.5)]">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm shrink-0">
                                        <i data-lucide="map" class="w-6 h-6"></i>
                                    </div>
                                    <div class="overflow-hidden flex-1">
                                        <h4 class="text-sm font-black text-slate-800 dark:text-white leading-tight truncate" title="{{ $tour->title }}">{{ $tour->title }}</h4>
                                        <p class="text-[10px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate">{{ $tour->destination }} • {{ $tour->duration }}</p>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="text-[9px] font-black text-blue-500 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full uppercase tracking-widest">{{ $tour->badge ?? 'Reg' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @foreach($dates as $date)
                                @php
                                    $booked = $tourSchedule[$date][$tour->id]['booked'];
                                    $statusClass = $booked > 0 ? 'bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-900/50' : 'bg-slate-50 dark:bg-slate-800/50 text-slate-300 dark:text-slate-600 border-slate-50 dark:border-slate-800';
                                @endphp
                                <td class="p-3 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-full px-3 py-3 rounded-2xl border {{ $statusClass }} text-center transition-all hover:scale-105 group/cell relative">
                                            @if($booked > 0)
                                                <p class="text-[10px] font-black leading-none">{{ $booked }} Booked</p>
                                            @else
                                                <p class="text-[10px] font-bold opacity-40 leading-none">Empty</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Fleet Scheduling Tab --}}
    <div x-show="activeTab === 'fleets'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden" x-cloak>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="p-6 border-b border-slate-100 dark:border-slate-800 sticky left-0 bg-white dark:bg-slate-900 z-10 w-80 shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)] dark:shadow-[10px_0_15px_-10px_rgba(0,0,0,0.5)]">
                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Fleet / Vehicle') }}</span>
                        </th>
                        @foreach($dates as $date)
                            <th class="p-6 border-b border-slate-100 dark:border-slate-800 text-center min-w-[120px]">
                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-0.5">{{ \Carbon\Carbon::parse($date)->format('D') }}</p>
                                <p class="text-base font-black text-slate-800 dark:text-white leading-none">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($armadas as $armada)
                        <tr class="group hover:bg-slate-50/30 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="p-6 border-b border-slate-100 dark:border-slate-800 sticky left-0 bg-white dark:bg-slate-900 group-hover:bg-slate-50/30 dark:group-hover:bg-slate-800/30 z-10 transition-colors shadow-[10px_0_15px_-10px_rgba(0,0,0,0.05)] dark:shadow-[10px_0_15px_-10px_rgba(0,0,0,0.5)]">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-sm shrink-0">
                                        <i data-lucide="bus" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-slate-800 dark:text-white leading-tight">{{ $armada->name }}</h4>
                                        <p class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">{{ $armada->capacity }} Seats</p>
                                    </div>
                                </div>
                            </td>
                            @foreach($dates as $date)
                                @php
                                    $data = $fleetSchedule[$date][$armada->id];
                                    $statusClass = $data['ready'] > 0 ? 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/50' : 'bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border-red-100 dark:border-red-900/50';
                                @endphp
                                <td class="p-3 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-full px-3 py-3 rounded-2xl border {{ $statusClass }} text-center transition-all hover:scale-105 group/cell relative">
                                            <p class="text-[10px] font-black leading-none">{{ $data['ready'] }} Ready</p>
                                            
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-32 bg-slate-900 dark:bg-slate-800 text-white p-3 rounded-2xl text-[9px] opacity-0 invisible group-hover/cell:opacity-100 group-hover/cell:visible transition-all z-50 pointer-events-none shadow-2xl">
                                                <div class="space-y-1">
                                                    <div class="flex justify-between"><span>Booked:</span> <span>{{ $data['booked'] }}</span></div>
                                                    <div class="flex justify-between"><span>Maint:</span> <span>{{ $data['maintenance'] }}</span></div>
                                                </div>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-slate-900 dark:border-t-slate-800"></div>
                                            </div>
                                        </div>
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
        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-500 shadow-sm shrink-0">
                <i data-lucide="calendar" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">Dual Monitoring</h5>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed italic">Switch between Tour Packages and Fleet availability using the tabs above for complete operational control.</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <i data-lucide="zap" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">Live Updates</h5>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed italic">Availability is recalculated instantly every time a booking is confirmed or marked as paid.</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-start gap-6">
            <div class="w-14 h-14 bg-slate-900 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-white dark:text-slate-200 shadow-sm shrink-0">
                <i data-lucide="layout" class="w-7 h-7"></i>
            </div>
            <div>
                <h5 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">Resource Management</h5>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed italic">The scheduling view provides a 14-day lookahead to help you plan staff and vehicle allocations efficiently.</p>
            </div>
        </div>
    </div>
</div>
@endsection
