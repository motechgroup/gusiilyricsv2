@extends('layouts.app')

@section('title', $title . ' - GusiiLyrics')
@section('meta_description', $metaDescription)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Trending <span class="text-gradient-emerald">Gusii Recording Artists</span>
        </h1>
        <p class="text-gray-400 text-sm mt-1">Discover top performing Ekegusii vocalists, legends, and rising music stars.</p>
    </div>

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
                    <span>{{ $artist->songs_count }} Songs</span>
                    <span class="text-emerald-400 font-bold group-hover:translate-x-1 transition-transform">Explore Profile &rarr;</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $artists->links() }}
    </div>
</div>
@endsection
