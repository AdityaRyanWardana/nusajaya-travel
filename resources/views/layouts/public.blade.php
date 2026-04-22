<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT Nusa Jaya Indofast Tour & Travel')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Tailwind CSS (CDN for quick styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandblue: '#0B2447',
                        lightbg: '#F8F9FA',
                        skyblue: '#38BDF8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-lightbg text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white px-8 py-4 flex justify-between items-center z-50 sticky top-0 shadow-sm">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Nusajaya Travel" class="w-10 h-10 rounded-full object-cover border-2 border-slate-100 shadow-sm">
            <span class="font-black italic text-2xl text-brandblue">VisitToBatam<span class="text-skyblue">.com</span></span>
        </a>
        <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-500">
            <a href="{{ url('/') }}" class="hover:text-brandblue transition {{ request()->is('/') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Home') }}</a>
            <a href="{{ route('tours.index') }}" class="hover:text-brandblue transition {{ request()->is('tours*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Tours') }}</a>
            <a href="{{ route('transport.index') }}" class="hover:text-brandblue transition {{ request()->is('transport*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Transport') }}</a>
            <a href="{{ route('about') }}" class="hover:text-brandblue transition {{ request()->is('about*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('About') }}</a>
        </div>
        <div class="flex items-center gap-6">
            @auth
                <div class="flex items-center gap-4" x-data="{ open: false }">
                    <div class="hidden sm:block text-right">
                        <p class="text-xs font-bold text-brandblue leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ auth()->user()->role }}</p>
                    </div>
                    
                    <!-- Dropdown Trigger -->
                    <div class="relative">
                        <button @click="open = !open" 
                                class="w-10 h-10 rounded-full bg-skyblue flex items-center justify-center text-white font-bold border-2 border-white shadow-sm overflow-hidden hover:ring-2 hover:ring-skyblue/30 transition relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="Profile">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            @endif
                            
                            <!-- Small Down Arrow -->
                            <div class="absolute -right-1 -bottom-1 bg-white rounded-full p-0.5 text-brandblue shadow-xs">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-[60]">
                            
                            <div class="px-4 py-3 border-b border-slate-50 mb-2">
                                <p class="text-xs font-bold text-brandblue">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-skyblue bg-skyblue/5 hover:bg-skyblue hover:text-white transition rounded-xl mx-2 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ __('Go to Admin Panel') }}
                                </a>
                            @endif

                            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brandblue transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ __('My Profile') }}
                            </a>
                            <a href="{{ route('orders.my') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brandblue transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                {{ __('My Orders') }}
                            </a>
                            <a href="{{ route('user.calendar') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brandblue transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ __('Calendar') }}
                            </a>
                            
                            <div class="h-px bg-slate-100 my-2"></div>

                            <a href="{{ route('user.preferences') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brandblue transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Preferences
                            </a>

                            <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-slate-50">
                                @csrf
                                <button type="submit" class="w-full h-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-brandblue hover:text-skyblue">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="bg-brandblue text-white px-5 py-2 rounded text-sm font-semibold hover:bg-slate-800 transition">{{ __('Sign Up') }}</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer Space Out -->
    @yield('footer', view('layouts.footer_default'))

    @stack('scripts')
</body>
</html>
