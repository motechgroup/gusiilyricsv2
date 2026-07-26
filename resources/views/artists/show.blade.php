@extends('layouts.app')

@section('title', $artist->name . ' Lyrics, Songs, Albums & Biography | GusiiLyrics')
@section('meta_description', 'Read all ' . $artist->name . ' lyrics, discover albums, popular songs, biography, latest releases and official YouTube videos on GusiiLyrics.com.')

@section('content')

<!-- Spotify-Style Blended Artist Hero Banner -->
<div class="relative min-h-[380px] lg:min-h-[440px] flex items-end pb-10 bg-gradient-to-b from-[#1a2e45] via-[#101b2b] to-[#090d16] border-b border-gray-800/60 overflow-hidden">
    <!-- Blended Backdrop Artwork -->
    <div class="absolute inset-0 opacity-25 bg-center bg-cover filter blur-xl pointer-events-none transform scale-110" style="background-image: url('{{ $artist->avatar_url }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#090d16] via-[#090d16]/60 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="flex flex-col md:flex-row items-center md:items-end gap-6 sm:gap-8 text-center md:text-left">
            
            <!-- Artist Profile Picture -->
            <div class="w-36 h-36 sm:w-48 sm:h-48 rounded-full overflow-hidden shrink-0 shadow-2xl border-4 border-emerald-500/30">
                <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
            </div>

            <!-- Artist Meta Info -->
            <div class="space-y-3 flex-grow">
                <!-- Verified Artist Badge -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30 text-xs font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4 fill-current text-blue-400" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    <span>Verified Ekegusii Artist</span>
                </div>

                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-none">
                    {{ $artist->name }}
                </h1>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs font-mono text-gray-300">
                    <span>📍 Origin: <strong class="text-white">{{ $artist->origin ?: $artist->location }}</strong></span>
                    <span>•</span>
                    <span>⏳ Active: <strong class="text-white">{{ $artist->active_years ?: '2010 - Present' }}</strong></span>
                    <span>•</span>
                    <span>🏷️ Label: <strong class="text-white">{{ $artist->label ?: 'Gusii Music Archive' }}</strong></span>
                    <span>•</span>
                    <span>🎶 <strong class="text-emerald-400">{{ $artist->songs->count() }} Songs Indexed</strong></span>
                </div>

                @if($artist->bio)
                    <p class="text-xs sm:text-sm text-gray-300 max-w-3xl leading-relaxed pt-1">
                        {{ $artist->bio }}
                    </p>
                @endif
            </div>

        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <!-- Song Lyrics Section: Spotify Card Grid -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Popular Songs & Lyrics</h2>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $artist->songs->count() }} Songs</span>
        </div>

        @if($artist->songs->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach($artist->songs as $song)
                    <a href="{{ $song->seo_url }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-transparent hover:border-emerald-500/20 shadow-lg">
                        <!-- Artwork Container -->
                        <div class="relative aspect-square w-full rounded-xl overflow-hidden mb-3.5 bg-gray-950 shadow-md">
                            <img src="{{ $song->cover_art_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            
                            <!-- Floating Green Play Button -->
                            <div class="absolute bottom-2 right-2 w-11 h-11 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center shadow-2xl opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-2 transition-all duration-300">
                                <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        <!-- Song Info -->
                        <div>
                            <h3 class="font-bold text-white text-sm sm:text-base truncate group-hover:text-emerald-400 transition leading-snug">
                                {{ $song->title }}
                            </h3>
                            <p class="text-xs text-gray-400 truncate mt-1">
                                {{ $artist->name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="glass-panel p-8 rounded-2xl text-center text-gray-400 text-sm">
                No song lyrics indexed for this artist yet.
            </div>
        @endif
    </div>

    <!-- Albums & Discography Section -->
    @if($artist->albums->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Albums & EPs</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($artist->albums as $album)
                    <a href="{{ route('albums.show', $album->slug) }}" class="group p-5 rounded-3xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-gray-800/80 shadow-lg">
                        <div>
                            <div class="relative aspect-square w-full rounded-2xl overflow-hidden mb-4 bg-gray-950 shadow-md">
                                <img src="{{ $album->cover_art_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <h3 class="font-bold text-white text-base truncate group-hover:text-emerald-400 transition leading-snug">
                                {{ $album->title }}
                            </h3>
                            <p class="text-xs text-gray-400 truncate mt-1">{{ $album->release_year ?: 'Album' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Frequently Asked Questions (FAQs) -->
    <div class="glass-panel p-8 rounded-3xl border border-gray-800 space-y-6">
        <h2 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-2">
            <span>❓ Frequently Asked Questions about {{ $artist->name }}</span>
        </h2>

        <div class="space-y-4 text-xs sm:text-sm">
            <div class="p-4 rounded-2xl bg-gray-950/60 border border-gray-800/80 space-y-1">
                <h3 class="font-bold text-white">Who is {{ $artist->name }}?</h3>
                <p class="text-gray-300 leading-relaxed">{{ $artist->name }} is an accomplished Ekegusii recording artist based in {{ $artist->origin ?: $artist->location }}, known for contributing to Gusii music heritage.</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-950/60 border border-gray-800/80 space-y-1">
                <h3 class="font-bold text-white">Where can I read official lyrics for {{ $artist->name }}'s songs?</h3>
                <p class="text-gray-300 leading-relaxed">You can read official, word-for-word Ekegusii lyrics, English translations, and song meanings right here on GusiiLyrics.com.</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-950/60 border border-gray-800/80 space-y-1">
                <h3 class="font-bold text-white">How many songs by {{ $artist->name }} are indexed?</h3>
                <p class="text-gray-300 leading-relaxed">Currently, {{ $artist->songs->count() }} official songs by {{ $artist->name }} are cataloged in our music library.</p>
            </div>
        </div>
    </div>

</div>

<!-- JSON-LD Structured Data Schema -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "MusicGroup",
  "name": "{{ $artist->name }}",
  "description": "{{ addslashes($artist->bio) }}",
  "image": "{{ $artist->avatar_url }}",
  "url": "{{ url()->current() }}",
  "genre": "Ekegusii Music"
}
</script>
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "Who is {{ $artist->name }}?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "{{ addslashes($artist->name . ' is an accomplished Ekegusii recording artist based in ' . ($artist->origin ?: $artist->location)) }}"
    }
  }, {
    "@type": "Question",
    "name": "Where can I read official lyrics for {{ $artist->name }}?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "You can read official Ekegusii lyrics and translations on GusiiLyrics.com."
    }
  }]
}
</script>

@endsection
