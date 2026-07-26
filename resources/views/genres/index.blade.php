@extends('layouts.app')

@section('title', 'Ekegusii Music Genres Directory - GusiiLyrics')
@section('meta_description', 'Explore Gusii music genres including Gospel, Traditional Obokano, Benga, Love Ballads, and Wedding Celebration Songs on GusiiLyrics.com.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Ekegusii <span class="text-gradient-emerald">Music Genres</span>
        </h1>
        <p class="text-gray-400 text-sm mt-1">Browse Ekegusii song lyrics by musical category and cultural style.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($genres as $genre)
            <a href="{{ route('categories.genre', $genre->slug) }}" class="glass-card rounded-3xl p-6 group flex flex-col justify-between border border-gray-800 hover:border-emerald-500/40 transition duration-300">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-2xl group-hover:scale-110 transition duration-300">
                        {{ $genre->icon ?: '🎵' }}
                    </div>

                    <h3 class="font-extrabold text-white text-lg group-hover:text-emerald-400 transition">{{ $genre->name }}</h3>
                    <p class="text-xs text-gray-300 line-clamp-3 leading-relaxed">
                        {{ $genre->description }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-800 flex items-center justify-between text-xs text-gray-500 font-mono">
                    <span>{{ $genre->songs_count }} Songs</span>
                    <span class="text-emerald-400 font-bold group-hover:translate-x-1 transition-transform">Explore &rarr;</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
