@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 dark:shadow-blue-900/20">
                <i data-lucide="megaphone" class="w-6 h-6"></i>
            </div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ __('Promotion Center') }}</h2>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium ml-1">{{ __('Craft and manage your promotional offers to boost engagement.') }}</p>
    </div>
    @if(auth()->user()->role !== 'superadmin')
    <a href="{{ route('admin.promotions.create') }}" class="flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20 group">
        <i data-lucide="plus" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform"></i>
        {{ __('New Promotion') }}
    </a>
    @endif
</div>

<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Offer Details') }}</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Strategy') }}</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Performance') }}</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Status') }}</th>
                    @if(auth()->user()->role !== 'superadmin')
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-center">{{ __('Actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($promotions as $promotion)
                <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all {{ auth()->user()->role !== 'superadmin' ? 'cursor-pointer' : '' }}" @if(auth()->user()->role !== 'superadmin') onclick="window.location.href='{{ route('admin.promotions.edit', $promotion->id) }}'" @endif>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-14 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden flex-shrink-0 shadow-sm border border-slate-200/50 dark:border-slate-700">
                                @if($promotion->image)
                                    <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-slate-800">
                                        <i data-lucide="image" class="w-5 h-5 text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="max-w-xs">
                                <span class="text-sm font-black text-slate-800 dark:text-white block group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-tight mb-1">{{ $promotion->title }}</span>
                                <div class="flex items-center gap-2">
                                    @if($promotion->badge)
                                        <span class="text-[9px] font-black uppercase tracking-tighter px-2 py-0.5 bg-red-500 text-white rounded-md shadow-sm shadow-red-200">
                                            {{ $promotion->badge }}
                                        </span>
                                    @endif
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold truncate">{{ Str::limit($promotion->description, 40) }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-full w-fit mb-1">
                                {{ $promotion->type }}
                            </span>
                            @if($promotion->tour)
                                <span class="text-[10px] text-blue-500 dark:text-blue-400 font-bold flex items-center">
                                    <i data-lucide="link" class="w-3 h-3 mr-1"></i>
                                    {{ Str::limit($promotion->tour->title, 20) }}
                                </span>
                            @elseif($promotion->link)
                                <span class="text-[10px] text-emerald-500 dark:text-emerald-400 font-bold flex items-center">
                                    <i data-lucide="external-link" class="w-3 h-3 mr-1"></i>
                                    {{ __('Custom Link') }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                <i data-lucide="clock" class="w-3 h-3 mr-2 text-slate-400 dark:text-slate-500"></i>
                                {{ $promotion->expires_at ? $promotion->expires_at->diffForHumans() : __('Evergreen') }}
                            </div>
                            @if($promotion->expires_at)
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 italic">{{ $promotion->expires_at->format('d M, H:i') }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if($promotion->is_active)
                            <div class="inline-flex items-center px-4 py-1.5 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-full border border-emerald-100 dark:border-emerald-900/50">
                                <span class="relative flex h-2 w-2 mr-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-widest italic">{{ __('Live') }}</span>
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-1.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-full border border-slate-100 dark:border-slate-800">
                                <span class="h-2 w-2 rounded-full bg-slate-300 dark:bg-slate-700 mr-3"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest italic">{{ __('Draft') }}</span>
                            </div>
                        @endif
                    </td>
                    @if(auth()->user()->role !== 'superadmin')
                    <td class="px-8 py-6" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST"
                                  data-confirm="Are you sure you want to delete this promotion? This cannot be undone."
                                  data-confirm-title="Delete Promotion"
                                  data-confirm-ok="Yes, Delete Promotion">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 dark:bg-red-950/30 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role !== 'superadmin' ? '5' : '4' }}" class="px-8 py-20">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-6">
                                <i data-lucide="megaphone" class="w-10 h-10"></i>
                            </div>
                            <h3 class="text-lg font-black text-slate-800 mb-2">{{ __('No Promotions Yet') }}</h3>
                            <p class="text-slate-400 text-sm max-w-xs mx-auto mb-8">{{ __('Start creating your first campaign to boost your booking rates.') }}</p>
                            @if(auth()->user()->role !== 'superadmin')
                            <a href="{{ route('admin.promotions.create') }}" class="px-8 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-lg">
                                {{ __('Create One Now') }}
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

