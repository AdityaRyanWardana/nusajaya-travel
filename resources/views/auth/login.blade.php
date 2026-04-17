<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Nusa Jaya Indofast Tour & Travel</title>
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
                        lightbg: '#F4F7F9',
                        skyblue: '#38BDF8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-lightbg text-slate-800 flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-skyblue/10 rounded-full blur-3xl"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-brandblue/5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[420px] bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-10 relative z-10 border border-slate-100">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="PT Nusa Jaya Indofast" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
        </div>
        
        <h1 class="text-[13px] font-bold text-brandblue text-center mb-8 uppercase tracking-wider">NUSA JAYA INDOFAST TOUR & TRAVEL</h1>

        <!-- Custom Tabs -->
        <div class="flex mb-8">
            <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-sm font-bold text-brandblue border-b-2 border-brandblue">Login</a>
            <a href="{{ route('register') }}" class="flex-1 text-center py-2 text-sm font-bold text-slate-400 border-b-2 border-slate-100 hover:text-slate-600">Register</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-3 rounded text-xs font-semibold mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-500 p-3 rounded text-xs font-semibold mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded text-xs font-semibold mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">EMAIL ADDRESS</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">PASSWORD</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <input type="password" name="password" placeholder="••••••••••••" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-10 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs font-semibold">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-brandblue bg-slate-100 border-none rounded focus:ring-brandblue">
                    <label for="remember" class="ml-2 text-slate-500">Remember me</label>
                </div>
                <a href="#" class="text-brandblue hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-brandblue hover:bg-slate-800 text-white font-bold rounded-lg px-4 py-3.5 transition shadow-lg shadow-brandblue/20 mt-4 text-sm uppercase tracking-widest">
                Sign In to Account
            </button>
        </form>

        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <div class="relative flex justify-center text-[10px] uppercase tracking-wider font-bold">
                    <span class="px-3 bg-white text-slate-400">OR CONTINUE WITH</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <button class="flex justify-center items-center gap-2 w-full px-4 py-2.5 bg-slate-50 hover:bg-slate-100 rounded-lg text-xs font-bold text-slate-700 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Google
                </button>
                <button class="flex justify-center items-center gap-2 w-full px-4 py-2.5 bg-slate-50 hover:bg-slate-100 rounded-lg text-xs font-bold text-slate-700 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.04 2.26-.74 3.58-.8 2.02-.13 3.55.93 4.41 2.37-3.69 1.95-2.94 6.7.75 8.1-1.02 2.38-2.6 4.67-3.82 5.6M12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25"/></svg>
                    Apple
                </button>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-6 left-0 right-0 flex justify-between px-12 text-[9px] font-bold tracking-widest text-slate-400 uppercase">
        <span>© 2024 VISITTOBATAM.COM • PT NUSA JAYA INDOFAST T&T</span>
        <div class="flex gap-4">
            <a href="#" class="hover:text-brandblue">LEGAL</a>
            <a href="#" class="hover:text-brandblue">PRIVACY</a>
            <a href="#" class="hover:text-brandblue">SUPPORT</a>
        </div>
    </div>
</body>
</html>
