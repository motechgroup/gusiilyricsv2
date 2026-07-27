@extends('layouts.app')

@section('title', 'Staff Sign-In - Gusii Lyrics')

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="glass-panel p-8 rounded-3xl border border-emerald-500/30 shadow-2xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 font-black flex items-center justify-center mx-auto text-xl shadow-lg">G</div>
            <h1 class="text-2xl font-extrabold text-white">Staff Management Portal</h1>
            <p class="text-xs text-gray-400">Sign in to manage lyrics, artists, requests, and site content.</p>
        </div>

        @if(session('error'))
            <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email address..." value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300">Password</label>
                    <a href="{{ route('admin.password.request') }}" class="text-[11px] text-emerald-400 hover:underline">Forgot Password?</a>
                </div>
                <input type="password" name="password" required placeholder="Enter your password..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Sign In to Staff Panel
            </button>
        </form>
    </div>
</div>
@endsection
