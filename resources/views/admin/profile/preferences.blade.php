@extends('layouts.admin')

@section('content')
<div class="max-w-5xl space-y-8 animate-fade-in-up">
    <div>
        <h2 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight italic uppercase">{{ __('System Preferences') }}</h2>
        <p class="text-slate-400 dark:text-slate-400 font-medium mt-2 italic text-lg">{{ __('Customize your dashboard experience and notification settings.') }}</p>
    </div>

    <form action="{{ route('admin.preferences.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Dashboard Appearance -->
        <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm p-12 transition-all duration-500" x-data="{ currentTheme: '{{ auth()->user()->theme }}', currentLang: '{{ auth()->user()->language }}' }">
            <div class="flex items-center space-x-4 mb-10">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center shadow-inner">
                    <i data-lucide="palette" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase italic tracking-tight">{{ __('Appearance') }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Control how the system looks and feels') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Theme Selector --}}
                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">{{ __('Interface Theme') }}</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="hidden" name="theme" :value="currentTheme">
                        <button type="button" @click="currentTheme = 'light'; document.documentElement.classList.remove('dark')" 
                                :class="currentTheme === 'light' ? 'border-blue-600 ring-4 ring-blue-600/5 bg-blue-50/50' : 'border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-800'"
                                class="flex flex-col items-center gap-4 p-6 rounded-[2rem] border-2 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-amber-500 shadow-sm group-hover:scale-110 transition-transform">
                                <i data-lucide="sun" class="w-7 h-7"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">{{ __('Premium Light') }}</span>
                        </button>
                        <button type="button" @click="currentTheme = 'dark'; document.documentElement.classList.add('dark')" 
                                :class="currentTheme === 'dark' ? 'border-blue-600 ring-4 ring-blue-600/5 bg-slate-800' : 'border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-800'"
                                class="flex flex-col items-center gap-4 p-6 rounded-[2rem] border-2 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-blue-400 shadow-sm group-hover:scale-110 transition-transform">
                                <i data-lucide="moon" class="w-7 h-7"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">{{ __('Modern Dark') }}</span>
                        </button>
                    </div>
                </div>

                {{-- Language Selector --}}
                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">{{ __('System Language') }}</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="hidden" name="language" :value="currentLang">
                        <button type="button" @click="currentLang = 'en'" 
                                :class="currentLang === 'en' ? 'border-blue-600 ring-4 ring-blue-600/5 bg-blue-50/50' : 'border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-800'"
                                class="flex flex-col items-center gap-4 p-6 rounded-[2rem] border-2 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                                <span class="text-sm font-black italic">EN</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">{{ __('English') }}</span>
                        </button>
                        <button type="button" @click="currentLang = 'id'" 
                                :class="currentLang === 'id' ? 'border-blue-600 ring-4 ring-blue-600/5 bg-blue-50/50' : 'border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-800'"
                                class="flex flex-col items-center gap-4 p-6 rounded-[2rem] border-2 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                                <span class="text-sm font-black italic">ID</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">{{ __('Bahasa') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm p-12 transition-all duration-500">
            <div class="flex items-center space-x-4 mb-10">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center shadow-inner">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase italic tracking-tight">{{ __('Notifications') }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Manage your alert preferences') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center justify-between p-8 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100/50 dark:border-slate-700/50 group hover:border-blue-500/30 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-xl flex items-center justify-center text-slate-400 dark:text-slate-500">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 dark:text-slate-200">{{ __('Email Alerts') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 italic mt-0.5">{{ __('Receive booking updates via email.') }}</p>
                        </div>
                    </div>
                    <div class="w-12 h-6 bg-blue-600 rounded-full relative cursor-pointer shadow-lg shadow-blue-500/20">
                        <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-8 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100/50 dark:border-slate-700/50 group hover:border-blue-500/30 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-xl flex items-center justify-center text-slate-400 dark:text-slate-500">
                            <i data-lucide="bell-ring" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 dark:text-slate-200">{{ __('Browser Push') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 italic mt-0.5">{{ __('Real-time desktop alerts.') }}</p>
                        </div>
                    </div>
                    <div class="w-12 h-6 bg-slate-200 dark:bg-slate-700 rounded-full relative cursor-pointer transition-colors">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white dark:bg-slate-400 rounded-full shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
            <p class="text-xs font-bold text-slate-400 italic">
                {{ __('Settings will be applied immediately after saving.') }}
            </p>
            <button type="submit" class="bg-blue-600 text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 dark:hover:bg-white dark:hover:text-slate-900 transition-all duration-500 shadow-2xl shadow-blue-500/20 flex items-center group">
                <i data-lucide="save" class="w-4 h-4 mr-3 group-hover:scale-125 transition-transform"></i>
                {{ __('Apply Preferences') }}
            </button>
        </div>
    </form>
</div>
    </form>
</div>
@endsection
