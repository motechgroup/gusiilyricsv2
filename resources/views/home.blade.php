@extends('layouts.app')

@section('title', 'Gusii Lyrics - Ekegusii Song Lyrics & Official Stream Links')

@section('content')

<!-- Hero Banner -->
<div class="relative py-12 lg:py-16 border-b border-gray-800/80 bg-gradient-to-b from-[#111a2e] to-[#090d16]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-5">

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight max-w-4xl mx-auto">
            Discover Ekegusii Song Lyrics & <span class="text-gradient-emerald">Official Streams</span>
        </h1>

        <p class="text-gray-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
            Search songs, read official lyrics, and stream directly on Spotify & YouTube.
        </p>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('songs.index') }}" class="max-w-2xl mx-auto pt-2">
            <div class="relative flex items-center">
                <svg class="w-5 h-5 absolute left-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="q" placeholder="Search song title, artist name, or word (e.g. Ebiogo, Fenny Kerubo)..." class="w-full pl-12 pr-28 py-3.5 bg-gray-900/90 border border-gray-700/80 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 text-sm shadow-xl">
                <button type="submit" class="absolute right-2 px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition">
                    Search
                </button>
            </div>
        </form>

    </div>
</div>

<!-- A-Z Lyrics Index Finder (Homepage) -->
<div class="bg-[#0b111d] border-b border-gray-800/80 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-1.5 overflow-x-auto">
            <a href="{{ route('songs.index') }}" class="px-2.5 py-1 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-slate-950 text-xs font-bold transition">
                ALL
            </a>
            <a href="{{ route('songs.index', ['letter' => '#']) }}" class="px-2.5 py-1 rounded-lg bg-gray-900 hover:bg-emerald-500 text-gray-300 hover:text-slate-950 text-xs font-bold border border-gray-800 transition">
                #
            </a>
            @foreach(range('A', 'Z') as $char)
                <a href="{{ route('songs.index', ['letter' => $char]) }}" class="w-7 h-7 rounded-lg bg-gray-900 hover:bg-emerald-500 text-gray-300 hover:text-slate-950 text-xs font-bold border border-gray-800 transition flex items-center justify-center">
                    {{ $char }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Popular Albums and Singles (Spotify Card Grid) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Spotify Section Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white tracking-tight">Popular songs and singles</h2>
        <a href="{{ route('songs.index') }}" class="text-xs font-bold text-gray-400 hover:text-white uppercase tracking-wider">
            Show all
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($trendingSongs as $song)
            <a href="{{ route('songs.show', $song->slug) }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-transparent hover:border-emerald-500/20 shadow-lg">
                <!-- Artwork -->
                <div class="relative aspect-square w-full rounded-xl overflow-hidden mb-3.5 bg-gray-950 shadow-md">
                    <img src="{{ $song->cover_art_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    
                    <!-- Green Spotify Floating Play Icon -->
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
</div>

<!-- Featured Artists (Spotify Style) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-900">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white tracking-tight">Popular artists</h2>
        <a href="{{ route('artists.index') }}" class="text-xs font-bold text-gray-400 hover:text-white uppercase tracking-wider">
            Show all
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
        @foreach($featuredArtists as $artist)
            <a href="{{ route('artists.show', $artist->slug) }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 text-center flex flex-col items-center">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mb-3.5 border-2 border-emerald-500/20 group-hover:border-emerald-400 transition duration-300 shadow-xl">
                    <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-white text-sm group-hover:text-emerald-400 truncate w-full">{{ $artist->name }}</h3>
                <p class="text-[11px] text-gray-400 font-mono mt-0.5">Artist</p>
            </a>
        @endforeach
    </div>
</div>

<!-- Daily Top 10 CHARTS Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 border-t border-gray-900">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight uppercase">CHARTS</h2>
            <p class="text-xs text-gray-400 mt-1">Top 10 most viewed Ekegusii song lyrics today</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-900 border border-gray-800 text-[11px] font-mono font-bold text-gray-300 uppercase tracking-wider self-start sm:self-auto">
            <span>SONGS</span> / <span class="text-emerald-400">ALL GENRES</span> / <span>TODAY</span>
        </div>
    </div>

    <div class="glass-panel rounded-3xl border border-gray-800/80 divide-y divide-gray-800/60 overflow-hidden shadow-2xl">
        @foreach($topCharts as $index => $chartSong)
            <a href="{{ route('songs.show-nested', ['artistSlug' => $chartSong->artist->slug, 'songSlug' => $chartSong->slug]) }}" class="flex items-center justify-between p-3.5 sm:p-4 hover:bg-gray-800/50 transition duration-200 group">
                <div class="flex items-center space-x-3.5 sm:space-x-5 min-w-0">
                    <!-- Rank Number -->
                    <span class="w-6 text-center font-black text-base sm:text-lg font-mono text-gray-400 group-hover:text-emerald-400 transition shrink-0">
                        {{ $index + 1 }}
                    </span>

                    <!-- Song Cover Thumbnail -->
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl overflow-hidden bg-gray-950 shrink-0 border border-gray-800 shadow">
                        <img src="{{ $chartSong->cover_art_url }}" alt="{{ $chartSong->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <!-- Song Title & Tag -->
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-white text-sm sm:text-base group-hover:text-emerald-400 transition truncate">
                                {{ $chartSong->title }}
                            </h3>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider font-mono">LYRICS</span>
                        </div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-400 group-hover:text-gray-200 transition truncate mt-0.5 uppercase tracking-wide">
                            {{ $chartSong->artist->name }}
                        </p>
                    </div>
                </div>

                <!-- Stats Badges -->
                <div class="flex items-center space-x-4 sm:space-x-8 shrink-0 pl-2">
                    @if($chartSong->likes_count > 0)
                        <div class="hidden sm:flex items-center gap-1 text-xs font-mono font-bold text-rose-400 bg-rose-500/10 border border-rose-500/20 px-2.5 py-1 rounded-full">
                            🔥 {{ number_format($chartSong->likes_count) }}
                        </div>
                    @endif
                    <div class="flex items-center text-xs sm:text-sm font-mono font-extrabold text-gray-300 gap-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>{{ $chartSong->formatted_views }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

<!-- Support Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-12">
    <div class="glass-panel p-8 rounded-3xl border border-amber-500/30 text-center space-y-4">
        <div class="text-3xl">❤️</div>
        <h2 class="text-2xl font-extrabold text-white">Support Gusii Lyrics</h2>
        <p class="text-xs text-gray-300 max-w-xl mx-auto leading-relaxed">
            Help us keep Gusii Lyrics active and free of intrusive pop-ups. Donate via M-Pesa or Stripe.
        </p>
        <div>
            <button onclick="openDonateModal()" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg">
                Donate Now via M-Pesa / Stripe
            </button>
        </div>
    </div>
</div>

@endsection
