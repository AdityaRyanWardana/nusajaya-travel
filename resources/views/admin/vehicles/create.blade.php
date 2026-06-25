@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
    <div>
        <h2 class="text-3xl font-black text-slate-800 dark:text-white uppercase italic tracking-tight">{{ __('Add New Vehicle Unit') }}</h2>
        <p class="text-slate-500 text-sm mt-2 font-medium">{{ __('Register a physical car into the system.') }}</p>
    </div>
    <a href="{{ route('admin.vehicles.index') }}" class="flex items-center px-8 py-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm group">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform"></i>
        {{ __('Back to List') }}
    </a>
</div>

<div class="max-w-3xl">
    <form action="{{ route('admin.vehicles.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-sky-50 dark:bg-sky-900/30 rounded-2xl flex items-center justify-center text-sky-500 shadow-sm">
                    <i data-lucide="car" class="w-5 h-5"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase italic tracking-tight">{{ __('Vehicle Details') }}</h3>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="armada_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Fleet Category') }}</label>
                    <div class="relative">
                        <select name="armada_id" id="armada_id" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 appearance-none cursor-pointer" required>
                            <option value="" disabled selected>-- Select a Fleet Category --</option>
                            @foreach($armadas as $armada)
                                <option value="{{ $armada->id }}">{{ $armada->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                    @error('armada_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="plate_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Plate Number') }}</label>
                        <input type="text" name="plate_number" id="plate_number" placeholder="BP 1234 XY" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 uppercase" required>
                        @error('plate_number')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mirror_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Mirror No. / Fleet ID') }}</label>
                        <input type="text" name="mirror_number" id="mirror_number" placeholder="Bus #01" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200">
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Current Status') }}</label>
                    <div class="relative">
                        <select name="status" id="status" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 appearance-none cursor-pointer" required>
                            <option value="active">Active (Ready)</option>
                            <option value="maintenance">Under Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ __('Internal Notes') }}</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Condition details, legal documents expiry dates, etc..." class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 resize-none"></textarea>
                </div>
            </div>
            
            <div class="mt-10 flex flex-col gap-4">
                <button type="submit" class="w-full py-6 bg-sky-500 text-white text-xs font-black uppercase tracking-widest rounded-3xl hover:bg-sky-600 transition-all shadow-xl shadow-sky-500/20">
                    {{ __('Save Vehicle Unit') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
