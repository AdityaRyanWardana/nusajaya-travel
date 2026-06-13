@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.3em] mb-2">Admin Panel</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Booking Requests') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Manage all customer service requests and booking statuses.') }}</p>
        </div>

        {{-- Filter & Quick Status Summary --}}
        <div class="flex flex-col md:items-end gap-4">
            {{-- Filter Form --}}
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="month" name="month" value="{{ request('month') }}" class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <select name="status" class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-5 py-3 bg-slate-900 dark:bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 dark:hover:bg-blue-500 transition shadow-sm">Filter</button>
                @if(request('month') || request('status'))
                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition shadow-sm flex items-center justify-center">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
                @endif
            </form>

            {{-- Quick Status Summary --}}
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 px-5 py-3 bg-amber-50 dark:bg-amber-950/20 rounded-2xl border border-amber-100 dark:border-amber-900/50">
                    <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                    <span class="text-xs font-black text-amber-600 dark:text-amber-400">{{ $counts['pending'] }} {{ __('Pending') }}</span>
                </div>
                <div class="flex items-center gap-2 px-5 py-3 bg-emerald-50 dark:bg-emerald-950/20 rounded-2xl border border-emerald-100 dark:border-emerald-900/50">
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    <span class="text-xs font-black text-emerald-600 dark:text-emerald-400">{{ $counts['paid'] }} {{ __('Paid') }}</span>
                </div>
                <div class="flex items-center gap-2 px-5 py-3 bg-red-50 dark:bg-red-950/20 rounded-2xl border border-red-100 dark:border-red-900/50">
                    <div class="w-2 h-2 rounded-full bg-red-400"></div>
                    <span class="text-xs font-black text-red-500 dark:text-red-400">{{ $counts['cancelled'] }} {{ __('Cancelled') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Booking Cards --}}
    <div class="space-y-4">
        @forelse($bookings as $booking)

        {{-- Status color mapping --}}
        @php
            $displayStatus = $booking->status;
            if ($booking->rescheduled_at && !$booking->reschedule_notified) {
                $displayStatus = 'rescheduled';
            }

            $statusColor = match($displayStatus) {
                'paid'        => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/30', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'border-emerald-200 dark:border-emerald-800', 'dot' => 'bg-emerald-400', 'accent' => 'bg-emerald-400'],
                'rescheduled' => ['bg' => 'bg-amber-50 dark:bg-amber-950/30',   'text' => 'text-amber-600 dark:text-amber-400',   'border' => 'border-amber-200 dark:border-amber-800',   'dot' => 'bg-amber-400 animate-pulse', 'accent' => 'bg-amber-400'],
                'pending'     => ['bg' => 'bg-amber-50 dark:bg-amber-950/30',   'text' => 'text-amber-600 dark:text-amber-400',   'border' => 'border-amber-200 dark:border-amber-800',   'dot' => 'bg-amber-400 animate-pulse', 'accent' => 'bg-amber-400'],
                'cancelled'   => ['bg' => 'bg-red-50 dark:bg-red-950/30',     'text' => 'text-red-500 dark:text-red-400',     'border' => 'border-red-200 dark:border-red-800',     'dot' => 'bg-red-400', 'accent' => 'bg-red-400'],
                'completed'   => ['bg' => 'bg-blue-50 dark:bg-blue-950/30',    'text' => 'text-blue-600 dark:text-blue-400',    'border' => 'border-blue-200 dark:border-blue-800',    'dot' => 'bg-blue-400', 'accent' => 'bg-blue-400'],
                default       => ['bg' => 'bg-slate-50 dark:bg-slate-800/50',   'text' => 'text-slate-500 dark:text-slate-400',   'border' => 'border-slate-200 dark:border-slate-700',   'dot' => 'bg-slate-400', 'accent' => 'bg-slate-400'],
            };
        @endphp

        <div class="relative group">
            <div onclick="window.location='{{ route('admin.bookings.show', $booking) }}'" class="block cursor-pointer bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl dark:hover:shadow-black/50 hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    {{-- Left Accent Bar --}}
                    <div class="w-full md:w-1.5 shrink-0 {{ $statusColor['accent'] }} md:rounded-l-[2rem]"></div>

                    <div class="flex-1 p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">

                            {{-- Customer Info --}}
                            <div class="flex items-center gap-4 lg:w-64 shrink-0">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black text-xl shadow-sm shrink-0">
                                    @if($booking->user->avatar)
                                        <img src="{{ asset('storage/' . $booking->user->avatar) }}" class="w-full h-full object-cover" alt="{{ $booking->user->name }}">
                                    @else
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="text-base font-black text-slate-800 dark:text-white leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $booking->user->name }}</p>
                                    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1 leading-tight">{{ $booking->user->email }}</p>
                                    @if($booking->user->phone)
                                        <p class="text-xs font-bold text-blue-500 mt-0.5">{{ $booking->user->phone }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 dark:bg-slate-800 shrink-0"></div>

                            {{-- Order Info --}}
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                <p class="text-xs font-black text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-3 py-1.5 rounded-full uppercase tracking-widest">{{ $booking->order_number }}</p>
                                    <span class="text-xs font-black bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-3 py-1.5 rounded-full uppercase tracking-widest">{{ $booking->type }}</span>
                                </div>
                                <p class="text-lg font-black text-slate-800 dark:text-white leading-tight mb-3">{{ $booking->service_name }}</p>
                                <div class="flex flex-col gap-y-2">
                                    @if($booking->pickup_point)
                                    <span class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400">
                                        <span class="text-blue-500 font-black text-sm">↑</span> {{ Str::limit($booking->pickup_point, 40) }}
                                    </span>
                                    @endif
                                    @if($booking->destination && $booking->destination !== $booking->service_name)
                                    <span class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400">
                                        <span class="text-red-500 font-black text-sm">↓</span> {{ Str::limit($booking->destination, 40) }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 dark:bg-slate-800 shrink-0"></div>

                            {{-- Travel Date --}}
                            <div class="text-center shrink-0 lg:w-28">
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('Travel Date') }}</p>
                                <p class="text-sm font-black text-slate-700 dark:text-slate-200">{{ $booking->travel_date?->format('d') }}</p>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $booking->travel_date?->format('M Y') }}</p>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 dark:bg-slate-800 shrink-0"></div>

                            {{-- Amount --}}
                            <div class="text-center shrink-0 lg:w-36">
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">{{ __('Total') }}</p>
                                <p class="text-lg font-black text-slate-800 dark:text-white leading-tight">IDR</p>
                                <p class="text-base font-black text-blue-600 dark:text-blue-400 leading-tight">{{ number_format($booking->amount, 0, ',', '.') }}</p>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 dark:bg-slate-800 shrink-0"></div>

                            {{-- Status & Actions --}}
                            <div class="flex flex-col items-center gap-4 shrink-0 relative z-10" onclick="event.stopPropagation();">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $statusColor['bg'] }} {{ $statusColor['text'] }} border {{ $statusColor['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                                    {{ $displayStatus }}
                                </span>

                                @if(auth()->user()->role !== 'superadmin')
                                <div class="flex items-center gap-1">
                                    @if($booking->status == 'pending')
                                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-emerald-500 bg-emerald-50 dark:bg-emerald-950/30 hover:bg-emerald-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Confirm Payment">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($booking->status != 'cancelled')
                                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-amber-500 bg-amber-50 dark:bg-amber-950/30 hover:bg-amber-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Cancel Booking">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                          data-confirm="{{ $booking->status === 'paid' ? 'WARNING: This booking is PAID. Delete it permanently?' : 'Delete this booking permanently? This cannot be undone.' }}"
                                          data-confirm-title="Delete Booking"
                                          data-confirm-ok="Yes, Delete"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-400 bg-red-50 dark:bg-red-950/30 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Delete Record">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @empty
        <div class="bg-white rounded-[3rem] border border-slate-100 py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 mx-auto">
                <i data-lucide="calendar-x" class="w-10 h-10"></i>
            </div>
            <p class="text-slate-400 font-bold italic">{{ __('No bookings found in the database.') }}</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
    <div class="p-6">
        {{ $bookings->links() }}
    </div>
    @endif

</div>
@endsection
