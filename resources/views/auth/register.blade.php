<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusajaya Travel - Create Account ✨</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-6xl bg-white rounded-[3rem] shadow-2xl shadow-slate-200 overflow-hidden flex flex-col md:flex-row min-h-[700px]">
        <!-- Left Side: Branding/Visual -->
        <div class="md:w-[45%] bg-[#0B2447] p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-sky-400/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-sky-400/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-12">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-full border-2 border-sky-400/30 bg-white p-1">
                    <h1 class="text-2xl font-black tracking-tight uppercase italic text-sky-400 leading-tight">Nusa Jaya <br>Indofast T&T</h1>
                </div>
                
                <h2 class="text-4xl font-extrabold leading-[1.1] mb-6 italic uppercase tracking-tighter">Join the <br>Elite <br><span class="text-sky-400 not-italic tracking-normal lowercase">Travelers.</span></h2>
                <p class="text-slate-300 text-lg font-medium leading-relaxed max-w-sm">Create your account to unlock premium booking features and personalized travel experiences.</p>
            </div>

            <div class="relative z-10 mt-12 pt-8 border-t border-white/10">
                <p class="text-[10px] font-black text-sky-400 uppercase tracking-[0.3em] mb-2">Trusted Partner</p>
                <p class="text-sm font-bold text-white/60 italic">PT Nusa Jaya Indofast T&T</p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="md:w-[55%] p-10 md:p-16 flex flex-col justify-center bg-white">
            <div class="mb-10">
                <h3 class="text-3xl font-bold text-[#0B2447] mb-2 italic tracking-tight">Create Account</h3>
                <p class="text-slate-400 font-medium italic text-sm">Join our premium travel community</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl">
                    <ul class="list-disc list-inside text-xs font-bold text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <!-- Full Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Full Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="name" id="name" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="Full Name" required>
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" id="email" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="example@mail.com" required>
                    </div>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Phone Number</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="phone" id="phone" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="+62..." required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Confirm Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-sky-500 text-slate-400">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] text-[#0B2447] font-bold focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full bg-[#0B2447] text-white font-black py-5 rounded-[1.25rem] shadow-xl shadow-slate-200 hover:bg-slate-800 hover:shadow-sky-100 hover:-translate-y-0.5 transition-all active:scale-[0.98] uppercase tracking-widest text-xs flex items-center justify-center group">
                        Register Now
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>

            <div class="mt-8 flex items-center justify-center space-x-4">
                <div class="h-[1px] flex-1 bg-slate-100"></div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Or</p>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            <p class="mt-6 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                Already have an account? <a href="{{ route('login') }}" class="text-sky-600 hover:text-[#0B2447] transition-colors">Login</a>
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
