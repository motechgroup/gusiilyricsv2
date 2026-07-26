@extends('layouts.admin')

@section('title', 'Manage Pages & Legal Content - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Pages & Legal Content Manager</h1>
            <p class="text-xs text-gray-400 mt-1">Super Admin editor for public Terms of Service (/terms) and Privacy Policy (/privacy).</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('pages.terms') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-xs font-bold border border-gray-800">
                Preview /terms &nearr;
            </a>
            <a href="{{ route('pages.privacy') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-xs font-bold border border-gray-800">
                Preview /privacy &nearr;
            </a>
        </div>
    </div>

    <!-- Un-enclosed Legal Content Form -->
    <form method="POST" action="{{ route('admin.pages.update') }}" class="space-y-8">
        @csrf

        <!-- 1. Terms of Service -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                📜 Terms of Service Content (/terms)
            </h3>
            <textarea name="terms_content" rows="12" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-2xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500 leading-relaxed">{{ $termsContent }}</textarea>
        </div>

        <!-- 2. Privacy Policy -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                🔒 Privacy Policy Content (/privacy)
            </h3>
            <textarea name="privacy_content" rows="12" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-2xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500 leading-relaxed">{{ $privacyContent }}</textarea>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition shadow-lg">
            Save & Publish Legal Pages Content
        </button>
    </form>

</div>
@endsection
