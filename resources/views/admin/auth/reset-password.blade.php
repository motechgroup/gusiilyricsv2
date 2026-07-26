@extends('layouts.app')

@section('title', 'Set New Password - Gusii Lyrics Staff')

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="glass-panel p-8 rounded-3xl border border-emerald-500/30 shadow-2xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 font-black flex items-center justify-center mx-auto text-xl shadow-lg">🔒</div>
            <h1 class="text-2xl font-extrabold text-white">Set New Password</h1>
            <p class="text-xs text-gray-400">Enter your new password to update your staff account credentials.</p>
        </div>

        @if(session('error'))
            <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">New Password</label>
                <input type="password" name="password" required placeholder="Minimum 6 characters..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required placeholder="Repeat new password..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Update Password & Sign In
            </button>
        </form>
    </div>
</div>
@endsection
