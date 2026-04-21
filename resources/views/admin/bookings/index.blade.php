@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Booking Management</h2>
        <p class="text-slate-400 font-medium mt-2 italic text-lg">View and manage all customer service requests and booking statuses.</p>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6">Customer</th>
                        <th class="px-6 py-6">Service Details</th>
                        <th class="px-6 py-6 text-center">Travel Date</th>
                        <th class="px-6 py-6 text-right">Total Amount</th>
                        <th class="px-6 py-6 text-center">Status</th>
                        <th class="px-10 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-10 py-8">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black mr-4 shadow-sm">
                                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-8">
                            <div class="flex flex-col space-y-1">
                                <span class="text-[9px] font-black px-3 py-1 bg-blue-50 text-blue-600 rounded-full uppercase tracking-widest w-max mb-1">{{ $booking->type }}</span>
                                <span class="text-sm font-bold text-slate-700 italic leading-tight">{{ $booking->service_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-8 text-center text-sm font-bold text-slate-500 italic">
                            {{ $booking->travel_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-8 text-right font-black text-slate-800">
                            IDR {{ number_format($booking->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-8 text-center">
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest 
                                {{ $booking->status == 'pending' ? 'bg-amber-50 text-amber-600' : ($booking->status == 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @if($booking->status == 'pending')
                                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="p-2.5 text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all shadow-sm" title="Confirm Payment">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    </button>
                                </form>
                                @endif

                                @if($booking->status != 'cancelled')
                                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="p-2.5 text-amber-500 hover:bg-amber-50 rounded-xl transition-all shadow-sm" title="Cancel Booking">
                                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this booking permanently?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-red-400 hover:bg-red-50 rounded-xl transition-all shadow-sm" title="Delete Record">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6">
                                    <i data-lucide="calendar-x" class="w-10 h-10"></i>
                                </div>
                                <p class="text-slate-400 font-bold italic">No bookings found in the database.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
