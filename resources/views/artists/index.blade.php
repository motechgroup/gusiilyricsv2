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

    <!-- Search & Filter Bar (Un-enclosed) -->
    <form method="GET" action="{{ route('artists.index') }}" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
        <!-- Preserve selected letter if any -->
        @if(request('letter'))
            <input type="hidden" name="letter" value="{{ request('letter') }}">
        @endif

        <!-- Search Input -->
        <div class="relative flex-grow w-full">
            <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search artist name..." class="w-full pl-11 pr-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <!-- Sort Dropdown -->
        <div class="w-full md:w-56">
            <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-gray-300 focus:outline-none focus:border-emerald-500 text-sm">
                <option value="asc" {{ ($selectedSort ?? 'asc') === 'asc' ? 'selected' : '' }}>Artist Name (A - Z)</option>
                <option value="desc" {{ ($selectedSort ?? '') === 'desc' ? 'selected' : '' }}>Artist Name (Z - A)</option>
                <option value="popular" {{ ($selectedSort ?? '') === 'popular' ? 'selected' : '' }}>Most Songs / Popular</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition shrink-0">
            Filter Artists
        </button>
        @if(request('q') || request('letter') || request('sort'))
            <a href="{{ route('artists.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold">
                Reset
            </a>
        @endif
    </form>

    <!-- A-Z Alphabetical Index Filter Bar (Un-enclosed) -->
    <div class="mb-10 py-3 border-t border-b border-gray-800/80">
        <div class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 mb-2 px-2 flex items-center justify-between">
            <span>🔤 Alphabetical Artists Index</span>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($artists as $artist)
                <a href="{{ route('artists.show', $artist->slug) }}" class="glass-card rounded-3xl p-6 text-center group flex flex-col items-center justify-between border border-gray-800">
                    <div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden mb-4 mx-auto border-2 border-emerald-500/20 group-hover:border-emerald-400 transition duration-300 shadow-xl">
                            <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>

                        <h3 class="font-bold text-white text-lg group-hover:text-emerald-400 transition mb-1">{{ $artist->name }}</h3>
                        <p class="text-xs text-emerald-400/90 font-mono mb-3">{{ $artist->location }}</p>
                        
                        <p class="text-xs text-gray-400 line-clamp-3 leading-relaxed">
                            {{ $artist->bio }}
                        </p>
                    </div>

                    <div class="w-full mt-6 pt-4 border-t border-gray-800 flex items-center justify-between text-xs text-gray-500 font-mono">
                        <span>{{ $artist->songs_count }} Lyrics</span>
                        <span class="text-emerald-400 font-bold group-hover:translate-x-1 transition-transform">Explore &rarr;</span>
                    </div>
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
