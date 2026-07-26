@extends('layouts.app')

@section('title', $title . ' - GusiiLyrics')
@section('meta_description', $metaDescription)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Hero / Category Header -->
    <div class="glass-panel p-8 rounded-3xl mb-10 border border-gray-800 relative overflow-hidden">
        <div class="relative z-10 space-y-4 max-w-4xl">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                {{ $badge }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                {{ $title }}
            </h1>
            <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                {{ $metaDescription }}
            </p>
        </div>
    </div>

    <!-- Unique SEO Rich Description (300-600 words to avoid thin content penalties) -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl mb-10 border border-gray-800/80 text-gray-300 text-sm leading-relaxed space-y-4">
        <h2 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
            <span>📖 About {{ $title }}</span>
        </h2>
        <div class="prose prose-invert max-w-none text-xs sm:text-sm text-gray-300 leading-relaxed space-y-3">
            <p>{{ $seoContent }}</p>
        </div>
    </div>

    <!-- Song List Grid (Spotify Style) -->
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-extrabold text-white tracking-tight">Indexed Lyrics & Songs</h2>
        <span class="text-xs text-gray-400 font-mono">Showing {{ $songs->total() }} tracks</span>
    </div>

    @if($songs->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @foreach($songs as $song)
                <a href="{{ $song->seo_url }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-transparent hover:border-emerald-500/20 shadow-lg">
                    <!-- Artwork -->
                    <div class="relative aspect-square w-full rounded-xl overflow-hidden mb-3.5 bg-gray-950 shadow-md">
                        <img src="{{ $song->cover_art_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <!-- Play Icon -->
                        <div class="absolute bottom-2 right-2 w-11 h-11 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center shadow-2xl opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-2 transition-all duration-300">
                            <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>

                    <!-- Titles -->
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base truncate group-hover:text-emerald-400 transition leading-snug">
                            {{ $song->title }}
                        </h3>
                        <p class="text-xs text-gray-400 truncate mt-1">
                            {{ $song->artist->name }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $songs->links() }}
        </div>
    @else
        <div class="glass-panel rounded-2xl p-12 text-center max-w-md mx-auto my-12">
            <h3 class="text-lg font-bold text-white mb-1">No songs listed yet</h3>
            <p class="text-sm text-gray-400 mb-4">Check back soon as new lyrics are added daily!</p>
        </div>
    @endif

</div>
@endsection
