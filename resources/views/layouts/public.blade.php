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
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Global Scroll Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-zoom {
            opacity: 0;
            transform: scale(0.9);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-zoom.active {
            opacity: 1;
            transform: scale(1);
        }
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
    <nav x-data="{ mobileMenuOpen: false }" class="bg-white z-50 sticky top-0 shadow-sm relative">
        <div class="px-4 md:px-8 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2 md:gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Nusajaya Travel" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover border-2 border-slate-100 shadow-sm">
                <span class="font-black italic text-xl md:text-2xl text-brandblue">VisitToBatam<span class="text-skyblue">.com</span></span>
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex gap-8 text-base font-semibold text-slate-500">
                <a href="{{ url('/') }}" class="hover:text-brandblue transition {{ request()->is('/') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('tours.index') }}" class="hover:text-brandblue transition {{ request()->is('tours*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Tours') }}</a>
                <a href="{{ route('transport.index') }}" class="hover:text-brandblue transition {{ request()->is('transport*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('Transport') }}</a>
                <a href="{{ route('about') }}" class="hover:text-brandblue transition {{ request()->is('about*') ? 'text-brandblue border-b-2 border-brandblue pb-1' : '' }}">{{ __('About') }}</a>
            </div>

            <!-- Auth & Hamburger -->
            <div class="flex items-center gap-4 md:gap-6">
                <!-- Desktop Auth -->
                <div class="hidden md:flex items-center gap-6">
                    @auth
                        <div class="flex items-center gap-4" x-data="{ open: false }">
                            <div class="hidden lg:block text-right">
                                <p class="text-xs font-bold text-brandblue leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ auth()->user()->role }}</p>
                            </div>
                            
                            <!-- Dropdown Trigger -->
                            <div class="relative">
                                <button @click="open = !open" 
                                        class="w-10 h-10 rounded-full bg-skyblue text-white font-bold border-2 border-white shadow-sm hover:ring-2 hover:ring-skyblue/30 transition relative group">
                                    <div class="w-full h-full rounded-full overflow-hidden flex items-center justify-center">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="Profile">
                                        @else
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    
                                    <!-- Small Down Arrow -->
                                    <div class="absolute -right-1 -bottom-1 bg-white rounded-full p-0.5 text-brandblue shadow-xs z-10 border border-slate-100 group-hover:-translate-y-0.5 transition-transform">
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
                                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
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

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center gap-3">
                    @auth
                        <!-- Small Profile Avatar for Mobile -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-8 h-8 rounded-full bg-skyblue flex items-center justify-center text-white font-bold border border-white shadow-sm overflow-hidden">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="Profile">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            @endif
                        </button>
                    @endauth

                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-brandblue p-1 focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden absolute top-full left-0 w-full bg-white border-t border-slate-100 shadow-xl z-[60]">
            
            <div class="px-6 py-4 flex flex-col space-y-4">
                <a href="{{ url('/') }}" class="text-base font-bold {{ request()->is('/') ? 'text-brandblue' : 'text-slate-500' }}">{{ __('Home') }}</a>
                <a href="{{ route('tours.index') }}" class="text-base font-bold {{ request()->is('tours*') ? 'text-brandblue' : 'text-slate-500' }}">{{ __('Tours') }}</a>
                <a href="{{ route('transport.index') }}" class="text-base font-bold {{ request()->is('transport*') ? 'text-brandblue' : 'text-slate-500' }}">{{ __('Transport') }}</a>
                <a href="{{ route('about') }}" class="text-base font-bold {{ request()->is('about*') ? 'text-brandblue' : 'text-slate-500' }}">{{ __('About') }}</a>
                
                <hr class="border-slate-100">
                
                @auth
                    <div class="py-2">
                        <p class="text-xs font-black text-brandblue mb-1">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 mb-4">{{ auth()->user()->email }}</p>
                        
                        <div class="flex flex-col space-y-3">
                            @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-skyblue">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('user.profile') }}" class="text-xs font-bold text-slate-600">My Profile</a>
                            <a href="{{ route('orders.my') }}" class="text-xs font-bold text-slate-600">My Orders</a>
                            <a href="{{ route('user.calendar') }}" class="text-xs font-bold text-slate-600">Calendar</a>
                            <a href="{{ route('user.preferences') }}" class="text-xs font-bold text-slate-600">Preferences</a>
                            
                            <form action="{{ route('logout') }}" method="POST" class="pt-2">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-red-500">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex gap-3 pt-2 pb-2">
                        <a href="{{ route('login') }}" class="flex-1 text-base font-bold text-brandblue border border-brandblue text-center py-2 rounded-lg hover:bg-brandblue hover:text-white transition">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="flex-1 text-base font-bold bg-brandblue text-white border border-brandblue text-center py-2 rounded-lg hover:bg-slate-800 transition">{{ __('Sign Up') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer Space Out -->
    @yield('footer', view('layouts.footer_default'))

    @stack('scripts')
    <script>
        lucide.createIcons();

        // Global Scroll Reveal Logic
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-zoom');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            revealElements.forEach(el => revealObserver.observe(el));
        });
    </script>
    {{-- ============================================================ --}}
    {{-- GLOBAL CUSTOM CONFIRM MODAL --}}
    {{-- ============================================================ --}}
    <div id="customConfirmOverlay"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-slate-900/70 backdrop-blur-md hidden"
         style="transition: opacity 0.25s ease;">
        <div id="customConfirmBox"
             class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            <div id="confirmAccentBar" class="h-1.5 w-full bg-red-500"></div>
            <div class="p-10">
                <div class="flex items-start gap-6 mb-8">
                    <div id="confirmIconWrap" class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 shadow-lg bg-red-50">
                        <i id="confirmIcon" data-lucide="alert-triangle" class="w-8 h-8 text-red-500"></i>
                    </div>
                    <div>
                        <h3 id="confirmTitle" class="text-xl font-black text-slate-900 uppercase tracking-tight italic leading-tight mb-2">Confirm Action</h3>
                        <p id="confirmMessage" class="text-sm text-slate-500 font-medium leading-relaxed">Are you sure you want to proceed?</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button id="confirmCancelBtn" class="flex-1 py-4 bg-slate-50 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-100 transition-all duration-300">Cancel</button>
                    <button id="confirmOkBtn" class="flex-1 py-4 bg-red-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 transition-all duration-300 shadow-xl shadow-red-500/20">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    window.customConfirm = function(message, onConfirm, opts = {}) {
        const type    = opts.type    || 'danger';
        const title   = opts.title   || (type === 'danger' ? 'Delete Confirmation' : 'Are You Sure?');
        const okText  = opts.okText  || (type === 'danger' ? 'Yes, Delete' : 'Yes, Proceed');
        const okClass = type === 'danger' ? 'bg-red-500 hover:bg-red-600 shadow-red-500/20' : 'bg-amber-500 hover:bg-amber-600 shadow-amber-500/20';
        const iconColor = type === 'danger' ? 'text-red-500' : 'text-amber-500';
        const iconBg    = type === 'danger' ? 'bg-red-50'    : 'bg-amber-50';
        const barColor  = type === 'danger' ? 'bg-red-500'   : 'bg-amber-500';
        const iconName  = type === 'danger' ? 'trash-2'      : 'alert-triangle';

        const overlay = document.getElementById('customConfirmOverlay');
        const box     = document.getElementById('customConfirmBox');

        document.getElementById('confirmTitle').textContent   = title;
        document.getElementById('confirmMessage').textContent = message;
        document.getElementById('confirmAccentBar').className = 'h-1.5 w-full ' + barColor;

        const iconWrap = document.getElementById('confirmIconWrap');
        iconWrap.className = 'w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 shadow-lg ' + iconBg;
        const iconEl = document.getElementById('confirmIcon');
        iconEl.setAttribute('data-lucide', iconName);
        iconEl.className = 'w-8 h-8 ' + iconColor;
        lucide.createIcons({ nodes: [iconEl] });

        overlay.classList.remove('hidden');
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        });

        function close() {
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.classList.add('hidden'), 250);
        }

        const okBtn = document.getElementById('confirmOkBtn');
        const cancelBtn = document.getElementById('confirmCancelBtn');
        const newOk = okBtn.cloneNode(true);
        const newCancel = cancelBtn.cloneNode(true);
        okBtn.parentNode.replaceChild(newOk, okBtn);
        cancelBtn.parentNode.replaceChild(newCancel, cancelBtn);
        newOk.textContent     = okText;
        newCancel.textContent = 'Cancel';
        newOk.className       = 'flex-1 py-4 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-xl ' + okClass;
        newCancel.className   = 'flex-1 py-4 bg-slate-50 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-100 transition-all duration-300';

        newOk.addEventListener('click', () => { close(); if (onConfirm) onConfirm(); });
        newCancel.addEventListener('click', close);
        overlay.addEventListener('click', function handler(e) {
            if (e.target === overlay) { close(); overlay.removeEventListener('click', handler); }
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[data-confirm]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const msg    = form.getAttribute('data-confirm');
                const type   = form.getAttribute('data-confirm-type') || 'danger';
                const title  = form.getAttribute('data-confirm-title') || undefined;
                const okText = form.getAttribute('data-confirm-ok') || undefined;
                customConfirm(msg, function() { form.submit(); }, { type, title, okText });
            });
        });
    });
    </script>
</body>
</html>
