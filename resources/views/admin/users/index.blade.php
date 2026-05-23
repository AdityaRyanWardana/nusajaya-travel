@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight italic uppercase">{{ __('Manage Users') }}</h2>
            <p class="text-slate-400 dark:text-slate-400 font-medium mt-2 italic text-lg">{{ __('Create and manage administrative accounts and customers.') }}</p>
        </div>
        @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-blue-100 flex items-center group">
            <i data-lucide="user-plus" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"></i>
            {{ __('Add New User') }}
        </a>
        @endif
    </div>

    <div class="bg-white dark:bg-[#0F2038] rounded-[3rem] border border-slate-100 dark:border-[#1E3A5F] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-[#152C4C]/30">
                        <th class="px-10 py-6 text-left text-[10px] font-black text-slate-400 dark:text-slate-300 uppercase tracking-[0.2em]">{{ __('User Profile') }}</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Role') }}</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Contact') }}</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Joined') }}</th>
                        @if(auth()->user()->role === 'superadmin')
                        <th class="px-10 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-[#1E3A5F]">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/30 dark:hover:bg-[#152C4C]/20 transition-colors">
                        <td class="px-10 py-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-[#1E3A5F] flex items-center justify-center text-slate-500 dark:text-slate-300 font-black overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-8">
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest 
                                {{ $user->role === 'superadmin' ? 'bg-purple-50 dark:bg-purple-950/30 text-purple-600 dark:text-purple-400' : ($user->role === 'admin' ? 'bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400' : 'bg-slate-100 dark:bg-[#1E3A5F] text-slate-500 dark:text-slate-400') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-8 text-sm font-bold text-slate-500 dark:text-slate-300">
                            {{ $user->phone }}
                        </td>
                        <td class="px-6 py-8 text-sm font-bold text-slate-500 dark:text-slate-300 italic">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        @if(auth()->user()->role === 'superadmin')
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-[#1E3A5F] rounded-lg transition-colors" title="Edit User">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-lg transition-colors" title="Delete User">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-slate-50 dark:border-[#1E3A5F]">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
