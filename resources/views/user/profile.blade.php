@extends('layouts.public')

@section('content')
<section class="max-w-4xl mx-auto px-8 py-20 w-full">
    <div class="flex items-center gap-6 mb-12">
        <div class="w-24 h-24 rounded-full bg-skyblue flex items-center justify-center text-4xl text-white font-black border-4 border-white shadow-xl">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div>
            <h1 class="text-3xl font-black text-brandblue uppercase tracking-tight">My Profile</h1>
            <p class="text-slate-500 font-medium">Manage your personal information and travel preferences.</p>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-xs font-black text-brandblue uppercase tracking-widest mb-6">Account Status</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-bold text-slate-600">Active Member</span>
                </div>
                <p class="text-[10px] text-slate-400 leading-relaxed font-medium">Joined since {{ auth()->user()->created_at->format('M Y') }}</p>
            </div>
            
            <div class="bg-brandblue rounded-3xl p-8 text-white">
                <h3 class="text-xs font-black text-skyblue uppercase tracking-widest mb-4">Travel Points</h3>
                <p class="text-3xl font-black mb-1">2,450</p>
                <p class="text-[10px] text-white/60 font-medium tracking-wider uppercase">Platinum Voyager</p>
            </div>
        </div>

        <!-- Main Form Area -->
        <div class="col-span-2">
            <div class="bg-white rounded-3xl p-10 border border-slate-100 shadow-xl">
                <form action="#" method="POST" class="space-y-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="w-full bg-lightbg border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-400 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Phone Number</label>
                        <input type="text" placeholder="+62 812-XXXX-XXXX" class="w-full bg-lightbg border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Biography</label>
                        <textarea rows="4" class="w-full bg-lightbg border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition" placeholder="Tell us about your travel style..."></textarea>
                    </div>

                    <div class="pt-6">
                        <button type="button" class="px-8 py-4 bg-brandblue text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-slate-800 transition shadow-xl shadow-brandblue/20">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
