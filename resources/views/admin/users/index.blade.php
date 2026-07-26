@extends('layouts.admin')

@section('title', 'Manage Staff & Editors - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Staff & Editors</h1>
            <p class="text-xs text-gray-400 mt-1">Super Admin control panel for team accounts.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow">
            + Add Staff / Editor
        </a>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden border border-gray-800">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Created Date</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($users as $u)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white">{{ $u->name }}</td>
                        <td class="p-4 text-gray-300 font-mono">{{ $u->email }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase {{ $u->role === 'admin' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-indigo-500/20 text-indigo-300' }}">
                                {{ $u->role === 'admin' ? 'Super Admin' : 'Editor' }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-400 font-mono">{{ $u->created_at->format('M d, Y') }}</td>
                        <td class="p-4 text-right">
                            @if(Auth::id() !== $u->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="inline" onsubmit="return confirm('Delete this staff account?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-semibold">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 italic">Your Account</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
