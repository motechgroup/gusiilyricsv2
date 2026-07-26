@extends('layouts.admin')

@section('title', 'Add Staff Member - Admin')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <h1 class="text-2xl font-extrabold text-white">Add Staff / Editor Account</h1>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Cancel & Back</a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Full Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Omwamba Nyakundi" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address <span class="text-rose-500">*</span></label>
                <input type="email" name="email" required placeholder="editor@gusiilyrics.com" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimum 6 characters..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Account Role <span class="text-rose-500">*</span></label>
                <select name="role" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="editor" selected>Editor (Can post and manage lyrics/artists only)</option>
                    <option value="admin">Super Admin (Full access to Settings, Ads, Analytics, and Stats)</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Create Staff Account
            </button>
        </form>
    </div>

</div>
@endsection
