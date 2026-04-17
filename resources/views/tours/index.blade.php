@extends('layouts.public')

@section('content')
<main class="flex-1 bg-lightbg px-8 py-12">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-black text-brandblue mb-2 tracking-tight">Available Tour Packages</h1>
        <p class="text-sm text-slate-500 mb-8">Discover the hidden gems of Batam with our curated tours.</p>

        <!-- Category Filter -->
        <div class="flex flex-wrap gap-2 mb-10">
            @php
                $categories = ['All', 'PP Barelang', 'Batam City Tour'];
            @endphp
            @foreach($categories as $cat)
                <a href="{{ route('tours.index', ['category' => $cat]) }}" 
                   class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ $selectedCategory == $cat ? 'bg-brandblue text-white shadow-lg shadow-brandblue/30 scale-105' : 'bg-white text-slate-500 hover:bg-slate-100' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($tours as $tour)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-xl hover:shadow-brandblue/5 transition-all duration-300 relative">
                <a href="{{ route('tours.show', $tour['slug']) }}" class="absolute inset-0 z-10" aria-label="View {{ $tour['name'] }} details"></a>
                <div class="h-48 overflow-hidden">
                    <img src="{{ $tour['image'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-brandblue mb-3 group-hover:text-skyblue transition-colors">{{ $tour['name'] }}</h3>
                    <p class="text-sm text-slate-500 mb-6 line-clamp-2 leading-relaxed flex-grow">{{ $tour['description'] }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-slate-50 relative z-20">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Starting from</p>
                            <p class="text-lg font-black text-brandblue">IDR {{ number_format($tour['price'], 0, ',', '.') }}</p>
                        </div>
                        <button class="bg-brandblue hover:bg-slate-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-brandblue/20">Book Now</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
