<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT Nusa Jaya Indofast Tour & Travel')</title>
    <!-- Tailwind CSS (CDN for quick styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
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
        <a href="{{ url('/') }}" class="flex items-center tracking-tighter">
            <span class="font-black italic text-2xl text-brandblue">VisitToBatam<span class="text-skyblue">.com</span></span>
        </a>
        <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-500">
            <a href="{{ url('/') }}" class="hover:text-brandblue transition {{ request()->is('/') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">Home</a>
            <a href="{{ route('tours.index') }}" class="hover:text-brandblue transition {{ request()->is('tours*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">Tours</a>
            <a href="{{ route('transport.index') }}" class="hover:text-brandblue transition {{ request()->is('transport*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">Transport</a>
            @auth
                <a href="{{ route('orders.my') }}" class="hover:text-brandblue transition {{ request()->is('orders*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">My Order</a>
            @else
                <a href="{{ route('about') ?? '#' }}" class="hover:text-brandblue transition {{ request()->is('about*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">About</a>
            @endauth
        </div>
        <div class="flex items-center gap-6">
            @auth
                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-xs font-bold text-brandblue leading-tight">{{ auth()->user()->name }}</p>
                    </div>
                    <a href="{{ auth()->user()->role === 'admin' ? url('/dashboard') : url('/') }}" class="w-10 h-10 rounded-full bg-skyblue flex items-center justify-center text-white font-bold border-2 border-white shadow-sm overflow-hidden hover:opacity-80 transition">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-brandblue hover:text-skyblue">Login</a>
                <a href="{{ route('register') }}" class="bg-brandblue text-white px-5 py-2 rounded text-sm font-semibold hover:bg-slate-800 transition">Sign Up</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer Space Out -->
    @yield('footer', view('layouts.footer_default'))
</body>
</html>
