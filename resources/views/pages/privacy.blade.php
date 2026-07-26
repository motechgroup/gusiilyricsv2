@extends('layouts.app')

@section('title', 'Privacy Policy - Gusii Lyrics Vault')
@section('meta_description', 'Read the official Privacy Policy and Data Collection Guidelines for Gusii Lyrics Vault.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

    <div class="border-b border-gray-800 pb-6 space-y-2">
        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider">
            Legal & Privacy
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Privacy Policy</h1>
        <p class="text-xs text-gray-400 font-mono">Last Updated: July 2026</p>
    </div>

    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-gray-800 space-y-6 text-gray-200 text-sm sm:text-base leading-relaxed whitespace-pre-line font-sans">
        {{ $content }}
    </div>

    <div class="pt-4 text-center">
        <a href="{{ route('home') }}" class="text-xs font-bold text-emerald-400 hover:underline">&larr; Back to Home</a>
    </div>

</div>
@endsection
