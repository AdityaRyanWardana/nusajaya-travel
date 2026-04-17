<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PT Nusa Jaya Indofast Tour & Travel</title>
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
    <div class="absolute -top-40 right-20 w-96 h-96 bg-skyblue/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 -left-20 w-72 h-72 bg-brandblue/5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[420px] bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-10 relative z-10 border border-slate-100">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="PT Nusa Jaya Indofast" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
        </div>
        
        <h1 class="text-[13px] font-bold text-brandblue text-center mb-8 uppercase tracking-wider">NUSA JAYA INDOFAST TOUR & TRAVEL</h1>

        <!-- Custom Tabs -->
        <div class="flex mb-8">
            <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-sm font-bold text-slate-400 border-b-2 border-slate-100 hover:text-slate-600">Login</a>
            <a href="{{ route('register') }}" class="flex-1 text-center py-2 text-sm font-bold text-brandblue border-b-2 border-brandblue">Register</a>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded text-xs font-semibold mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">FULL NAME</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">EMAIL ADDRESS</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">PHONE NUMBER</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+62 812 3456 7890" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">PASSWORD</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <input type="password" name="password" placeholder="••••••••" required class="w-full bg-slate-100 border-none text-slate-700 text-sm rounded-lg pl-10 pr-10 py-3 focus:ring-2 focus:ring-brandblue/20 transition">
                </div>
            </div>
            
            <div class="hidden">
                 <input type="password" name="password_confirmation" id="password_confirmation" value="">
            </div>
            
            <script>
                document.querySelector('input[name="password"]').addEventListener('change', function() {
                    document.getElementById('password_confirmation').value = this.value;
                });
            </script>

            <button type="submit" class="w-full bg-brandblue hover:bg-slate-800 text-white font-bold rounded-lg px-4 py-3.5 transition shadow-lg shadow-brandblue/20 mt-6 text-sm">
                REGISTER NOW
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500 font-medium">Already have an account? <a href="{{ route('login') }}" class="text-brandblue font-bold hover:underline">Login</a></p>
        </div>
    </div>
    
    <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-6 text-[9px] font-bold tracking-widest text-slate-400 uppercase">
        <a href="#" class="hover:text-brandblue">PRIVACY POLICY</a>
        <a href="#" class="hover:text-brandblue">TERMS OF SERVICE</a>
    </div>
    <div class="absolute bottom-2 left-0 right-0 flex justify-center text-[9px] text-slate-400">
        © 2024 Nusa Jaya Indofast. All rights reserved.
    </div>
</body>
</html>
