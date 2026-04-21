@extends('layouts.public')

@section('content')

<section class="max-w-5xl mx-auto px-8 py-20 w-full">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-brandblue uppercase tracking-tight italic mb-2">My Profile</h1>
        <p class="text-slate-500 font-medium">Manage your personal information, security, and travel identity.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold rounded-2xl flex items-center gap-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->avatar)
    <form id="delete-avatar-form" action="{{ route('user.avatar.delete') }}" method="POST" class="hidden">
        @csrf
    </form>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="grid lg:grid-cols-3 gap-12">
        @csrf
        <!-- Left Sidebar: Avatar & Status -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl text-center">
                <!-- Avatar Preview -->
                <div class="flex justify-center mb-6">
                    <div class="w-40 h-40 rounded-full bg-skyblue flex items-center justify-center text-5xl text-white font-black border-8 border-white shadow-2xl overflow-hidden" id="avatar-preview">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        @endif
                    </div>
                </div>

                <!-- Avatar Action Buttons -->
                <div class="flex flex-col items-center gap-3 mb-8">
                    <!-- Upload Button -->
                    <label for="avatar-input" class="cursor-pointer flex items-center gap-2 px-5 py-2.5 bg-brandblue text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-skyblue transition-all duration-300 shadow-md shadow-brandblue/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Upload Photo
                    </label>
                    <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <p class="text-[9px] text-slate-400 font-medium">JPG, PNG or GIF · Max 2MB</p>

                    @if(auth()->user()->avatar)
                    <!-- Delete Button — triggers the external form -->
                    <button type="button"
                        onclick="if(confirm('Are you sure you want to remove your profile picture?')) document.getElementById('delete-avatar-form').submit();"
                        class="flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all duration-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Photo
                    </button>
                    @endif
                </div>

                <h3 class="text-xl font-black text-brandblue uppercase italic mb-2 leading-none">{{ auth()->user()->name }}</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-8">{{ auth()->user()->role }} Account</p>

                <div class="pt-8 border-t border-slate-50">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-black text-brandblue uppercase tracking-widest">Active Member</span>
                    </div>
                    <p class="text-[9px] text-slate-400 font-medium italic">Joined since {{ auth()->user()->created_at->format('M Y') }}</p>
                </div>
            </div>

            <!-- Profile Security Card -->
            <div class="bg-brandblue rounded-[2.5rem] p-8 text-white shadow-xl shadow-brandblue/20">
                <h4 class="text-xs font-black text-skyblue uppercase tracking-widest mb-4">Profile Security</h4>
                <p class="text-[10px] text-white/60 leading-relaxed font-medium">Keep your account secure by ensuring your email is verified and your phone number is up to date.</p>
                <div class="mt-6 flex gap-3">
                    <div class="w-1 h-10 bg-skyblue rounded-full opacity-30"></div>
                    <div>
                        <p class="text-[10px] font-bold text-white mb-1">Email Verified</p>
                        <p class="text-[9px] text-skyblue font-black uppercase">Identity Secured</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Detailed Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-64 h-64 bg-slate-50 rounded-full blur-3xl opacity-50"></div>
                
                <div class="relative grid md:grid-cols-2 gap-x-8 gap-y-8">
                    <!-- Personal Info Section -->
                    <div class="md:col-span-2 mb-4">
                        <h3 class="text-xs font-black text-brandblue uppercase tracking-[0.3em] border-b border-slate-50 pb-4 mb-2">Personal Information</h3>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-400 cursor-not-allowed shadow-inner">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="+62 812 XXXX XXXX" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Date of Birth</label>
                        <input type="date" name="birthday" value="{{ auth()->user()->birthday }}" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Gender</label>
                        <select name="gender" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm appearance-none">
                            <option value="" disabled {{ !auth()->user()->gender ? 'selected' : '' }}>Select Gender</option>
                            <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ auth()->user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nationality</label>
                        <input type="text" name="nationality" value="{{ auth()->user()->nationality }}" placeholder="e.g. Indonesian" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm">
                    </div>

                    <!-- Address & Bio Section -->
                    <div class="md:col-span-2 mt-6 mb-4">
                        <h3 class="text-xs font-black text-brandblue uppercase tracking-[0.3em] border-b border-slate-50 pb-4 mb-2">Location & About</h3>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Residential Address</label>
                        <textarea name="address" rows="3" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm" placeholder="Your full address...">{{ auth()->user()->address }}</textarea>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Short Bio</label>
                        <textarea name="bio" rows="4" class="w-full bg-lightbg border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-skyblue transition shadow-sm" placeholder="Tell us about your travel style or preferences...">{{ auth()->user()->bio }}</textarea>
                    </div>

                    <div class="md:col-span-2 pt-10">
                        <button type="submit" class="w-full md:w-auto px-12 py-5 bg-brandblue text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-slate-800 transition-all duration-500 shadow-2xl shadow-brandblue/20 transform hover:-translate-y-1">
                            Save Profile Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('avatar-preview');
                preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
