@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.3em] mb-2">Fleet Management</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Maintenance Board') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Monitor and manage vehicles currently under repair.') }}</p>
        </div>
        <a href="{{ route('admin.armadas.index') }}" class="flex items-center px-8 py-4 bg-white border border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-all shadow-sm group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform"></i>
            {{ __('Back to Inventory') }}
        </a>
    </div>

    {{-- Add New Maintenance --}}
    @if(auth()->user()->role !== 'superadmin')
    <div class="bg-slate-50/50 p-8 rounded-2xl shadow-sm border border-slate-200">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">{{ __('Send Vehicle to Maintenance') }}</h3>
            <p class="text-xs text-slate-500 mt-1">Select a fleet category and input the physical car's plate number.</p>
        </div>
        <form action="{{ route('admin.maintenance.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            @csrf
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-2">Select Vehicle to Send</label>
                <select name="vehicle_id" class="w-full px-4 py-3 bg-white rounded-xl border border-slate-300 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm text-slate-700 font-medium" required>
                    <option value="" disabled selected>-- Choose an Active Vehicle --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->armada->name }} - {{ $vehicle->plate_number }} {{ $vehicle->mirror_number ? '('.$vehicle->mirror_number.')' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Expected Finish Date</label>
                <input type="date" name="expected_finish_date" class="w-full px-4 py-3 bg-white rounded-xl border border-slate-300 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm text-slate-700 font-medium" required>
            </div>
            <div>
                <button type="submit" class="w-full py-3.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md hover:shadow-blue-500/20">
                    + Send to Repair
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Active Maintenance --}}
    <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl flex items-center justify-center text-red-600 shadow-sm border border-red-100">
                <i data-lucide="wrench" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Currently Under Repair') }}</h3>
                <p class="text-xs text-slate-400 mt-1">Vehicles that are currently in the workshop</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-y border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Fleet Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Plate No. / ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sent to Repair</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Est. Finish</th>
                        @if(auth()->user()->role !== 'superadmin')
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activeMaintenances as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors" x-data="{ editingDate: false }">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden">
                                        @if($log->armada->image)
                                            <img src="{{ $log->armada->image_url }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="image" class="w-4 h-4"></i>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $log->armada->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-white border border-slate-200 rounded-md text-xs font-bold text-slate-600 shadow-sm">{{ $log->vehicle_name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600 font-medium">{{ $log->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div x-show="!editingDate" class="flex items-center gap-2">
                                    <span class="text-sm text-red-600 font-bold bg-red-50 px-3 py-1 rounded-md shadow-sm">{{ $log->expected_finish_date->format('d M Y') }}</span>
                                    @if(auth()->user()->role !== 'superadmin')
                                    <button @click="editingDate = true" class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-md transition-colors" title="Edit Extension Time">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </div>
                                @if(auth()->user()->role !== 'superadmin')
                                <div x-show="editingDate" style="display: none;" class="flex items-center gap-2">
                                    <form action="{{ route('admin.armadas.maintenance.update', [$log->armada_id, $log->id]) }}" method="POST" class="flex items-center gap-2 bg-white border border-slate-200 p-1 rounded-lg shadow-lg">
                                        @csrf
                                        @method('PUT')
                                        <input type="date" name="expected_finish_date" value="{{ $log->expected_finish_date->format('Y-m-d') }}" class="px-2 py-1.5 text-xs border border-slate-200 rounded-md outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" required>
                                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-md transition-colors" title="Save">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                        <button type="button" @click="editingDate = false" class="p-1.5 bg-slate-50 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded-md transition-colors" title="Cancel">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                            @if(auth()->user()->role !== 'superadmin')
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.armadas.maintenance.complete', [$log->armada_id, $log->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg text-xs font-bold hover:bg-emerald-600 transition-all shadow-md shadow-emerald-500/20">
                                        Mark as Ready
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'superadmin' ? '5' : '4' }}" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 border border-slate-100">
                                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-400"></i>
                                </div>
                                <h4 class="text-slate-500 font-bold">All Vehicles Operational</h4>
                                <p class="text-slate-400 text-xs mt-1">There are no vehicles currently under maintenance.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Completed Maintenance History --}}
    <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-slate-400"></div>
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-xl flex items-center justify-center text-slate-500 shadow-sm border border-slate-200">
                <i data-lucide="history" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ __('Recent Maintenance History') }}</h3>
                <p class="text-xs text-slate-400 mt-1">Last 10 completed repair logs</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-y border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Fleet Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Plate No. / ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sent to Repair</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Completed At</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($completedMaintenances as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors opacity-80">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-600">{{ $log->armada->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-slate-500">{{ $log->vehicle_name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 font-medium">{{ $log->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 font-medium">{{ $log->updated_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-md text-xs font-bold border border-slate-200">Completed</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">
                                No history available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
