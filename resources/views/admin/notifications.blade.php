@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <div class="w-12 h-12 bg-[#38BDF8]/10 text-[#38BDF8] rounded-2xl flex items-center justify-center">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </div>
                {{ __('All Notifications') }}
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-2">{{ __('View your recent system alerts and updates') }}</p>
        </div>
        @if(!session('notifications_read') && count($notifications) > 0)
        <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-[#0F2038] dark:hover:bg-[#1A365D] text-slate-700 dark:text-slate-300 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                <i data-lucide="check-check" class="w-4 h-4"></i>
                {{ __('Mark all as read') }}
            </button>
        </form>
        @endif
    </div>

    <!-- Notifications List -->
    <div class="bg-white dark:bg-[#0B2447] rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-black/20 border border-slate-100 dark:border-[#1E3A5F] overflow-hidden">
        
        <div class="px-8 py-5 border-b border-slate-100 dark:border-[#1E3A5F] bg-slate-50/50 dark:bg-[#0F2038]">
            <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Recent Activity') }}</h3>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-[#1E3A5F]">
            @forelse($notifications as $notification)
                <div class="p-8 hover:bg-slate-50 dark:hover:bg-[#0F2038]/50 transition-colors group">
                    <div class="flex gap-6">
                        <!-- Icon -->
                        <div class="shrink-0 mt-1">
                            <div class="w-14 h-14 bg-{{ $notification['color'] }}-50 dark:bg-{{ $notification['color'] }}-500/10 text-{{ $notification['color'] }}-500 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="{{ $notification['icon'] }}" class="w-7 h-7"></i>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-{{ $notification['color'] }}-500 transition-colors">
                                    {{ $notification['title'] }}
                                </h3>
                                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-[#1A365D] px-3 py-1 rounded-full whitespace-nowrap">
                                    {{ $notification['time'] }}
                                </span>
                            </div>
                            
                            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-4 max-w-3xl">
                                {{ $notification['description'] }}
                            </p>

                            @if($notification['link'] && $notification['link'] !== '#')
                            <a href="{{ $notification['link'] }}" class="inline-flex items-center gap-2 text-sm font-bold text-{{ $notification['color'] }}-500 hover:text-{{ $notification['color'] }}-600 transition-colors">
                                {{ __('View Details') }}
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-[#0F2038] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="bell-off" class="w-10 h-10 text-slate-300 dark:text-slate-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">{{ __('No Notifications') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __("You're all caught up! There are no new alerts right now.") }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
