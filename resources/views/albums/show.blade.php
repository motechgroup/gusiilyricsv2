@extends('layouts.app')

@section('title', $album->title . ' Album Tracklist & Lyrics - ' . $album->artist->name . ' | GusiiLyrics')
@section('meta_description', 'Read complete lyrics for all tracks on ' . $album->title . ' by ' . $album->artist->name . '. Stream music and discover Ekegusii album details on GusiiLyrics.com.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Album Header Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl mb-10 border border-gray-800 flex flex-col md:flex-row gap-8 items-center md:items-start">
        <div class="w-48 h-48 sm:w-56 sm:h-56 rounded-2xl overflow-hidden bg-gray-950 shrink-0 shadow-2xl border border-gray-800">
            <img src="{{ $album->cover_art_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
        </div>

        <div class="space-y-3 text-center md:text-left flex-grow">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                Official Album
            </span>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                {{ $album->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-gray-300 font-mono">
                <a href="{{ route('artists.show', $album->artist->slug) }}" class="text-emerald-400 font-bold hover:underline">
                    🎤 {{ $album->artist->name }}
                </a>
                <span>• {{ $album->release_year ?: 'N/A' }}</span>
                <span>• {{ $album->songs->count() }} Songs</span>
            </div>

            @if($album->description)
                <p class="text-gray-300 text-xs sm:text-sm leading-relaxed max-w-2xl pt-2">
                    {{ $album->description }}
                </p>
            @endif
        </div>
    </div>

    <!-- Album Tracklist -->
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-white tracking-tight mb-4">Album Tracklist</h2>

        <div class="space-y-3">
            @forelse($album->songs as $index => $song)
                <a href="{{ $song->seo_url }}" class="glass-panel p-4 rounded-2xl flex items-center justify-between hover:bg-gray-800/80 transition border border-gray-800 group">
                    <div class="flex items-center gap-4">
                        <span class="w-8 text-center text-xs font-mono font-bold text-gray-400">{{ $index + 1 }}</span>
                        <div>
                            <h3 class="font-bold text-white text-sm group-hover:text-emerald-400 transition">{{ $song->title }}</h3>
                            <p class="text-xs text-gray-400">{{ $song->artist->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-xs text-gray-400 font-mono">
                        @if((\App\Models\Setting::get('show_song_views_public', '1') !== '0') || \Illuminate\Support\Facades\Auth::check())
                            <span>👁️ {{ number_format($song->views_count) }}</span>
                        @endif
                        <span class="px-3 py-1 rounded-xl bg-emerald-500/10 text-emerald-400 font-bold group-hover:bg-emerald-500 group-hover:text-slate-950 transition">Read Lyrics &rarr;</span>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 text-xs py-4">No tracks listed under this album yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
