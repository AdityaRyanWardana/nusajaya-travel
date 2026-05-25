<!DOCTYPE html>
@php
    App::setLocale(auth()->user()->language ?? 'en');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->check() && auth()->user()->theme === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusajaya Travel - Management Panel ✨</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        .glass-sidebar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
                .nav-item-active {
            background: #38BDF8;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(56, 189, 248, 0.3);
        }

        
        
        
        
        
        
        
        

        /* Sidebar & Header Premium Light Standard */
        aside, header {
            transition: background-color 0.5s ease, border-color 0.5s ease;
        }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#0B2447] dark:bg-[#091524] dark:text-slate-100 antialiased transition-colors duration-500">
    <div class="flex h-screen overflow-hidden relative" 
         x-data="{ 
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            mobileMenuOpen: false
         }"
         x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))">
        
        <!-- Mobile Backdrop -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[45] md:hidden"
             x-cloak></div>
        
        <!-- Sidebar -->
        <aside :class="[
                   sidebarCollapsed ? 'md:w-24' : 'md:w-72',
                   mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
               ]"                class="glass-sidebar bg-white dark:bg-[#0B2447] border-r border-slate-100 dark:border-[#1A365D] flex-shrink-0 fixed md:relative inset-y-0 left-0 w-72 flex flex-col z-50 transition-all duration-500 shadow-2xl md:shadow-none">
            
            <!-- Logo Section - Fixed Reliability -->
            <div class="h-24 flex items-center justify-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                    <div class="relative flex items-center justify-center">
                        <!-- Expanded Logo -->
                        <div x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-2" class="flex items-center gap-4 px-8">
                            <div class="w-11 h-11 bg-[#38BDF8] rounded-[0.9rem] flex items-center justify-center text-white shadow-xl shadow-sky-400/20 group-hover:scale-105 transition-transform duration-300 shrink-0">
                                <i data-lucide="compass" class="w-6 h-6"></i>
                            </div>
                            <div class="flex flex-col whitespace-nowrap">
                                <h1 class="text-sm font-black tracking-tight text-slate-900 dark:text-white uppercase italic leading-none">{{ __('Nusa Jaya') }}</h1>
                                <p class="text-[9px] font-extrabold text-sky-500 dark:text-[#38BDF8] uppercase tracking-widest mt-1.5">{{ __('Indofast T&T') }}</p>
                            </div>
                        </div>

                        <!-- Minimized Logo (N) -->
                        <div x-show="sidebarCollapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" class="flex items-center justify-center">
                            <div class="w-12 h-12 bg-[#38BDF8] rounded-2xl flex items-center justify-center text-white font-black italic text-xl shadow-xl shadow-sky-400/20 group-hover:scale-110 transition-all duration-300">
                                <span>N</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <nav class="mt-4 px-4 space-y-1.5 flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
                <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-black text-slate-400 dark:text-slate-300 uppercase tracking-[0.25em] px-6 mb-4 whitespace-nowrap mt-4">{{ __('General Navigation') }}</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Dashboard' : ''">
                    <i data-lucide="layout-grid" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Dashboard') }}</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.bookings.*') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Bookings' : ''">
                    <i data-lucide="ticket" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Bookings') }}</span>
                </a>

                <a href="{{ route('admin.scheduling') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.scheduling') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Scheduling' : ''">
                    <i data-lucide="calendar-days" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Scheduling') }}</span>
                </a>

                <a href="{{ route('admin.armadas.index') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.armadas.*') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Fleets' : ''">
                    <i data-lucide="bus" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Fleets') }}</span>
                </a>

                <a href="{{ route('admin.tours.index') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.tours.*') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Tours' : ''">
                    <i data-lucide="map" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Tours') }}</span>
                </a>

                <a href="{{ route('admin.promotions.index') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.promotions.*') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Promotions' : ''">
                    <i data-lucide="megaphone" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Promotions') }}</span>
                </a>

                @if(auth()->user()->role === 'superadmin')
                <div class="h-px bg-slate-50 dark:bg-[#1A365D] my-6 mx-6"></div>
                <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-black text-slate-400  uppercase tracking-[0.25em] px-6 mb-4 whitespace-nowrap">{{ __('Administration') }}</p>
                <a href="{{ route('admin.users.index') }}" 
                   class="group flex items-center px-6 py-4 text-sm font-bold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'nav-item-active' : 'text-slate-500  hover:bg-slate-50  hover:text-sky-500 ' }}"
                   :title="sidebarCollapsed ? 'Users' : ''">
                    <i data-lucide="users" class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" :class="sidebarCollapsed ? 'mx-auto' : 'mr-5'"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="whitespace-nowrap">{{ __('Manage Users') }}</span>
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Header -->
            <header class="h-24 bg-white dark:bg-[#0B2447] border-b border-slate-100 dark:border-[#1A365D] flex items-center justify-between px-10 z-40 sticky top-0 transition-colors duration-500">
                <div class="flex items-center gap-8">
                    <!-- Improved Toggle Button -->
                    <button @click="if(window.innerWidth < 768) { mobileMenuOpen = !mobileMenuOpen } else { sidebarCollapsed = !sidebarCollapsed }" 
                            class="w-12 h-12 bg-white dark:bg-[#0F2038] rounded-2xl flex items-center justify-center text-slate-400 dark:text-slate-300 hover:text-sky-500 transition-all duration-300 shadow-sm border border-slate-100 dark:border-[#1E3A5F] group">
                        <i data-lucide="menu" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    </button>

                    <div class="hidden lg:flex items-center bg-slate-50 dark:bg-[#0F2038] px-6 py-3.5 rounded-2xl w-[28rem] border border-slate-100 dark:border-[#1E3A5F] focus-within:bg-white dark:focus-within:bg-[#0B2447] focus-within:ring-4 focus-within:ring-sky-400/5 transition-all">
                        <i data-lucide="search" class="w-5 h-5 text-slate-300  mr-4"></i>
                        <input type="text" placeholder="{{ __('Search for anything...') }}" class="bg-transparent border-none outline-none text-sm w-full text-slate-600  font-bold placeholder:text-slate-300 ">
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="flex items-center gap-3 pr-6 border-r border-slate-100  relative" x-data="{ notificationsOpen: false }">
                        <button @click="notificationsOpen = !notificationsOpen" 
                                class="w-10 h-10 bg-slate-50 dark:bg-[#0F2038] rounded-xl flex items-center justify-center text-slate-400 dark:text-slate-300 hover:text-sky-500 hover:bg-sky-50 dark:hover:bg-[#1A365D] transition-all relative">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 border-2 border-white  rounded-full animate-pulse"></span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="notificationsOpen" 
                             @click.away="notificationsOpen = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute top-full right-0 mt-4 w-80 bg-white dark:bg-[#0F2038] rounded-[2rem] shadow-2xl shadow-slate-200 dark:shadow-black/50 border border-slate-50 dark:border-[#1E3A5F] overflow-hidden z-50"
                             x-cloak>
                            <div class="p-6 bg-slate-50/50  border-b border-slate-50  flex items-center justify-between">
                                <h4 class="text-xs font-black text-slate-900  uppercase tracking-widest">{{ __('Notifications') }}</h4>
                                <span class="text-[9px] font-black bg-[#38BDF8] text-white px-2 py-0.5 rounded-full">3 New</span>
                            </div>
                            <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
                                {{-- Sample Notifications with Links --}}
                                <a href="{{ route('admin.bookings.index') }}" class="block p-4 hover:bg-slate-50  transition-all cursor-pointer border-b border-slate-50  group">
                                    <div class="flex gap-4">
                                        <div class="w-10 h-10 bg-sky-50  text-sky-500  rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-slate-800 ">{{ __('New Booking: Batam City Tour') }}</p>
                                            <p class="text-[9px] text-slate-400 mt-0.5">2 minutes ago</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('admin.scheduling') }}" class="block p-4 hover:bg-slate-50  transition-all cursor-pointer border-b border-slate-50  group">
                                    <div class="flex gap-4">
                                        <div class="w-10 h-10 bg-amber-50  text-amber-600  rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-slate-800 ">{{ __('Reschedule Request: VIP Bus') }}</p>
                                            <p class="text-[9px] text-slate-400 mt-0.5">1 hour ago</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('admin.bookings.index') }}" class="block p-4 hover:bg-slate-50  transition-all cursor-pointer group">
                                    <div class="flex gap-4">
                                        <div class="w-10 h-10 bg-emerald-50  text-emerald-600  rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-slate-800 ">{{ __('Payment Confirmed: #BOK-9921') }}</p>
                                            <p class="text-[9px] text-slate-400 mt-0.5">5 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="{{ route('admin.bookings.index') }}" class="block p-4 text-center text-[10px] font-black text-sky-500  uppercase tracking-[0.2em] bg-slate-50  hover:bg-[#38BDF8] hover:text-white transition-all">
                                {{ __('View All Notifications') }}
                            </a>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-4 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-[11px] font-black text-slate-900 dark:text-white leading-none uppercase tracking-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400  uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-600 p-0.5 shadow-lg shadow-sky-400/20 group-hover:scale-105 transition-transform overflow-hidden">
                                <div class="w-full h-full rounded-[0.9rem] bg-white  flex items-center justify-center overflow-hidden">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="{{ Auth::user()->name }}">
                                    @else
                                        <span class="text-sky-500  font-black text-lg uppercase italic">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-64 bg-white rounded-3xl shadow-2xl shadow-slate-200  border border-slate-50  py-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="px-6 py-3 border-b border-slate-50  mb-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Account Settings') }}</p>
                            </div>
                            
                            <div class="px-3 space-y-1">
                                <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-3 text-sm font-bold text-slate-600  hover:bg-sky-50  hover:text-sky-500  rounded-2xl transition-all">
                                    <i data-lucide="user" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-sky-500"></i>
                                    {{ __('My Profile') }}
                                </a>
                                <a href="{{ route('admin.preferences') }}" class="flex items-center px-4 py-3 text-sm font-bold text-slate-600  hover:bg-sky-50  hover:text-sky-500  rounded-2xl transition-all">
                                    <i data-lucide="settings" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-sky-500"></i>
                                    {{ __('Preferences') }}
                                </a>
                                <a href="{{ route('admin.security') }}" class="flex items-center px-4 py-3 text-sm font-bold text-slate-600  hover:bg-sky-50  hover:text-sky-500  rounded-2xl transition-all">
                                    <i data-lucide="shield-check" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-sky-500"></i>
                                    {{ __('Security') }}
                                </a>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-slate-50  px-3">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-4 text-xs font-black text-red-500 bg-red-50  rounded-2xl hover:bg-red-500 hover:text-white transition-all">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3"></i>
                                        {{ __('LOGOUT SYSTEM') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-10 bg-[#F8F9FA] dark:bg-[#091524] ">
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-[-10px]"
                         class="mb-8 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                            <span class="font-bold text-sm">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-white/80 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
