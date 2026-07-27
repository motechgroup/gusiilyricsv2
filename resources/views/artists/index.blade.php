@extends('layouts.app')

@section('title', 'Gusii Artists Directory - Ekegusii Vocalists & Legends')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Directory Header -->
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Gusii <span class="text-gradient-emerald">Recording Artists</span>
        </h1>
        <p class="text-gray-400 text-sm mt-1">Discover the voices, legends, and gospel praise leaders of Ekegusii music.</p>
    </div>

    <!-- Artist Category / Type Filter Tabs (All, Solo Artists, Bands, Choirs, Groups) -->
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border {{ empty($selectedType) ? 'bg-gradient-to-r from-emerald-500 to-amber-400 text-slate-950 border-emerald-400 shadow-lg' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border-gray-800' }}">
            🌟 All Categories
        </a>
        <a href="{{ request()->fullUrlWithQuery(['type' => 'artist']) }}" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border {{ $selectedType === 'artist' ? 'bg-gradient-to-r from-emerald-500 to-amber-400 text-slate-950 border-emerald-400 shadow-lg' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border-gray-800' }}">
            🎤 Artists
        </a>
        <a href="{{ request()->fullUrlWithQuery(['type' => 'band']) }}" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border {{ $selectedType === 'band' ? 'bg-gradient-to-r from-emerald-500 to-amber-400 text-slate-950 border-emerald-400 shadow-lg' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border-gray-800' }}">
            🎸 Music Bands
        </a>
        <a href="{{ request()->fullUrlWithQuery(['type' => 'choir']) }}" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border {{ $selectedType === 'choir' ? 'bg-gradient-to-r from-emerald-500 to-amber-400 text-slate-950 border-emerald-400 shadow-lg' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border-gray-800' }}">
            🎼 Gospel Choirs
        </a>
        <a href="{{ request()->fullUrlWithQuery(['type' => 'group']) }}" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border {{ $selectedType === 'group' ? 'bg-gradient-to-r from-emerald-500 to-amber-400 text-slate-950 border-emerald-400 shadow-lg' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border-gray-800' }}">
            👥 Music Groups
        </a>
    </div>

    <!-- Search & Filter Bar (Un-enclosed) -->
    <form method="GET" action="{{ route('artists.index') }}" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
        <!-- Preserve selected letter or type if any -->
        @if(request('letter'))
            <input type="hidden" name="letter" value="{{ request('letter') }}">
        @endif
        @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
        @endif

        <!-- Search Input -->
        <div class="relative flex-grow w-full">
            <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search artist, choir, or band name..." class="w-full pl-11 pr-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <!-- Sort Dropdown -->
        <div class="w-full md:w-64">
            <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-gray-300 focus:outline-none focus:border-emerald-500 text-sm">
                <option value="traffic" {{ ($selectedSort ?? 'traffic') === 'traffic' ? 'selected' : '' }}>🔥 Top Traffic / Views</option>
                <option value="followers" {{ ($selectedSort ?? '') === 'followers' ? 'selected' : '' }}>👥 Most Followers</option>
                <option value="asc" {{ ($selectedSort ?? '') === 'asc' ? 'selected' : '' }}>Name (A - Z)</option>
                <option value="desc" {{ ($selectedSort ?? '') === 'desc' ? 'selected' : '' }}>Name (Z - A)</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition shrink-0">
            Filter
        </button>
        @if(request('q') || request('letter') || request('sort') || request('type'))
            <a href="{{ route('artists.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold">
                Reset
            </a>
        @endif
    </form>

    <!-- A-Z Alphabetical Index Filter Bar (Un-enclosed) -->
    <div class="mb-10 py-3 border-t border-b border-gray-800/80">
        <div class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 mb-2 px-2 flex items-center justify-between">
            <span>🔤 Alphabetical Index</span>
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

    @if($artists->count() > 0)
        <!-- Compact Spotify-Style Clean Artist Cards (Image & Title Only) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($artists as $artist)
                <a href="{{ route('artists.show', $artist->slug) }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 text-center flex flex-col items-center border border-transparent hover:border-emerald-500/20 shadow-lg">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mb-3.5 border-2 border-emerald-500/20 group-hover:border-emerald-400 transition duration-300 shadow-xl">
                        <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="font-bold text-white text-sm group-hover:text-emerald-400 truncate w-full">{{ $artist->name }}</h3>
                    <p class="text-[11px] text-emerald-400 font-mono mt-0.5">{{ $artist->type_badge }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $artists->links() }}
        </div>
    @else
        <div class="glass-panel rounded-2xl p-12 text-center max-w-md mx-auto my-12">
            <h3 class="text-lg font-bold text-white mb-1">No artists found</h3>
            <p class="text-sm text-gray-400 mb-4">No recording artist matches your current starting letter or search term.</p>
            <a href="{{ route('artists.index') }}" class="inline-block px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold text-xs">
                Reset Filter
            </a>
        </div>
    @endif

</div>
@endsection
