@extends('layouts.app')

@section('title', 'Forgot Password - Gusii Lyrics Staff')

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="glass-panel p-8 rounded-3xl border border-emerald-500/30 shadow-2xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 font-black flex items-center justify-center mx-auto text-xl shadow-lg">🔑</div>
            <h1 class="text-2xl font-extrabold text-white">Reset Staff Password</h1>
            <p class="text-xs text-gray-400">Enter your registered staff email address to receive a password reset link.</p>
        </div>

        @if(session('status'))
            <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="admin@gusiilyrics.com" value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Send Password Reset Link
            </button>
        </form>

        <div class="text-center">
            <a href="{{ route('admin.login') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Back to Staff Login</a>
        </div>
    </div>
</div>
@endsection
