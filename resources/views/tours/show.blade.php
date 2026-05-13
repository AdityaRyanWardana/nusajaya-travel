@extends('layouts.public')

@section('content')
<main class="flex-1 bg-white px-8 py-12 pb-24">
    <div class="max-w-7xl mx-auto">
        @php
            $allImages = [];
            if ($tour->image) {
                $allImages[] = $tour->image_url;
            }
            if ($tour->images) {
                foreach($tour->images as $img) {
                    if (Str::startsWith($img, 'http')) {
                        $allImages[] = $img;
                    } elseif (Str::startsWith($img, 'images/')) {
                        $allImages[] = asset($img);
                    } else {
                        $allImages[] = asset('storage/' . $img);
                    }
                }
            }
            if (empty($allImages)) {
                $allImages[] = 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2070&auto=format&fit=crop';
            }
        @endphp

        <div x-data="{ 
            activeSlide: 0, 
            slides: {{ json_encode($allImages) }},
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
        }">
            <!-- Breadcrumb & Navigation -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-brandblue transition group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    {{ __('Back to All Packages') }}
                </a>
                <div class="flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                :class="activeSlide === index ? 'bg-skyblue w-6' : 'bg-slate-200 w-2'"
                                class="h-2 rounded-full transition-all duration-500 focus:outline-none"></button>
                    </template>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Left: Cinematic Content -->
                <div class="flex-grow space-y-12">
                    <!-- Main Image Card Slider -->
                    <div class="relative h-[600px] rounded-[4rem] overflow-hidden shadow-2xl group/slider bg-slate-100">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="activeSlide === index" 
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 scale-110"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-700"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute inset-0">
                                <img :src="slide" class="w-full h-full object-cover">
                            </div>
                        </template>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Navigation Arrows -->
                        <div class="absolute inset-y-0 left-8 flex items-center opacity-0 group-hover/slider:opacity-100 transition-opacity">
                            <button @click="prev()" class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white hover:bg-white hover:text-brandblue transition">
                                <i data-lucide="chevron-left" class="w-6 h-6"></i>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-8 flex items-center opacity-0 group-hover/slider:opacity-100 transition-opacity">
                            <button @click="next()" class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white hover:bg-white hover:text-brandblue transition">
                                <i data-lucide="chevron-right" class="w-6 h-6"></i>
                            </button>
                        </div>

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
                            @if($tour->inclusions && count($tour->inclusions) > 0)
                                @foreach($tour->inclusions as $inclusion)
                                    <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-skyblue shadow-sm group-hover:bg-skyblue group-hover:text-white transition-colors">
                                            <i data-lucide="{{ $inclusion['icon'] ?? 'check' }}" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-xs font-black text-brandblue uppercase tracking-widest">{{ __($inclusion['label'] ?? 'Service Included') }}</span>
                                    </div>
                                @endforeach
                            @else
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
                            @endif
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
                    <form action="{{ route('tours.book', $tour->id) }}" method="POST" class="space-y-8" 
                          x-data="{ 
                            step: 1,
                            guests: 1,
                            participants: [{ salutation: 'Mr', name: '{{ auth()->user()->name }}', identity: '' }],
                            updateParticipants() {
                                const count = parseInt(this.guests);
                                if (this.participants.length < count) {
                                    while (this.participants.length < count) {
                                        this.participants.push({ salutation: 'Mr', name: '', identity: '' });
                                    }
                                } else {
                                    this.participants = this.participants.slice(0, count);
                                }
                            },
                            nextStep() { 
                                if(this.step === 1) {
                                    // Basic validation for Step 1
                                    const dateInput = document.querySelector('input[name=date]');
                                    if(!dateInput.value) {
                                        alert('Please select a date');
                                        return;
                                    }
                                }
                                if(this.step < 3) this.step++ 
                            },
                            prevStep() { if(this.step > 1) this.step-- }
                          }">
                        @csrf
                        
                        <!-- Step Progress Indicator -->
                        <div class="flex items-center justify-between mb-12 px-2">
                            <div class="flex items-center gap-3">
                                <div :class="step >= 1 ? 'bg-skyblue' : 'bg-white/10 text-white/40'" class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black transition-all duration-500">1</div>
                                <div class="w-8 h-[2px]" :class="step >= 2 ? 'bg-skyblue' : 'bg-white/10'"></div>
                                <div :class="step >= 2 ? 'bg-skyblue' : 'bg-white/10 text-white/40'" class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black transition-all duration-500">2</div>
                                <div class="w-8 h-[2px]" :class="step >= 3 ? 'bg-skyblue' : 'bg-white/10'"></div>
                                <div :class="step >= 3 ? 'bg-skyblue' : 'bg-white/10 text-white/40'" class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black transition-all duration-500">3</div>
                            </div>
                            <span class="text-[10px] font-black text-skyblue uppercase tracking-widest" x-text="step === 1 ? 'Trip Setup' : (step === 2 ? 'Guest Info' : 'Logistics')"></span>
                        </div>

                        <!-- Step 1: Trip Configuration -->
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Select Date') }}</label>
                                <input type="date" name="date" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none text-white">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Total Guests') }}</label>
                                <div class="relative">
                                    <select name="guests" x-model="guests" @change="updateParticipants()" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue transition-all outline-none appearance-none cursor-pointer text-white">
                                        @for($i=1; $i<=10; $i++) 
                                            <option value="{{ $i }}" class="text-brandblue">{{ $i }} {{ $i > 1 ? __('Persons') : __('Person') }}</option> 
                                        @endfor
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-skyblue"></i>
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="nextStep()" class="w-full py-6 bg-white/10 hover:bg-white/20 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all duration-300 flex items-center justify-center gap-3 group">
                                {{ __('Next Step') }}
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>

                        <!-- Step 2: Participants Biodata -->
                        <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-8">
                            <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Participants Biodata') }}</label>
                            <div class="space-y-6 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="(participant, index) in participants" :key="index">
                                    <div class="p-8 bg-white/5 border border-white/10 rounded-[2.5rem] space-y-6 mb-4">
                                        <div class="flex items-center justify-between px-2">
                                            <span class="text-[10px] font-black text-skyblue uppercase tracking-[0.3em]" x-text="'Guest ' + (index + 1) + (index === 0 ? ' (Leader)' : '')"></span>
                                            <div class="flex gap-2">
                                                <template x-for="sal in ['Mr', 'Ms', 'Mrs']">
                                                    <button type="button" @click="participants[index].salutation = sal" 
                                                            :class="participants[index].salutation === sal ? 'bg-skyblue text-white' : 'bg-white/5 text-white/40 hover:bg-white/10'"
                                                            class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all" x-text="sal"></button>
                                                </template>
                                            </div>
                                            <input type="hidden" :name="'participants[' + index + '][salutation]'" x-model="participants[index].salutation">
                                        </div>

                                        <div class="space-y-4">
                                            <div class="space-y-3">
                                                <label class="block text-[9px] font-black text-white/30 uppercase tracking-widest ml-2">{{ __('Full Name') }}</label>
                                                <input type="text" :name="'participants[' + index + '][name]'" required x-model="participants[index].name"
                                                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none text-white" 
                                                       placeholder="As shown in Passport/ID">
                                            </div>
                                            <div class="space-y-3">
                                                <label class="block text-[9px] font-black text-white/30 uppercase tracking-widest ml-2">{{ __('Passport / ID Number') }}</label>
                                                <input type="text" :name="'participants[' + index + '][identity]'" required x-model="participants[index].identity"
                                                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none text-white" 
                                                       placeholder="Passport / KTP / NIK">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex gap-4">
                                <button type="button" @click="prevStep()" class="flex-1 py-6 bg-white/5 hover:bg-white/10 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all">
                                    {{ __('Back') }}
                                </button>
                                <button type="button" @click="nextStep()" class="flex-[2] py-6 bg-white text-brandblue hover:bg-skyblue hover:text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all flex items-center justify-center gap-3">
                                    {{ __('Continue') }}
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Logistics & Contact -->
                        <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Pickup Point') }}</label>
                                <div class="relative">
                                    <select name="pickup_point" required 
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue transition-all outline-none appearance-none cursor-pointer text-white">
                                        <option value="" class="text-brandblue" disabled selected>{{ __('Select Terminal / Location') }}</option>
                                        <option value="Batam Centre Ferry Terminal" class="text-brandblue">Batam Centre Ferry Terminal</option>
                                        <option value="Harbour Bay Ferry Terminal" class="text-brandblue">Harbour Bay Ferry Terminal</option>
                                        <option value="Sekupang Ferry Terminal" class="text-brandblue">Sekupang Ferry Terminal</option>
                                        <option value="Waterfront City Ferry Terminal" class="text-brandblue">Waterfront City Ferry Terminal</option>
                                        <option value="Nongsapura Ferry Terminal" class="text-brandblue">Nongsapura Ferry Terminal</option>
                                        <option value="Telaga Punggur Ferry Terminal" class="text-brandblue">Telaga Punggur Ferry Terminal</option>
                                        <option value="Other / Hotel (Specify in Notes)" class="text-brandblue">{{ __('Other / Hotel (Specify in Notes)') }}</option>
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-skyblue"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Contact Number (WhatsApp)') }}</label>
                                <input type="tel" name="customer_phone" required value="{{ auth()->user()->phone ?? '' }}"
                                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none text-white" placeholder="+62...">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-skyblue uppercase tracking-[0.2em] ml-2">{{ __('Special Notes (Optional)') }}</label>
                                <textarea name="notes" rows="3"
                                          class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:ring-2 focus:ring-skyblue focus:bg-white/10 transition-all outline-none resize-none text-white" placeholder="{{ __('Allergy, hotel pickup details, etc...') }}"></textarea>
                            </div>

                            <div class="flex gap-4">
                                <button type="button" @click="prevStep()" class="flex-1 py-6 bg-white/5 hover:bg-white/10 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all">
                                    {{ __('Back') }}
                                </button>
                                <button type="submit" class="flex-[2] py-6 bg-gradient-to-r from-skyblue to-blue-400 hover:from-white hover:to-white hover:text-brandblue text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.4em] transition-all duration-700 shadow-xl shadow-skyblue/20 group relative overflow-hidden">
                                    <span class="relative z-10">{{ __('Book Experience') }}</span>
                                    <div class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                </button>
                            </div>
                        </div>
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
