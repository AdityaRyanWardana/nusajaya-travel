@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.3em] mb-2">Inventory System</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Fleet Management') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Organize and monitor your transportation assets.') }}</p>
        </div>
        <a href="{{ route('admin.armadas.create') }}" class="flex items-center px-8 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 group">
            <i data-lucide="plus" class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform"></i>
            {{ __('Register New Fleet') }}
        </a>
    </div>

    {{-- Stats Mini Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-500">
            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Assets</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $armadas->sum('total_units') }} <span class="text-xs font-bold text-slate-400">Units</span></p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-500">
            <p class="text-[10px] font-black text-emerald-400 dark:text-emerald-500 uppercase tracking-widest mb-1">Operational</p>
            <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $armadas->sum('total_units') - $armadas->sum('maintenance_units') }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-500">
            <p class="text-[10px] font-black text-red-400 dark:text-red-500 uppercase tracking-widest mb-1">In Maintenance</p>
            <p class="text-2xl font-black text-red-500 dark:text-red-400">{{ $armadas->sum('maintenance_units') }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-500">
            <p class="text-[10px] font-black text-blue-400 dark:text-blue-500 uppercase tracking-widest mb-1">Fleet Categories</p>
            <p class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $armadas->count() }}</p>
        </div>
    </div>

    {{-- Fleet Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($armadas as $armada)
        <div class="group bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-2xl dark:hover:shadow-black/50 transition-all duration-500 overflow-hidden flex flex-col cursor-pointer" onclick="window.location.href='{{ route('admin.armadas.edit', $armada->id) }}'">
            {{-- Image Header --}}
            <div class="relative h-56 overflow-hidden">
                @if($armada->image)
                    <img src="{{ $armada->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                @else
                    <div class="w-full h-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-200 dark:text-slate-700">
                        <i data-lucide="image" class="w-12 h-12"></i>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                
                <div class="absolute top-6 left-6">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-white/20">
                        {{ $armada->type }}
                    </span>
                </div>

                <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase italic tracking-tight">{{ $armada->name }}</h3>
                        <p class="text-white/70 text-[10px] font-bold uppercase tracking-widest mt-1">Capacity: {{ $armada->capacity }} People</p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-8 space-y-6 flex-1 flex flex-col">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Operational</p>
                        <p class="text-lg font-black text-emerald-600 dark:text-emerald-400 leading-none">{{ $armada->total_units - $armada->maintenance_units }} <span class="text-[10px] text-slate-400 font-bold uppercase">Ready</span></p>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Price Start</p>
                        <p class="text-sm font-black text-slate-900 dark:text-white leading-none">Rp {{ number_format($armada->price_city_tour, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Status Indicators --}}
                <div class="space-y-3 flex-1">
                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                        <span class="text-slate-400 dark:text-slate-500">Inventory Status</span>
                        <span class="{{ $armada->maintenance_units > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $armada->maintenance_units > 0 ? $armada->maintenance_units . ' in Maintenance' : 'All Units Ready' }}
                        </span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex">
                        @php
                            $readyPercent = ($armada->total_units > 0) ? (($armada->total_units - $armada->maintenance_units) / $armada->total_units) * 100 : 0;
                            $mntPercent = ($armada->total_units > 0) ? ($armada->maintenance_units / $armada->total_units) * 100 : 0;
                        @endphp
                        <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: {{ $readyPercent }}%"></div>
                        <div class="bg-red-500 h-full transition-all duration-1000" style="width: {{ $mntPercent }}%"></div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between gap-4">
                    <div class="flex-1 flex items-center justify-center px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-2"></i>
                        Manage Asset
                    </div>
                    <form action="{{ route('admin.armadas.destroy', $armada->id) }}" method="POST" class="shrink-0" onsubmit="return confirm('{{ __('Are you sure you want to delete this fleet?') }}')" onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-12 h-12 flex items-center justify-center bg-red-50 dark:bg-red-950/30 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mx-auto mb-6">
                <i data-lucide="bus" class="w-12 h-12"></i>
            </div>
            <h3 class="text-xl font-black text-slate-400 uppercase tracking-widest italic">{{ __('No Fleets Registered') }}</h3>
            <p class="text-slate-300 mt-2 font-medium">Start building your assets by adding a new vehicle.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
