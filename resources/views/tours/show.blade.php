@extends('layouts.public')

@section('content')
<main class="flex-1 bg-white px-8 py-12 pb-24">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb & Navigation -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-brandblue transition group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                {{ __('Back to All Packages') }}
            </a>
            <div class="flex gap-2">
                <span class="w-2 h-2 rounded-full bg-skyblue"></span>
                <span class="w-2 h-2 rounded-full bg-slate-100"></span>
                <span class="w-2 h-2 rounded-full bg-slate-100"></span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left: Cinematic Content -->
            <div class="flex-grow space-y-12">
                <!-- Main Image Card -->
                <div class="relative h-[600px] rounded-[4rem] overflow-hidden shadow-2xl group/slider">
                    @php
                        $imageSrc = 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2070&auto=format&fit=crop'; // Universal Default
                        
                        // Special case for Ranoh Island if DB is empty but we have the file
                        if (!$tour->image && Str::contains(Str::lower($tour->title), 'ranoh')) {
                            $imageSrc = asset('images/ranoh_island.jpg');
                        }

                        if ($tour->image) {
                            if (Str::startsWith($tour->image, 'http')) {
                                $imageSrc = $tour->image;
                            } elseif (file_exists(public_path($tour->image))) {
                                $imageSrc = asset($tour->image);
                            } else {
                                $imageSrc = asset('storage/' . $tour->image);
                            }
                        }
                    @endphp
                    <img src="{{ $imageSrc }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Overlay Info -->
                    <div class="absolute bottom-16 left-16 right-16">
                        <div class="inline-block px-5 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6">
                            {{ __($tour->destination) }}
                        </div>
                        <h1 class="text-6xl font-black text-white uppercase italic leading-none tracking-tighter">{{ __($tour->title) }}</h1>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="max-w-3xl space-y-12">
                    <div class="space-y-6">
                        <h2 class="text-2xl font-black text-brandblue uppercase italic tracking-tight">{{ __('About the Experience') }}</h2>
                        <p class="text-slate-500 font-medium leading-relaxed text-lg">{{ __($tour->description) }}</p>
                    </div>
                    
                    <div class="space-y-8">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{{ __('Package Inclusions') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-skyblue shadow-sm group-hover:bg-skyblue group-hover:text-white transition-colors">
                                    <i data-lucide="user-check" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-black text-brandblue uppercase tracking-widest">{{ __('Expert Local Guide') }}</span>
                            </div>
                            <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-skyblue shadow-sm group-hover:bg-skyblue group-hover:text-white transition-colors">
                                    <i data-lucide="bus" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-black text-brandblue uppercase tracking-widest">{{ __('VIP Transport') }}</span>
                            </div>
                            <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-skyblue shadow-sm group-hover:bg-skyblue group-hover:text-white transition-colors">
                                    <i data-lucide="utensils" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-black text-brandblue uppercase tracking-widest">{{ __('Gourmet Dinner') }}</span>
                            </div>
                            <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-skyblue shadow-sm group-hover:bg-skyblue group-hover:text-white transition-colors">
                                    <i data-lucide="camera" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-black text-brandblue uppercase tracking-widest">{{ __('Digital Memories') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Premium Booking Sidebar -->
            <div class="w-full lg:w-[450px] shrink-0">
                <div class="bg-brandblue rounded-[4rem] p-12 text-white shadow-2xl shadow-brandblue/20 sticky top-32">
                    <div class="space-y-2 mb-12">
                        <p class="text-[10px] font-black text-skyblue uppercase tracking-[0.4em]">{{ __('Base Package') }}</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-sm font-bold opacity-60">IDR</span>
                            <span class="text-5xl font-black italic tracking-tighter">{{ number_format($tour->price, 0, ',', '.') }}</span>
                            <span class="text-xs font-bold opacity-60">/ pax</span>
                        </div>
                    </div>

                    @auth
                    <form action="{{ route('tours.book', $tour->id) }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Select Date') }}</label>
                            <input type="date" name="date" required 
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Total Guests') }}</label>
                            <div class="relative">
                                <select name="guests" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue transition-all outline-none appearance-none cursor-pointer">
                                    @for($i=1; $i<=10; $i++) 
                                        <option value="{{ $i }}" class="text-brandblue">{{ $i }} {{ $i > 1 ? __('Persons') : __('Person') }}</option> 
                                    @endfor
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-skyblue"></i>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-6 bg-gradient-to-r from-skyblue to-blue-400 hover:from-white hover:to-white hover:text-brandblue text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all duration-700 shadow-xl shadow-skyblue/20 group relative overflow-hidden">
                            <span class="relative z-10">{{ __('Book Experience') }}</span>
                            <div class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        </button>
                    </form>
                    @else
                    <div class="space-y-8">
                        <p class="text-sm font-medium text-white/60 leading-relaxed italic">{{ __('Login to your account to unlock exclusive member rates and secure your spot.') }}</p>
                        <a href="{{ route('login') }}" class="block w-full py-6 bg-white text-brandblue rounded-[2rem] text-xs font-black text-center uppercase tracking-[0.4em] hover:bg-skyblue hover:text-white transition-all duration-500 shadow-xl">
                            {{ __('Login & Book') }}
                        </a>
                        <p class="text-[10px] text-center font-bold text-white/40 uppercase tracking-widest leading-none">
                            {{ __('Not a member?') }} <a href="{{ route('register') }}" class="text-skyblue border-b border-skyblue/30">{{ __('Join the club') }}</a>
                        </p>
                    </div>
                    @endauth

                    <div class="mt-16 pt-12 border-t border-white/5">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-2xl bg-skyblue/10 flex items-center justify-center text-skyblue">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] italic">{{ __('Safety Certified') }}</p>
                        </div>
                        <p class="text-[10px] text-white/40 leading-relaxed font-medium">
                            {{ __('All-in service includes professional guide, premium transport, and insurance coverage.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush
