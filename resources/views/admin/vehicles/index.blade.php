@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-sky-500 dark:text-sky-400 uppercase tracking-[0.3em] mb-2">Fleet Management</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Vehicle Units Database') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Manage individual physical vehicles, plate numbers, and mirror numbers.') }}</p>
        </div>
        @if(auth()->user()->role !== 'superadmin')
        <a href="{{ route('admin.vehicles.create') }}" class="flex items-center px-8 py-4 bg-sky-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-sky-600 transition-all shadow-xl shadow-sky-500/20 group">
            <i data-lucide="plus" class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform"></i>
            {{ __('Add New Unit') }}
        </a>
        @endif
    </div>

    {{-- Vehicles Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tight">{{ __('All Registered Units') }}</h3>
            <p class="text-xs text-slate-400 mt-1">List of all physical cars currently owned.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fleet Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Plate Number</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Mirror No / ID</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        @if(auth()->user()->role !== 'superadmin')
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden shrink-0">
                                        @if($vehicle->armada->image)
                                            <img src="{{ $vehicle->armada->image_url }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="bus" class="w-4 h-4 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $vehicle->armada->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-black text-slate-700 dark:text-slate-300 shadow-sm uppercase tracking-widest">{{ $vehicle->plate_number }}</span>
                            </td>
                            <td class="px-8 py-5">
                                @if($vehicle->mirror_number)
                                <span class="text-sm font-bold text-slate-500">{{ $vehicle->mirror_number }}</span>
                                @else
                                <span class="text-xs text-slate-300 italic">- None -</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                @if($vehicle->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @elseif($vehicle->status === 'maintenance')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Maintenance
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            @if(auth()->user()->role !== 'superadmin')
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-sky-50 text-slate-400 hover:text-sky-500 rounded-lg transition-colors">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST"
                                          data-confirm="Are you sure you want to delete this vehicle unit?"
                                          data-confirm-title="Delete Vehicle">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-500 rounded-lg transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'superadmin' ? '5' : '4' }}" class="px-8 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-300 dark:text-slate-600 mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                    <i data-lucide="car" class="w-8 h-8"></i>
                                </div>
                                <h4 class="text-slate-500 font-bold">No Vehicles Found</h4>
                                <p class="text-slate-400 text-xs mt-1">You haven't added any physical vehicles yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
