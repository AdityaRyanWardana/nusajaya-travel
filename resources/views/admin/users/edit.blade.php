@extends('layouts.admin')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Edit User</h2>
        <p class="text-slate-400 font-medium mt-2 italic text-lg">Update profile and permissions for {{ $user->name }}.</p>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12 space-y-10">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Full Name -->
            <div class="md:col-span-2 space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="Enter full name" required>
                @error('name') <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="example@mail.com" required>
                @error('email') <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="+62..." required>
                @error('phone') <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Account Role</label>
                <select name="role" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none appearance-none" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Regular User (Customer)</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Fleet & Tour)</option>
                    <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Full Access)</option>
                </select>
                @error('role') <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="hidden md:block"></div>

            <div class="md:col-span-2 pt-6 border-t border-slate-50">
                <p class="text-xs font-bold text-slate-400 italic mb-10">Leave password fields blank if you don't want to change it.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Password -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="••••••••">
                        @error('password') <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all outline-none" placeholder="••••••••">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-10 flex items-center space-x-6">
            <button type="submit" class="bg-blue-600 text-white px-10 py-5 rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-blue-100 flex items-center group">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                Update User Details
            </button>
            <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-red-500 transition-colors italic">Cancel & Return</a>
        </div>
    </form>
</div>
@endsection
