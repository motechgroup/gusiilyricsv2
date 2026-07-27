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

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($genres as $genre)
            <a href="{{ route('categories.genre', $genre->slug) }}" class="group p-5 rounded-2xl bg-[#121927]/70 hover:bg-[#1c273c] border border-gray-800/80 hover:border-emerald-500/30 transition duration-300 flex items-center gap-4 shadow-lg">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition duration-300">
                    {{ $genre->icon ?: '🎵' }}
                </div>
                <div class="truncate">
                    <h3 class="font-bold text-white text-base truncate group-hover:text-emerald-400 transition leading-snug">
                        {{ $genre->name }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
