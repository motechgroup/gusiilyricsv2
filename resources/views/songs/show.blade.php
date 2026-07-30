@extends('layouts.app')

@section('title', $song->title . ' Lyrics - ' . $song->display_artist_names . ' | GusiiLyrics')
@section('meta_description', 'Read the full lyrics of ' . $song->title . ' by ' . $song->display_artist_names . ', discover related songs, artist biography, latest releases and trending Kisii music.')
@section('meta_keywords', implode(', ', [
    $song->title,
    $song->title . ' Lyrics',
    $song->display_artist_names,
    $song->display_artist_names . ' Lyrics',
    $song->display_artist_names . ' Songs',
    'Latest ' . $song->display_artist_names . ' Songs',
    'Ekegusii Lyrics',
    'Kisii Song Lyrics',
    'Kenyan Lyrics',
    'African Lyrics'
]))

@section('content')

<!-- Google Rich Search Snippet JSON-LD Schemas -->
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'MusicRecording',
        'name' => $song->title,
        'byArtist' => [
            '@type' => 'MusicGroup',
            'name' => $song->artist->name
        ],
        'inAlbum' => $song->album ? [
            '@type' => 'MusicAlbum',
            'name' => $song->album->title
        ] : null,
        'genre' => $song->genre->name ?? 'Ekegusii Music',
        'datePublished' => $song->release_year ?: $song->created_at->format('Y'),
        'image' => $song->cover_art_url,
        'url' => $song->seo_url
    ];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/')
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Artists',
                'item' => route('artists.index')
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $song->artist->name,
                'item' => route('artists.show', $song->artist->slug)
            ],
            [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $song->title . ' Lyrics',
                'item' => $song->seo_url
            ]
        ]
    ];
@endphp
<script type="application/ld+json">
{!! json_encode(array_filter($schemaData), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<!-- Spotify Single Track Blended Hero Header -->
<div class="relative min-h-[360px] lg:min-h-[420px] flex items-end pb-8 bg-gradient-to-b from-[#2a3f58] via-[#121c2a] to-[#090d16] border-b border-gray-800/60 overflow-hidden">
    <!-- Blended Ambient Backdrop Artwork -->
    <div class="absolute inset-0 opacity-25 bg-center bg-cover filter blur-2xl pointer-events-none transform scale-110" style="background-image: url('{{ $song->cover_art_url }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#090d16] via-[#090d16]/70 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <!-- Visible Breadcrumb Trail -->
        <nav class="mb-6 flex items-center gap-2 text-xs text-gray-300 font-medium">
            <a href="{{ route('home') }}" class="hover:text-emerald-400">Home</a>
            <span>&gt;</span>
            <a href="{{ route('artists.index') }}" class="hover:text-emerald-400">Artists</a>
            <span>&gt;</span>
            <a href="{{ route('artists.show', $song->artist->slug) }}" class="hover:text-emerald-400">{{ $song->artist->name }}</a>
            <span>&gt;</span>
            <span class="text-emerald-400 font-bold">{{ $song->title }} Lyrics</span>
        </nav>

        <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6 sm:gap-8 text-center sm:text-left">
            
            <!-- Large Square Cover Artwork (Spotify Album Style) -->
            <div class="w-44 h-44 sm:w-52 sm:h-52 rounded-2xl overflow-hidden shrink-0 shadow-2xl border border-white/10 bg-gray-950">
                <img src="{{ $song->cover_art_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover">
            </div>

            <!-- Song Metadata & Massive Title -->
            <div class="space-y-3 flex-grow">
                <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-emerald-400">
                    {{ $song->genre->name ?? 'Song' }}
                </span>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                    {{ $song->title }}
                </h1>

                <!-- Artist Avatar Line & Metrics (Includes Collaborators) -->
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 text-xs sm:text-sm text-gray-300">
                    @foreach($song->all_artists as $index => $art)
                        <div class="inline-flex items-center gap-1.5">
                            @if($index > 0)<span class="text-amber-400 font-bold">ft.</span>@endif
                            <img src="{{ $art->avatar_url }}" alt="{{ $art->name }}" class="w-7 h-7 rounded-full object-cover border border-emerald-500/40 shrink-0">
                            <a href="{{ route('artists.show', $art->slug) }}" class="font-bold text-white hover:text-emerald-400 hover:underline">
                                {{ $art->name }}
                            </a>
                        </div>
                    @endforeach
                    <span>•</span>
                    <span class="text-gray-400">{{ $song->release_year ?: '2026' }}</span>
                    @if((\App\Models\Setting::get('show_song_views_public', '1') !== '0') || \Illuminate\Support\Facades\Auth::check())
                        <span>•</span>
                        <span class="font-mono text-emerald-400">👁️ {{ number_format($song->views_count) }} views</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Spotify Control Action Bar -->
<div class="bg-[#0b111d] border-b border-gray-800/80 sticky top-14 z-30 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
        
        <div class="flex items-center gap-4">
            <!-- Spotify Big Green Circular Play Icon -->
            @if($song->spotify_url)
                <a href="{{ $song->spotify_url }}" target="_blank" title="Play on Spotify" class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-emerald-500 hover:bg-emerald-400 hover:scale-105 text-slate-950 flex items-center justify-center shadow-2xl transition duration-300">
                    <svg class="w-7 h-7 ml-1 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </a>
            @else
                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center shadow-2xl">
                    <svg class="w-7 h-7 ml-1 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            @endif

            <!-- Streaming Badges -->
            <div class="flex items-center gap-2">
                @if($song->spotify_url)
                    <a href="{{ $song->spotify_url }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-[#1DB954]/15 hover:bg-[#1DB954]/25 text-[#1DB954] border border-[#1DB954]/30 text-xs font-bold transition flex items-center gap-1.5">
                        <span>Spotify</span>
                    </a>
                @endif

                @if($song->youtube_url)
                    <a href="{{ $song->youtube_url }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 text-xs font-bold transition flex items-center gap-1.5">
                        <span>YouTube Video</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Submit Correction Trigger -->
        <button onclick="openCorrectionModal()" class="px-4 py-2 rounded-xl bg-gray-900 hover:bg-gray-800 text-gray-300 border border-gray-800 text-xs font-semibold transition flex items-center gap-1.5 shrink-0">
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <span class="hidden sm:inline">Submit Correction</span>
            <span class="sm:hidden">Fix</span>
        </button>

    </div>
</div>

<!-- Seamless Lyrics Reading Canvas -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- Section Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-800/80">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-400">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Official Ekegusii Song Lyrics</span>
        </div>
        <span class="text-xs text-gray-400 font-mono">Copy Protected</span>
    </div>

    <!-- Lyrics Above Ad Spot -->
    @php
        $lyricsAboveAd = \App\Models\SiteAd::getAdForSpot('lyrics_above');
        $inLyricsAd = \App\Models\SiteAd::getAdForSpot('in_lyrics');
        $lyricsBelowAd = \App\Models\SiteAd::getAdForSpot('lyrics_below');
        $adsenseCode = \App\Models\Setting::get('google_adsense_code', '');
        $adsensePubId = '';
        if ($adsenseCode) {
            if (preg_match('/ca-pub-\d+/', $adsenseCode, $m)) {
                $adsensePubId = $m[0];
            } else {
                $adsensePubId = str_starts_with($adsenseCode, 'ca-pub-') ? $adsenseCode : (str_starts_with($adsenseCode, 'pub-') ? 'ca-' . $adsenseCode : 'ca-pub-' . $adsenseCode);
            }
        }

        // Split raw lyrics into stanzas by double line breaks
        $rawBlocks = array_values(array_filter(preg_split('/\n\s*\n/', trim($song->lyrics_raw))));
        $parsedBlocks = [];

        foreach ($rawBlocks as $b) {
            $bTrimmed = trim($b);
            if (!$bTrimmed) continue;

            // Header matching regex for [Section] or Section:
            if (preg_match('/^\[?([A-Za-z0-9\s\-]+)\]?:?\s*\n(.*)$/s', $bTrimmed, $matches)) {
                $headerCandidate = trim($matches[1]);
                if (preg_match('/^(Intro|Verse|Chorus|Pre-Chorus|Bridge|Outro|Refrain|Hook|Spoken Word)/i', $headerCandidate)) {
                    $parsedBlocks[] = [
                        'header' => $headerCandidate,
                        'content' => trim($matches[2])
                    ];
                    continue;
                }
            }

            $parsedBlocks[] = [
                'header' => null,
                'content' => $bTrimmed
            ];
        }
    @endphp

    @if($lyricsAboveAd)
        <div class="text-center py-2">
            @if($lyricsAboveAd->type === 'image' && $lyricsAboveAd->image_path)
                <a href="{{ $lyricsAboveAd->target_url ?? '#' }}" target="_blank" rel="noopener" class="inline-block max-w-full">
                    <img src="{{ $lyricsAboveAd->image_url }}" alt="{{ $lyricsAboveAd->title }}" class="max-h-24 w-auto rounded-2xl border border-gray-800 shadow-md mx-auto">
                </a>
            @elseif($lyricsAboveAd->type === 'script' && $lyricsAboveAd->code_script)
                <div class="inline-block max-w-full">
                    {!! $lyricsAboveAd->code_script !!}
                </div>
            @endif
        </div>
    @endif

    <!-- Lyrics Text Flow Broken Into Structured Song Blocks With Section Badges -->
    <div class="space-y-8 sm:space-y-10">
        @foreach($parsedBlocks as $index => $block)
            <div class="lyrics-content no-copy unselectable text-base sm:text-xl text-gray-100 font-medium leading-relaxed select-none font-sans space-y-3 py-1">
                @if(!empty($block['header']))
                    @php
                        $h = strtolower($block['header']);
                        $badgeStyle = 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30';
                        if (str_contains($h, 'intro')) $badgeStyle = 'bg-purple-500/15 text-purple-400 border-purple-500/30';
                        elseif (str_contains($h, 'chorus') || str_contains($h, 'refrain') || str_contains($h, 'hook')) $badgeStyle = 'bg-amber-500/20 text-amber-300 border-amber-500/40 font-bold';
                        elseif (str_contains($h, 'bridge')) $badgeStyle = 'bg-indigo-500/15 text-indigo-400 border-indigo-500/30';
                        elseif (str_contains($h, 'pre-chorus')) $badgeStyle = 'bg-sky-500/15 text-sky-400 border-sky-500/30';
                        elseif (str_contains($h, 'outro')) $badgeStyle = 'bg-rose-500/15 text-rose-400 border-rose-500/30';
                        elseif (str_contains($h, 'spoken')) $badgeStyle = 'bg-cyan-500/15 text-cyan-400 border-cyan-500/30';
                    @endphp

                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider font-mono border {{ $badgeStyle }}">
                        <span>[{{ strtoupper($block['header']) }}]</span>
                    </div>
                @endif

                <div class="whitespace-pre-line text-gray-100 leading-loose">
                    {!! trim($block['content']) !!}
                </div>
            </div>

            <!-- Insert AdSense / Custom Banner in-between stanzas (after 1st and 3rd blocks) -->
            @if(($index === 0 || $index === 2) && $index < count($parsedBlocks) - 1)
                <div class="my-6 py-4 text-center space-y-2">
                    <span class="text-[9px] uppercase tracking-widest text-gray-500 font-mono block">Advertisement</span>
                    @if($inLyricsAd)
                        @if(($inLyricsAd->type === 'custom' || $inLyricsAd->type === 'image') && $inLyricsAd->image_path)
                            <a href="{{ $inLyricsAd->target_url ?? '#' }}" target="_blank" rel="noopener" class="inline-block max-w-full">
                                <img src="{{ $inLyricsAd->image_url }}" alt="{{ $inLyricsAd->title }}" class="max-h-28 sm:max-h-36 w-auto rounded-xl border border-emerald-500/30 shadow-xl mx-auto">
                            </a>
                        @elseif($inLyricsAd->code_script)
                            <div class="inline-block max-w-full overflow-hidden">
                                {!! $inLyricsAd->code_script !!}
                            </div>
                        @endif
                    @elseif($adsenseCode)
                        <!-- Google AdSense In-Article Responsive Banner -->
                        <ins class="adsbygoogle"
                             style="display:block; text-align:center;"
                             data-ad-layout="in-article"
                             data-ad-format="fluid"
                             data-ad-client="{{ $adsensePubId }}"
                             data-ad-slot="1234567890"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    @else
                        <!-- Promotional Music Banner -->
                        <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-950/60 via-gray-900 to-emerald-950/60 border border-emerald-500/20 text-center space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 font-mono">Promote Your Release On Gusii Lyrics</span>
                            <p class="text-xs text-gray-300">Are you an artist? Get your song lyrics featured & promoted to 150K+ Ekegusii music fans!</p>
                            <a href="{{ route('promote-music') }}" class="inline-block px-4 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md transition">
                                Promote Your Music &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    <!-- Lyrics Below Ad Spot -->
    @if($lyricsBelowAd)
        <div class="text-center py-2">
            @if(($lyricsBelowAd->type === 'custom' || $lyricsBelowAd->type === 'image') && $lyricsBelowAd->image_path)
                <a href="{{ $lyricsBelowAd->target_url ?? '#' }}" target="_blank" rel="noopener" class="inline-block max-w-full">
                    <img src="{{ $lyricsBelowAd->image_url }}" alt="{{ $lyricsBelowAd->title }}" class="max-h-24 w-auto rounded-2xl border border-emerald-500/30 shadow-xl mx-auto">
                </a>
            @elseif($lyricsBelowAd->code_script)
                <div class="inline-block max-w-full">
                    {!! $lyricsBelowAd->code_script !!}
                </div>
            @endif
        </div>
    @endif

    <!-- Copyright Anti-Theft Watermark -->
    <div class="pt-6 border-t border-gray-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 font-mono gap-2 unselectable">
        <div class="flex items-center gap-1.5">
            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            <span>© Gusii Lyrics. Copying text is restricted.</span>
        </div>
        <span>ID: GSH-{{ $song->id }}-2026</span>
    </div>

    <!-- End-of-Lyrics Simple Support Callout (Un-enclosed) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-6 border-t border-gray-800/80 text-center sm:text-left">
        <div>
            <h4 class="text-lg font-black text-white">Enjoying reading lyrics? Support <span class="text-amber-400">Gusii Lyrics</span></h4>
            <p class="text-xs text-gray-400 mt-0.5">Your support helps keep Gusiilyrics online and free for everyone.</p>
        </div>
        <a href="{{ route('donate') }}" class="px-7 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-amber-400 to-emerald-400 hover:from-emerald-400 hover:to-amber-300 text-slate-950 font-black text-xs shadow-lg shadow-amber-400/20 shrink-0 transition transform hover:scale-105 inline-block">
            ❤️ Support / Donate &rarr;
        </a>
    </div>

</div>

<!-- Submit Correction Modal -->
<div id="correctionModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl space-y-4">
        <button onclick="closeCorrectionModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div>
            <h3 class="text-xl font-extrabold text-white">Submit Lyric Correction</h3>
            <p class="text-xs text-gray-400 mt-1">Spotted a typo or missing verse in <strong>{{ $song->title }}</strong>?</p>
        </div>

        <form method="POST" action="{{ route('actions.submit-correction') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="song_id" value="{{ $song->id }}">

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Issue Type</label>
                <select name="correction_type" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                    <option value="spelling">Spelling / Typo Correction</option>
                    <option value="missing_lines">Missing Lyrics / Verse</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Correction Details <span class="text-rose-500">*</span></label>
                <textarea name="details" rows="4" required placeholder="Describe the mistake and provide the correct lyric lines..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Your Name / Email (Optional)</label>
                <input type="text" name="visitor_name" placeholder="Your name or email..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition">
                Submit Correction Report
            </button>
        </form>
    </div>
</div>

<script>
    function openCorrectionModal() { document.getElementById('correctionModal').classList.remove('hidden'); }
    function closeCorrectionModal() { document.getElementById('correctionModal').classList.add('hidden'); }
</script>
@endsection
