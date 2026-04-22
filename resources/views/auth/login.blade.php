<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusajaya Travel - Welcome Back ✨</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-5xl bg-white rounded-[3rem] shadow-2xl shadow-slate-200 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        <!-- Left Side: Branding/Visual -->
        <div class="md:w-1/2 bg-[#0B2447] p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-sky-400/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-sky-400/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-12">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-full border-2 border-sky-400/30 bg-white p-1">
                    <h1 class="text-2xl font-black tracking-tight uppercase italic text-sky-400 leading-tight">Nusa Jaya <br>Indofast T&T</h1>
                </div>
                
                <h2 class="text-4xl font-extrabold leading-[1.1] mb-6 italic uppercase tracking-tighter">Your Journey <br>Starts <br><span class="text-sky-400 not-italic tracking-normal lowercase">Here.</span></h2>
                <p class="text-slate-300 text-lg font-medium leading-relaxed max-w-sm">Experience the finest travel comfort in Batam with our premium transport and tour services.</p>
            </div>

            <div class="relative z-10 mt-12 pt-8 border-t border-white/10">
                <p class="text-[10px] font-black text-sky-400 uppercase tracking-[0.3em] mb-2">Trusted Partner</p>
                <p class="text-sm font-bold text-white/60 italic">PT Nusa Jaya Indofast T&T</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-1/2 p-12 md:p-20 flex flex-col justify-center bg-white">
            <div class="mb-10">
                <h3 class="text-3xl font-bold text-[#0B2447] mb-2 italic tracking-tight">Welcome Back</h3>
                <p class="text-slate-400 font-medium italic text-sm">Please sign in to continue your journey</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl animate-bounce">
                        <div class="flex items-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mr-3"></i>
                            <p class="text-xs font-bold text-red-600">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                <div>
                    <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" id="email" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="example@nusajaya.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3 ml-1">
                        <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Secret Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between ml-1">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500 transition-all">
                        <label for="remember" class="text-xs font-bold text-slate-500 select-none uppercase tracking-widest">Remember Me</label>
                    </div>
                    <a href="#" class="text-[10px] font-black text-sky-600 uppercase tracking-widest hover:text-[#0B2447]">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full bg-[#0B2447] text-white font-black py-5 rounded-[1.25rem] shadow-xl shadow-slate-200 hover:bg-slate-800 hover:shadow-sky-100 hover:-translate-y-0.5 transition-all active:scale-[0.98] uppercase tracking-widest text-xs flex items-center justify-center group">
                    Sign In Now
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <div class="mt-12 flex items-center justify-center space-x-4">
                <div class="h-[1px] flex-1 bg-slate-100"></div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Or</p>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            <p class="mt-8 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                Don't have an account? <a href="{{ route('register') }}" class="text-sky-600 hover:text-[#0B2447] transition-colors">Register Now</a>
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
