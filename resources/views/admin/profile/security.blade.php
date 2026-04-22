@extends('layouts.admin')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">{{ __('Security Settings') }}</h2>
        <p class="text-slate-400 font-medium mt-2 italic text-lg">{{ __('Update your password and manage account security protocols.') }}</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-[2rem] shadow-sm">
            <ul class="list-disc list-inside text-xs font-bold text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.security.update') }}" method="POST" class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12 space-y-10">
        @csrf
        @method('PUT')
        
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                <i data-lucide="shield-lock" class="w-5 h-5"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase italic">{{ __('Change Password') }}</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Current Password -->
            <div class="md:col-span-2 space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Current Password') }}</label>
                <input type="password" name="current_password" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-red-500 focus:bg-white transition-all outline-none" placeholder="••••••••" required>
            </div>

            <!-- New Password -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('New Password') }}</label>
                <input type="password" name="password" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="••••••••" required>
            </div>

            <!-- Confirm New Password -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Confirm New Password') }}</label>
                <input type="password" name="password_confirmation" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="••••••••" required>
            </div>
        </div>

        <div class="pt-8 flex items-center justify-between border-t border-slate-50">
            <button type="submit" class="bg-[#0B2447] text-white px-10 py-5 rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 flex items-center group">
                <i data-lucide="key" class="w-4 h-4 mr-2 group-hover:rotate-45 transition-transform"></i>
                {{ __('Update Security Credentials') }}
            </button>
            <div class="flex items-center text-[10px] font-bold text-slate-400 italic">
                <i data-lucide="info" class="w-4 h-4 mr-2"></i>
                {{ __('Requires current password to verify') }}
            </div>
        </div>
    </form>

    <!-- Sessions Placeholder -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center">
                <i data-lucide="monitor" class="w-5 h-5"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase italic">{{ __('Active Sessions') }}</h3>
        </div>
        
        <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100/50 opacity-60">
            <div class="flex items-center">
                <div class="p-3 bg-white rounded-xl mr-4 shadow-sm text-blue-600">
                    <i data-lucide="chrome" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-800">Batam, Indonesia — Current Device</p>
                    <p class="text-[10px] font-bold text-slate-400 italic mt-1">Chrome on Windows 10</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-full">Online</span>
        </div>
    </div>
</div>
@endsection
