@extends('layouts.app')

@section('title', $artist->name . ' Lyrics, Songs, Albums & Biography | GusiiLyrics')
@section('meta_description', 'Read all ' . $artist->name . ' lyrics, discover albums, popular songs, biography, latest releases and official YouTube videos on GusiiLyrics.com.')

@section('content')

<!-- Spotify-Style Blended Artist Hero Banner (Artist Image as Background Banner) -->
<div class="relative min-h-[380px] lg:min-h-[440px] flex items-end pb-10 bg-gray-950 border-b border-gray-800/60 overflow-hidden">
    <!-- Crisp Artist Cover Background Image -->
    <div class="absolute inset-0 bg-center bg-cover opacity-35 filter blur-md pointer-events-none transform scale-105" style="background-image: url('{{ $artist->avatar_url }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#090d16] via-[#090d16]/70 to-[#090d16]/40"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="flex flex-col md:flex-row items-center md:items-end gap-6 sm:gap-8 text-center md:text-left">
            
            <!-- Artist Profile Picture with Floating Verified Badge -->
            <div class="relative shrink-0">
                <div class="w-36 h-36 sm:w-48 sm:h-48 rounded-full overflow-hidden shadow-2xl border-4 border-emerald-500/40 bg-gray-950">
                    <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                </div>
                <!-- Blue Verified Checkmark Badge on Profile Picture -->
                <div class="absolute bottom-1 right-1 sm:bottom-2 sm:right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-2xl border-2 border-[#090d16]" title="Verified Ekegusii Artist">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
            </div>

            <!-- Artist Meta Info -->
            <div class="space-y-3 flex-grow">
                @if($artist->genre)
                    <div>
                        <a href="{{ route('categories.genre', $artist->genre->slug) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30 text-xs font-bold uppercase tracking-wider hover:bg-purple-500/30 transition">
                            <span>{{ $artist->genre->icon }} {{ $artist->genre->name }}</span>
                        </a>
                    </div>
                @endif

                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-none">
                    {{ $artist->name }}
                </h1>

                @php
                    $isFollowed = $artist->isFollowedByVisitor();
                @endphp

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs font-mono text-gray-300">
                    <span>📍 Region: <strong class="text-emerald-400 font-bold">{{ $artist->location }}</strong></span>
                    <span>•</span>
                    <span>🎶 <strong class="text-emerald-400">{{ $allSongs->count() }} Songs</strong></span>
                    <span>•</span>
                    <span>👥 <strong id="follower-count" class="text-emerald-400 font-bold">{{ $artist->formatted_followers }}</strong> Followers</span>
                </div>

                <!-- Follow Artist & Social Media Icons Horizontal Row (Mobile Friendly) -->
                @php
                    $ytUrl = $artist->youtube ?: 'https://www.youtube.com/results?search_query=' . urlencode($artist->name . ' Ekegusii');
                    $spUrl = $artist->spotify ?: 'https://open.spotify.com/search/' . urlencode($artist->name);
                    $igUrl = $artist->instagram ?: 'https://www.instagram.com/explore/tags/' . urlencode(Str::slug($artist->name, ''));
                    $fbUrl = $artist->facebook ?: 'https://www.facebook.com/search/top?q=' . urlencode($artist->name);
                    $tkUrl = $artist->tiktok ?: 'https://www.tiktok.com/search?q=' . urlencode($artist->name);
                    $webUrl = $artist->website ?: route('artists.show', $artist->slug);
                @endphp

                <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-2.5 sm:gap-3">
                    <!-- Follow Artist Button -->
                    <form id="follow-artist-form" action="{{ route('artists.follow', $artist->id) }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit" id="follow-btn" class="px-5 py-2.5 rounded-full text-xs font-extrabold transition duration-300 flex items-center gap-2 shadow-xl cursor-pointer select-none {{ $isFollowed ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 hover:bg-rose-500/20 hover:text-rose-300 hover:border-rose-500/40' : 'bg-emerald-500 hover:bg-emerald-400 text-slate-950 hover:scale-105' }}">
                            <svg id="follow-icon" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                @if($isFollowed)
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                @else
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                @endif
                            </svg>
                            <span id="follow-text">{{ $isFollowed ? 'Following' : 'Follow Artist' }}</span>
                        </button>
                    </form>

                    <!-- Horizontal Social Media Icons -->
                    <div class="flex items-center gap-2">
                        <a href="{{ $ytUrl }}" target="_blank" rel="noopener" title="YouTube Channel - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>

                        <a href="{{ $spUrl }}" target="_blank" rel="noopener" title="Spotify Artist - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-emerald-500/15 hover:bg-emerald-500/30 text-[#1DB954] border border-[#1DB954]/30 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.503 17.306c-.22.36-.688.473-1.047.252-2.868-1.754-6.478-2.152-10.73-1.18-.41.094-.82-.164-.913-.574-.094-.41.164-.82.574-.913 4.654-1.064 8.653-.615 11.864 1.348.36.22.473.687.252 1.067zm1.47-3.267c-.276.45-.866.592-1.316.315-3.282-2.017-8.287-2.602-12.17-1.423-.505.153-1.04-.132-1.193-.637-.153-.505.132-1.04.637-1.193 4.437-1.346 9.948-.7 13.727 1.622.45.277.592.866.315 1.316zm.126-3.41c-3.935-2.337-10.428-2.553-14.205-1.406-.605.183-1.246-.164-1.43-.769-.183-.605.164-1.246.769-1.43 4.337-1.316 11.5-1.06 16.027 1.628.544.323.72 1.026.397 1.57-.323.545-1.026.72-1.558.397z"/></svg>
                        </a>

                        <a href="{{ $igUrl }}" target="_blank" rel="noopener" title="Instagram Profile - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-pink-500/15 hover:bg-pink-500/30 text-pink-400 border border-pink-500/30 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>

                        <a href="{{ $fbUrl }}" target="_blank" rel="noopener" title="Facebook Page - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-sky-500/15 hover:bg-sky-500/30 text-sky-400 border border-sky-500/30 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        <a href="{{ $tkUrl }}" target="_blank" rel="noopener" title="TikTok Profile - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-cyan-500/15 hover:bg-cyan-500/30 text-cyan-400 border border-cyan-500/30 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.36 1.47-1.41 2.45-.04 1.02.43 2.05 1.22 2.68.85.67 2.03.88 3.06.57 1.05-.3 1.89-1.13 2.17-2.18.15-.65.17-1.32.17-1.99V.02z"/></svg>
                        </a>

                        <a href="{{ $webUrl }}" target="_blank" rel="noopener" title="Official Website - {{ $artist->name }}" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-gray-700 text-gray-300 border border-gray-700 hover:scale-110 transition flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </a>
                    </div>
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
            <h2 class="text-2xl font-extrabold text-white tracking-tight">All Songs & Discography</h2>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $allSongs->count() }} Songs & Collaborations</span>
        </div>

        @if($allSongs->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach($allSongs as $song)
                    <a href="{{ route('songs.show', $song->slug) }}" class="group p-4 rounded-2xl bg-[#121927]/60 hover:bg-[#1c273c] transition duration-300 flex flex-col justify-between border border-transparent hover:border-emerald-500/20 shadow-lg">
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
                                {{ $song->display_artist_names }}
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

<script>
document.getElementById('follow-artist-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('follow-btn');
    const text = document.getElementById('follow-text');
    const icon = document.getElementById('follow-icon');
    const countEl = document.getElementById('follower-count');

    btn.style.opacity = '0.7';

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        btn.style.opacity = '1';
        if (data.success) {
            if (data.is_following) {
                btn.className = 'px-5 py-2 rounded-full text-xs font-extrabold transition duration-300 flex items-center gap-2 shadow-xl cursor-pointer select-none bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 hover:bg-rose-500/20 hover:text-rose-300 hover:border-rose-500/40';
                text.textContent = 'Following';
                icon.innerHTML = '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>';
            } else {
                btn.className = 'px-5 py-2 rounded-full text-xs font-extrabold transition duration-300 flex items-center gap-2 shadow-xl cursor-pointer select-none bg-emerald-500 hover:bg-emerald-400 text-slate-950 hover:scale-105';
                text.textContent = 'Follow Artist';
                icon.innerHTML = '<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>';
            }
            if (countEl && data.formatted_followers !== undefined) {
                countEl.textContent = data.formatted_followers;
            }
        }
    })
    .catch(() => {
        btn.style.opacity = '1';
    });
});
</script>

@endsection
