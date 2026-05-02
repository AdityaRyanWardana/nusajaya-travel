@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">{{ __('Promotion Management') }}</h2>
        <p class="text-slate-500 text-sm">{{ __('Manage promotional offers for tours and transport.') }}</p>
    </div>
    <a href="{{ route('admin.promotions.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        {{ __('Add Promotion') }}
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">{{ __('PROMOTION') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('TYPE') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('BADGE') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('STATUS') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('EXPIRES AT') }}</th>
                    <th class="px-6 py-4 font-semibold text-center">{{ __('ACTION') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($promotions as $promotion)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 mr-4 overflow-hidden flex-shrink-0">
                                @if($promotion->image)
                                    <img src="{{ asset('storage/' . $promotion->image) }}" alt="{{ $promotion->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-800 block">{{ $promotion->title }}</span>
                                <span class="text-[10px] text-slate-400 font-medium truncate max-w-[200px] block">{{ $promotion->description }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 {{ $promotion->type == 'tour' ? 'bg-blue-100 text-blue-600' : ($promotion->type == 'transport' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600') }} rounded-md">
                            {{ $promotion->type }}
                        </span>
                        @if($promotion->tour)
                            <div class="text-[9px] text-slate-400 mt-1 italic">
                                Linked: {{ $promotion->tour->title }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        @if($promotion->badge)
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 bg-red-500 text-white rounded">
                                {{ $promotion->badge }}
                            </span>
                        @else
                            <span class="text-slate-300">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($promotion->is_active)
                            <span class="flex items-center text-emerald-600 text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                Active
                            </span>
                        @else
                            <span class="flex items-center text-slate-400 text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2"></span>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $promotion->expires_at ? $promotion->expires_at->format('d M Y H:i') : __('No Expiry') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic text-sm">{{ __('No promotions found.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
