<!DOCTYPE html>
@php
    App::setLocale(auth()->user()->language ?? 'en');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()->theme == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusajaya Travel - Management Panel ✨</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(241, 245, 249, 1);
        }
        .dark .glass-sidebar {
            background: rgba(15, 23, 42, 0.8);
            border-right: 1px solid rgba(30, 41, 59, 1);
        }
        .dark body {
            background-color: #0f172a;
            color: #f1f5f9;
        }
        .dark .bg-white {
            background-color: #1e293b !important;
        }
        .dark .text-slate-800, .dark .text-slate-900 {
            color: #f1f5f9 !important;
        }
        .dark .text-slate-500, .dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        .dark .border-slate-100, .dark .border-slate-50 {
            border-color: #334155 !important;
        }
        .dark .bg-slate-50, .dark .bg-slate-100 {
            background-color: #334155 !important;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 glass-sidebar flex-shrink-0 hidden md:flex flex-col z-50">
            <div class="p-8">
                <div class="flex items-center space-x-3">
                    <div>
                        <h1 class="text-lg font-black tracking-tighter text-slate-900 uppercase italic">{{ __('Nusa Jaya Indofast T&T') }}</h1>
                        <p class="text-[10px] font-bold text-sky-500 uppercase tracking-widest -mt-1">{{ __('Admin Panel System') }}</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8 px-6 space-y-3 flex-1 overflow-y-auto">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-4">{{ __('Main Menu') }}</p>
                
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="layout-grid" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="ticket" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Booking Requests') }}
                </a>

                <a href="{{ route('admin.armadas.index') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.armadas.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="bus" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Manage Fleets') }}
                </a>

                <a href="{{ route('admin.tours.index') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.tours.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="map" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Tour Packages') }}
                </a>

                <a href="{{ route('admin.promotions.index') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.promotions.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="megaphone" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Promotions') }}
                </a>

                @if(auth()->user()->role === 'superadmin')
                <div class="h-px bg-slate-50 my-6 mx-6"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-4">{{ __('Management') }}</p>
                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i data-lucide="users" class="w-5 h-5 mr-4 transition-transform group-hover:scale-110"></i>
                    {{ __('Manage Users') }}
                </a>
                @endif
            </nav>


        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Header/Top Nav -->
            <header class="h-20 bg-white/50 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 z-40">
                <div class="flex items-center bg-slate-100 px-4 py-2 rounded-2xl w-96 border border-slate-200/50">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-3"></i>
                    <input type="text" placeholder="{{ __('Search bookings, fleets, or packages...') }}" class="bg-transparent border-none outline-none text-sm w-full text-slate-600 placeholder:text-slate-400">
                </div>
                
                <div class="flex items-center justify-end flex-1 space-x-6">
                    <button class="relative p-2 text-slate-400 hover:text-blue-600 transition-colors">
                        <i data-lucide="bell" class="w-6 h-6"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative group pl-6 border-l border-slate-100">
                        <button class="flex items-center space-x-4 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-black text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-100 group-hover:scale-105 transition-transform overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="{{ Auth::user()->name }}">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-4 w-64 bg-white rounded-[2rem] shadow-2xl shadow-slate-200 border border-slate-50 py-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="px-6 py-4 border-b border-slate-50 mb-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Account System') }}</p>
                            </div>
                            
                            <a href="{{ route('admin.profile') }}" class="flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.profile') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                <i data-lucide="user" class="w-4 h-4 mr-3"></i>
                                {{ __('My Profile') }}
                            </a>
                            <a href="{{ route('admin.preferences') }}" class="flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.preferences') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                <i data-lucide="settings" class="w-4 h-4 mr-3"></i>
                                {{ __('Preferences') }}
                            </a>
                            <a href="{{ route('admin.security') }}" class="flex items-center px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.security') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                <i data-lucide="shield-check" class="w-4 h-4 mr-3"></i>
                                {{ __('Security') }}
                            </a>
                            
                            <div class="mt-4 pt-4 border-t border-slate-50 px-4">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-6 py-3 text-sm font-black text-red-500 bg-red-50 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-300">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3"></i>
                                        {{ __('Logout System') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-10 bg-[#F8FAFC]">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-500 text-white rounded-[2rem] shadow-lg shadow-emerald-200 flex items-center animate-in fade-in slide-in-from-top-4">
                        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </div>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
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
