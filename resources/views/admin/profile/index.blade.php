@extends('layouts.admin')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">{{ __('My Profile') }}</h2>
        <p class="text-slate-400 font-medium mt-2 italic text-lg">{{ __('Manage your personal information and public profile.') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-8 text-center">
                <div class="w-24 h-24 bg-blue-600 rounded-[2rem] flex items-center justify-center text-white font-black text-3xl mx-auto shadow-xl shadow-blue-100 mb-6">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic leading-tight">{{ $user->name }}</h3>
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mt-2">{{ $user->role }}</p>
                
                <div class="mt-8 pt-8 border-t border-slate-50 space-y-4">
                    <div class="flex items-center text-xs font-bold text-slate-500">
                        <i data-lucide="mail" class="w-4 h-4 mr-3 text-slate-400"></i>
                        {{ $user->email }}
                    </div>
                    <div class="flex items-center text-xs font-bold text-slate-500">
                        <i data-lucide="phone" class="w-4 h-4 mr-3 text-slate-400"></i>
                        {{ $user->phone }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-10 space-y-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Full Name -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Full Name') }}</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Email Address') }}</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Phone Number') }}</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-blue-100 flex items-center group">
                        <i data-lucide="save" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"></i>
                        {{ __('Save Changes') }}
                    </button>
                    <p class="text-[9px] font-bold text-slate-400 uppercase italic">{{ __('Last updated') }}: {{ $user->updated_at->diffForHumans() }}</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
