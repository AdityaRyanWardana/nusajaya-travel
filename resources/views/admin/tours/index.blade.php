@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">{{ __('Tour Package Management') }}</h2>
        <p class="text-slate-500 text-sm">{{ __('Manage all travel destinations and holiday packages.') }}</p>
    </div>
    <a href="{{ route('admin.tours.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        {{ __('Add Tour Package') }}
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">{{ __('TOUR PACKAGE') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('DESTINATION') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('DURATION') }}</th>
                    <th class="px-6 py-4 font-semibold text-right">{{ __('PRICE') }}</th>
                    <th class="px-6 py-4 font-semibold text-center">{{ __('ACTION') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($tours as $tour)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 mr-4 overflow-hidden flex-shrink-0">
                                @if($tour->image)
                                    <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset('storage/' . $tour->image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $tour->title }}</p>
                                <p class="text-[10px] text-slate-400 font-mono tracking-tighter">{{ $tour->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-600 flex items-center">
                            <i data-lucide="map-pin" class="w-3 h-3 mr-1.5 text-slate-400"></i>
                            {{ $tour->destination }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-blue-50 text-blue-600 rounded-md">
                            {{ $tour->duration }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800 text-right">Rp {{ number_format($tour->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.tours.edit', $tour->id) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket tour ini?')">
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
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic text-sm">{{ __('No tour packages registered yet.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
