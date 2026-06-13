@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.3em] mb-2">Experiences Management</p>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase italic leading-none">{{ __('Tour Packages') }}</h2>
            <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">{{ __('Curate and publish unique travel experiences for your customers.') }}</p>
        </div>
        <a href="{{ route('admin.tours.create') }}" class="flex items-center px-8 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 group">
            <i data-lucide="plus" class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform"></i>
            {{ __('Add New Package') }}
        </a>
    </div>

    {{-- Tour Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tours as $tour)
        <div class="group bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-2xl dark:hover:shadow-black/50 transition-all duration-500 overflow-hidden flex flex-col cursor-pointer" onclick="window.location.href='{{ route('admin.tours.edit', $tour->id) }}'">
            {{-- Visual Header --}}
            <div class="relative h-64 overflow-hidden">
                @if($tour->image)
                    <img src="{{ $tour->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                @else
                    <div class="w-full h-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-200 dark:text-slate-700">
                        <i data-lucide="image" class="w-12 h-12"></i>
                    </div>
                @endif
                
                {{-- Overlays --}}
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                
                <div class="absolute top-6 left-6">
                    <span class="px-4 py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full shadow-lg shadow-blue-900/40">
                        {{ $tour->duration }}
                    </span>
                </div>

                <div class="absolute bottom-6 left-6 right-6">
                    <div class="flex items-center gap-2 text-white/70 text-[10px] font-black uppercase tracking-widest mb-2">
                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                        {{ $tour->destination }}
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase italic tracking-tight leading-none">{{ $tour->title }}</h3>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-8 space-y-6 flex-1 flex flex-col">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Pricing Starts at</p>
                        <p class="text-xl font-black text-slate-900 dark:text-white leading-none">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                    </div>
                    @if($tour->armada)
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Assigned Fleet</p>
                            <div class="flex items-center gap-2 justify-end">
                                <span class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase">{{ $tour->armada->name }}</span>
                                <i data-lucide="bus" class="w-3 h-3 text-blue-400"></i>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($tour->inclusions)
                        @foreach(array_slice($tour->inclusions, 0, 3) as $inc)
                            <span class="px-3 py-1.5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-[8px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                <i data-lucide="{{ $inc['icon'] ?? 'check' }}" class="w-3 h-3"></i>
                                {{ $inc['label'] ?? 'Facility' }}
                            </span>
                        @endforeach
                        @if(count($tour->inclusions) > 3)
                            <span class="px-3 py-1.5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                +{{ count($tour->inclusions) - 3 }} More
                            </span>
                        @endif
                    @endif
                </div>

                {{-- Actions --}}
                <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between gap-4 mt-auto">
                    <div class="flex-1 flex items-center justify-center px-6 py-4 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i data-lucide="settings-2" class="w-4 h-4 mr-2"></i>
                        Manage Package
                    </div>
                    <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST"
                          class="shrink-0"
                          data-confirm="{{ __('Are you sure you want to delete this package? This cannot be undone.') }}"
                          data-confirm-title="Delete Tour Package"
                          data-confirm-ok="Yes, Delete Package"
                          onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-14 h-14 flex items-center justify-center bg-red-50 dark:bg-red-950/30 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-[3rem] flex items-center justify-center text-slate-200 mx-auto mb-6">
                <i data-lucide="map" class="w-12 h-12"></i>
            </div>
            <h3 class="text-xl font-black text-slate-400 uppercase tracking-widest italic">{{ __('No Tour Packages Found') }}</h3>
            <p class="text-slate-300 mt-2 font-medium">Create your first travel experience to start selling.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
