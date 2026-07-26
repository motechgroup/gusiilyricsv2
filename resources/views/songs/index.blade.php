@extends('layouts.app')

@section('title', 'Lyrics Directory - Gusii Lyrics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Directory Header -->
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Ekegusii <span class="text-gradient-emerald">Lyrics</span>
        </h1>
        <p class="text-gray-400 text-sm mt-1">Browse and search official Gusii music lyrics & stream links.</p>
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('songs.index') }}" class="glass-panel p-4 rounded-2xl mb-6 flex flex-col md:flex-row gap-4 items-center">
        <!-- Preserve selected letter if any -->
        @if(request('letter'))
            <input type="hidden" name="letter" value="{{ request('letter') }}">
        @endif

        <!-- Search Input -->
        <div class="relative flex-grow w-full">
            <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search song title, artist name, or lyrics text..." class="w-full pl-11 pr-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <!-- Genre Dropdown -->
        <div class="w-full md:w-48">
            <select name="genre" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-gray-300 focus:outline-none focus:border-emerald-500 text-sm">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->slug }}" {{ request('genre') == $genre->slug ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sort Dropdown -->
        <div class="w-full md:w-48">
            <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-gray-300 focus:outline-none focus:border-emerald-500 text-sm">
                <option value="asc" {{ ($selectedSort ?? 'asc') === 'asc' ? 'selected' : '' }}>Title (A - Z)</option>
                <option value="desc" {{ ($selectedSort ?? '') === 'desc' ? 'selected' : '' }}>Title (Z - A)</option>
                <option value="popular" {{ ($selectedSort ?? '') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                <option value="latest" {{ ($selectedSort ?? '') === 'latest' ? 'selected' : '' }}>Latest Uploads</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition shrink-0">
            Filter Lyrics
        </button>
        @if(request('q') || request('genre') || request('letter') || request('sort'))
            <a href="{{ route('songs.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold">
                Reset
            </a>
        @endif
    </form>

    <!-- A-Z Alphabetical Index Filter Bar -->
    <div class="mb-10 p-3 rounded-2xl glass-panel border border-gray-800/80">
        <div class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 mb-2 px-2 flex items-center justify-between">
            <span>🔤 Alphabetical Lyrics Index</span>
            @if(request('letter'))
                <span class="text-emerald-400">Filtering by starting letter: <strong>{{ strtoupper(request('letter')) }}</strong></span>
            @endif
        </div>
        <div class="flex flex-wrap items-center gap-1.5 overflow-x-auto pb-1">
            <a href="{{ request()->fullUrlWithQuery(['letter' => null]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ empty($selectedLetter) ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 hover:text-white border border-gray-800' }}">
                ALL
            </a>
            <a href="{{ request()->fullUrlWithQuery(['letter' => '#']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $selectedLetter === '#' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 hover:text-white border border-gray-800' }}">
                #
            </a>
            @foreach(range('A', 'Z') as $char)
                <a href="{{ request()->fullUrlWithQuery(['letter' => $char]) }}" class="w-8 h-8 rounded-xl text-xs font-bold transition flex items-center justify-center {{ $selectedLetter === $char ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 hover:text-white border border-gray-800' }}">
                    {{ $char }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Spotify-Style Songs Card Grid -->
    @if($songs->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @foreach($songs as $song)
                <a href="{{ route('songs.show', $song->slug) }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-transparent hover:border-emerald-500/20 shadow-lg">
                    <!-- Artwork -->
                    <div class="relative aspect-square w-full rounded-xl overflow-hidden mb-3.5 bg-gray-950 shadow-md">
                        <img src="{{ $song->cover_art_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <!-- Floating Green Play Icon -->
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

        <!-- Pagination -->
        <div class="mt-10">
            {{ $songs->links() }}
        </div>
    @else
        <div class="glass-panel rounded-2xl p-12 text-center max-w-md mx-auto my-12">
            <h3 class="text-lg font-bold text-white mb-1">No lyrics found</h3>
            <p class="text-sm text-gray-400 mb-4">No song matches your current search term or filter.</p>
            <a href="{{ route('songs.index') }}" class="inline-block px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold text-xs">
                Reset Search
            </a>
        </div>
    @endif

</div>
@endsection
