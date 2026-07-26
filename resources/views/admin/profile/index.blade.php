@extends('layouts.admin')

@section('title', 'My Profile & Account Settings - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Header Section -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">👤 My Profile & Account Settings</h1>
            <p class="text-xs text-gray-400 mt-1">Update your personal account credentials, email address, and security password.</p>
        </div>
        <span class="px-3 py-1 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-mono font-bold uppercase">
            Role: {{ $user->isAdmin() ? 'Super Admin' : 'Editor' }}
        </span>
    </div>

    <!-- Account Overview Badge Card (Un-enclosed) -->
    <div class="p-6 rounded-2xl bg-gray-950/80 border border-gray-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-slate-950 text-2xl font-black shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">{{ $user->name }}</h3>
                <p class="text-xs font-mono text-emerald-400 mt-0.5">{{ $user->email }}</p>
                <div class="flex items-center gap-3 mt-2 text-[11px] text-gray-400 font-mono">
                    <span>Account ID: #{{ $user->id }}</span>
                    <span>•</span>
                    <span>Member Since: {{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Form 1: Update Profile Details -->
        <div class="space-y-4">
            <div class="pb-2 border-b border-gray-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Profile Information</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Update your staff account display name and contact email.</p>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-gray-300 mb-1.5">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500">
                    @error('name')
                        <p class="text-rose-400 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1.5">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
                    @error('email')
                        <p class="text-rose-400 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-500 mb-1.5">Account Role</label>
                    <input type="text" disabled value="{{ $user->isAdmin() ? 'Super Admin' : 'Editor' }}" class="w-full px-4 py-2.5 bg-gray-900/60 border border-gray-800 rounded-xl text-gray-400 font-mono cursor-not-allowed">
                    <span class="text-[10px] text-gray-500 mt-1 block">Account role permissions can only be altered by Super Admins.</span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md transition">
                        Update Profile Information
                    </button>
                </div>
            </form>
        </div>

        <!-- Form 2: Update Security Password -->
        <div class="space-y-4">
            <div class="pb-2 border-b border-gray-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Change Password</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Ensure your staff account is using a long, secure password.</p>
            </div>

            <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-gray-300 mb-1.5">Current Password *</label>
                    <input type="password" name="current_password" required placeholder="••••••••" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
                    @error('current_password')
                        <p class="text-rose-400 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1.5">New Password *</label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
                    @error('password')
                        <p class="text-rose-400 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1.5">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter new password" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-md transition">
                        Update Password & Security
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
