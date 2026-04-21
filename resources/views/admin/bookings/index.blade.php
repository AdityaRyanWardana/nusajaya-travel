@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] mb-2">Admin Panel</p>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight uppercase italic leading-none">Booking Requests</h2>
            <p class="text-slate-400 font-medium mt-2">Manage all customer service requests and booking statuses.</p>
        </div>

        {{-- Quick Status Summary --}}
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-5 py-3 bg-amber-50 rounded-2xl border border-amber-100">
                <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                <span class="text-xs font-black text-amber-600">{{ $bookings->total() > 0 ? $bookings->where('status','pending')->count() : 0 }} Pending</span>
            </div>
            <div class="flex items-center gap-2 px-5 py-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                <span class="text-xs font-black text-emerald-600">{{ $bookings->total() > 0 ? $bookings->where('status','paid')->count() : 0 }} Paid</span>
            </div>
            <div class="flex items-center gap-2 px-5 py-3 bg-red-50 rounded-2xl border border-red-100">
                <div class="w-2 h-2 rounded-full bg-red-400"></div>
                <span class="text-xs font-black text-red-500">{{ $bookings->total() > 0 ? $bookings->where('status','cancelled')->count() : 0 }} Cancelled</span>
            </div>
        </div>
    </div>

    {{-- Booking Cards --}}
    <div class="space-y-4">
        @forelse($bookings as $booking)

        {{-- Status color mapping --}}
        @php
            $statusColor = match($booking->status) {
                'paid'      => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-400'],
                'pending'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'border' => 'border-amber-200',   'dot' => 'bg-amber-400 animate-pulse'],
                'cancelled' => ['bg' => 'bg-red-50',     'text' => 'text-red-500',     'border' => 'border-red-200',     'dot' => 'bg-red-400'],
                'completed' => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'border' => 'border-blue-200',    'dot' => 'bg-blue-400'],
                default     => ['bg' => 'bg-slate-50',   'text' => 'text-slate-500',   'border' => 'border-slate-200',   'dot' => 'bg-slate-400'],
            };
        @endphp

        <div class="relative group">
            <a href="{{ route('admin.bookings.show', $booking) }}" class="block bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    {{-- Left Accent Bar --}}
                    <div class="w-full md:w-1.5 shrink-0 {{ $booking->status === 'paid' ? 'bg-emerald-400' : ($booking->status === 'pending' ? 'bg-amber-400' : ($booking->status === 'cancelled' ? 'bg-red-400' : 'bg-blue-400')) }} md:rounded-l-[2rem]"></div>

                    <div class="flex-1 p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">

                            {{-- Customer Info --}}
                            <div class="flex items-center gap-4 lg:w-56 shrink-0">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-blue-50 flex items-center justify-center text-blue-600 font-black text-lg shadow-sm shrink-0">
                                    @if($booking->user->avatar)
                                        <img src="{{ asset('storage/' . $booking->user->avatar) }}" class="w-full h-full object-cover" alt="{{ $booking->user->name }}">
                                    @else
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 leading-tight">{{ $booking->user->email }}</p>
                                    @if($booking->user->phone)
                                        <p class="text-[10px] font-bold text-blue-400 mt-0.5">{{ $booking->user->phone }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 shrink-0"></div>

                            {{-- Order Info --}}
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="text-[9px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest">{{ $booking->order_number }}</span>
                                    <span class="text-[9px] font-black bg-slate-100 text-slate-500 px-3 py-1 rounded-full uppercase tracking-widest">{{ $booking->type }}</span>
                                </div>
                                <p class="text-sm font-black text-slate-800 leading-tight mb-2">{{ $booking->service_name }}</p>
                                <div class="flex flex-wrap gap-x-4 gap-y-1">
                                    @if($booking->pickup_point)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500">
                                        <span class="text-blue-400 font-black">↑</span> {{ Str::limit($booking->pickup_point, 30) }}
                                    </span>
                                    @endif
                                    @if($booking->destination && $booking->destination !== $booking->service_name)
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500">
                                        <span class="text-red-400 font-black">↓</span> {{ Str::limit($booking->destination, 30) }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 shrink-0"></div>

                            {{-- Travel Date --}}
                            <div class="text-center shrink-0 lg:w-28">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Travel Date</p>
                                <p class="text-sm font-black text-slate-700">{{ $booking->travel_date?->format('d') }}</p>
                                <p class="text-xs font-bold text-slate-500">{{ $booking->travel_date?->format('M Y') }}</p>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 shrink-0"></div>

                            {{-- Amount --}}
                            <div class="text-center shrink-0 lg:w-36">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total</p>
                                <p class="text-lg font-black text-slate-800 leading-tight">IDR</p>
                                <p class="text-base font-black text-blue-600 leading-tight">{{ number_format($booking->amount, 0, ',', '.') }}</p>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden lg:block w-px h-16 bg-slate-100 shrink-0"></div>

                            {{-- Status & Actions --}}
                            <div class="flex flex-col items-center gap-4 shrink-0 relative z-10" onclick="event.preventDefault(); event.stopPropagation();">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $statusColor['bg'] }} {{ $statusColor['text'] }} border {{ $statusColor['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                                    {{ $booking->status }}
                                </span>

                                <div class="flex items-center gap-1">
                                    @if($booking->status == 'pending')
                                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-emerald-500 bg-emerald-50 hover:bg-emerald-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Confirm Payment">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($booking->status != 'cancelled')
                                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Cancel Booking">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this booking permanently?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-400 bg-red-50 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm" title="Delete Record">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </a>
        </div>

        @empty
        <div class="bg-white rounded-[3rem] border border-slate-100 py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 mx-auto">
                <i data-lucide="calendar-x" class="w-10 h-10"></i>
            </div>
            <p class="text-slate-400 font-bold italic">No bookings found in the database.</p>
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
