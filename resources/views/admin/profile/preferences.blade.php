@extends('layouts.admin')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">{{ __('System Preferences') }}</h2>
        <p class="text-slate-400 font-medium mt-2 italic text-lg">{{ __('Customize your dashboard experience and notification settings.') }}</p>
    </div>

    <form action="{{ route('admin.preferences.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Dashboard Appearance -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12">
            <div class="flex items-center space-x-4 mb-10">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="palette" class="w-5 h-5"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase italic">{{ __('Appearance') }}</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label for="theme" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Interface Theme') }}</label>
                    <select name="theme" id="theme" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 outline-none appearance-none">
                        <option value="light" {{ auth()->user()->theme == 'light' ? 'selected' : '' }}>{{ __('Premium Light Mode') }}</option>
                        <option value="dark" {{ auth()->user()->theme == 'dark' ? 'selected' : '' }}>{{ __('Modern Dark Mode') }}</option>
                    </select>
                </div>

                <div class="space-y-4">
                    <label for="language" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('System Language') }}</label>
                    <select name="language" id="language" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 outline-none appearance-none">
                        <option value="en" {{ auth()->user()->language == 'en' ? 'selected' : '' }}>{{ __('English (Global Standard)') }}</option>
                        <option value="id" {{ auth()->user()->language == 'id' ? 'selected' : '' }}>{{ __('Bahasa Indonesia') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12">
            <div class="flex items-center space-x-4 mb-10">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase italic">{{ __('Notifications') }}</h3>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100/50">
                    <div>
                        <p class="text-sm font-black text-slate-800">{{ __('Email Alerts') }}</p>
                        <p class="text-[10px] font-bold text-slate-400 italic mt-1">{{ __('Receive booking updates via email.') }}</p>
                    </div>
                    <div class="w-12 h-6 bg-blue-600 rounded-full relative cursor-pointer">
                        <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100/50">
                    <div>
                        <p class="text-sm font-black text-slate-800">{{ __('Browser Notifications') }}</p>
                        <p class="text-[10px] font-bold text-slate-400 italic mt-1">{{ __('Real-time alerts for new orders.') }}</p>
                    </div>
                    <div class="w-12 h-6 bg-slate-200 rounded-full relative cursor-pointer">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-6">
            <button type="submit" class="bg-blue-600 text-white px-10 py-5 rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-blue-100 flex items-center group">
                <i data-lucide="save" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"></i>
                {{ __('Save Preferences') }}
            </button>
        </div>
    </form>
</div>
@endsection
