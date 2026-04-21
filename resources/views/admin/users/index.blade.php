@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Manage Users</h2>
            <p class="text-slate-400 font-medium mt-2 italic text-lg">Create and manage administrative accounts and customers.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-blue-100 flex items-center group">
            <i data-lucide="user-plus" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"></i>
            Add New User
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Profile</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contact</th>
                        <th class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Joined</th>
                        <th class="px-10 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-10 py-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $user->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-8">
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest 
                                {{ $user->role === 'superadmin' ? 'bg-purple-50 text-purple-600' : ($user->role === 'admin' ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-500') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-8 text-sm font-bold text-slate-500">
                            {{ $user->phone }}
                        </td>
                        <td class="px-6 py-8 text-sm font-bold text-slate-500 italic">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit User">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete User">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
