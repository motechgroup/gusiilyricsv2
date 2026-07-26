@extends('layouts.app')

@section('title', 'Ekegusii Music Albums & Discography Directory - GusiiLyrics')
@section('meta_description', 'Discover official Ekegusii music albums, EP releases, and full discographies from top Gusii artists on GusiiLyrics.com.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Gusii <span class="text-gradient-emerald">Music Albums & Discography</span>
        </h1>
        <p class="text-gray-400 text-sm mt-1">Browse official albums, EPs, and track listings from Ekegusii recording artists.</p>
    </div>

    @if($albums->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @foreach($albums as $album)
                <a href="{{ route('albums.show', $album->slug) }}" class="group p-5 rounded-3xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-gray-800/80 shadow-lg">
                    <div>
                        <div class="relative aspect-square w-full rounded-2xl overflow-hidden mb-4 bg-gray-950 shadow-md border border-gray-800">
                            <img src="{{ $album->cover_art_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>

                        <h3 class="font-bold text-white text-base truncate group-hover:text-emerald-400 transition leading-snug">
                            {{ $album->title }}
                        </h3>
                        <p class="text-xs text-gray-400 truncate mt-1">
                            {{ $album->artist->name }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-800 flex items-center justify-between text-xs text-gray-500 font-mono">
                        <span>{{ $album->release_year ?: 'Album' }}</span>
                        <span class="text-emerald-400 font-bold">{{ $album->songs_count }} Tracks</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $albums->links() }}
        </div>
    @else
        <div class="glass-panel rounded-2xl p-12 text-center max-w-md mx-auto my-12">
            <h3 class="text-lg font-bold text-white mb-1">No albums added yet</h3>
            <p class="text-sm text-gray-400 mb-4">Check back soon for newly cataloged Ekegusii albums!</p>
        </div>
    @endif
</div>
@endsection
