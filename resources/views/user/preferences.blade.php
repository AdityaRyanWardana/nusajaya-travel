@extends('layouts.public')

@section('content')
<section class="max-w-4xl mx-auto px-8 py-20 w-full">
    <div class="mb-12">
        <h1 class="text-3xl font-black text-brandblue uppercase tracking-tight mb-2">Account Preferences</h1>
        <p class="text-slate-500 font-medium">Customize your experience and security settings.</p>
    </div>

    <div class="space-y-8">
        <!-- Security Section -->
        <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-xl overflow-hidden relative">
            <div class="absolute -top-10 -right-10 opacity-5">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"></path></svg>
            </div>
            
            <div class="flex items-center gap-4 mb-10 border-b border-slate-50 pb-6">
                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-brandblue uppercase tracking-widest">Security & Authentication</h3>
                    <p class="text-xs text-slate-400 font-medium">Keep your account protected with a strong password.</p>
                </div>
            </div>

            <form action="#" method="POST" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Current Password</label>
                        <input type="password" placeholder="••••••••" class="w-full bg-lightbg border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-rose-500/30 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">New Password</label>
                        <input type="password" placeholder="Min. 8 characters" class="w-full bg-lightbg border-none rounded-2xl px-5 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition">
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" class="px-8 py-3 bg-brandblue text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition shadow-lg">Update Password</button>
                </div>
            </form>
        </div>

        <!-- Notification & Settings -->
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-skyblue/10 rounded-xl flex items-center justify-center text-skyblue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-xs font-black text-brandblue uppercase tracking-widest">Notifications</h3>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-600">Email Updates</p>
                            <p class="text-[10px] text-slate-400">Receive booking confirmations</p>
                        </div>
                        <div class="w-10 h-5 bg-skyblue rounded-full relative shadow-inner">
                            <div class="absolute right-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-600">Newsletter</p>
                            <p class="text-[10px] text-slate-400">Occasional travel deals</p>
                        </div>
                        <div class="w-10 h-5 bg-slate-200 rounded-full relative">
                            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-xs font-black text-brandblue uppercase tracking-widest">Payments</h3>
                </div>
                <div class="p-6 bg-lightbg rounded-2xl border border-dashed border-slate-200 text-center">
                    <p class="text-[10px] text-slate-400 font-bold italic leading-relaxed">No saved payment methods. All payments are securely processed via Midtrans.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
