@extends('layouts.app')

@section('title', 'About Us - Gusii Lyrics Vault & Cultural Music Archive')
@section('meta_description', 'Learn about Gusii Lyrics, our mission to preserve Ekegusii musical heritage, translate song lyrics, promote artists, and provide digital services.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <!-- Hero Header -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="px-3.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold font-mono uppercase">
            🎵 Preserving Ekegusii Heritage
        </span>
        <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight">
            Preserving & Celebrating <span class="bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400 bg-clip-text text-transparent">Gusii Music Heritage</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
            Gusii Lyrics is the #1 digital lyrics vault and cultural archive dedicated to indexing, translating, and connecting fans with Ekegusii music, gospel praise anthems, and Benga legends.
        </p>
    </div>

    <!-- Impact Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 text-center space-y-2 shadow-xl">
            <div class="text-3xl sm:text-4xl font-black text-emerald-400 font-mono">{{ number_format($stats['total_songs']) }}</div>
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Indexed Lyrics</div>
        </div>
        <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 text-center space-y-2 shadow-xl">
            <div class="text-3xl sm:text-4xl font-black text-amber-400 font-mono">{{ number_format($stats['total_artists']) }}</div>
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Artists, Choirs & Bands</div>
        </div>
        <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 text-center space-y-2 shadow-xl">
            <div class="text-3xl sm:text-4xl font-black text-cyan-400 font-mono">{{ number_format($stats['total_genres']) }}</div>
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Music Categories</div>
        </div>
        <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 text-center space-y-2 shadow-xl">
            <div class="text-3xl sm:text-4xl font-black text-pink-400 font-mono">{{ number_format($stats['total_views']) }}</div>
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Song Views</div>
        </div>
    </div>

    <!-- What We Do / Mission Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center border-t border-gray-900 pt-12">
        <div class="space-y-4">
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Our Mission & Purpose</h2>
            <p class="text-gray-300 text-xs sm:text-sm leading-relaxed">
                Music is the heartbeat of Abagusii culture. From historical Obokano harp folklore to modern Gospel praise and Benga dance hits, Ekegusii music carries stories of faith, love, history, and community resilience.
            </p>
            <p class="text-gray-300 text-xs sm:text-sm leading-relaxed">
                Our platform bridges generations by providing accurate, word-for-word song lyrics paired with English and Swahili translations. We empower local musicians, church choirs, and live bands to reach a global audience while giving fans everywhere instant access to verified lyrics.
            </p>
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span>⭐</span> Why Gusii Lyrics Matters
            </h3>
            <ul class="space-y-3 text-xs sm:text-sm text-gray-300">
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span><strong>Cultural Preservation:</strong> Digitally archiving rare traditional and gospel songs for posterity.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span><strong>Language & Learning:</strong> Providing line-by-line translations to help youth and international listeners learn Ekegusii.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span><strong>Artist Empowerment:</strong> Directing traffic to artists' official Spotify, YouTube, and Apple Music channels.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Services Offered & Call to Actions (CTAs) -->
    <div class="space-y-8 border-t border-gray-900 pt-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                Our Platform Services & Features
            </h2>
            <p class="text-gray-400 text-xs sm:text-sm">Explore how Gusii Lyrics serves fans, musicians, gospel choirs, and advertisers.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Service 1: Lyric Archive & Search -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-emerald-500/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl">
                        🔍
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-emerald-400 transition">Lyric Archive & Search</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Search and read official lyrics for over hundreds of Ekegusii songs, complete with audio preview streaming and English translations.
                    </p>
                </div>
                <a href="{{ route('songs.index') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs text-center transition">
                    Browse All Songs &rarr;
                </a>
            </div>

            <!-- Service 2: Artist, Band & Choir Directory -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-amber-400/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-400/10 border border-amber-400/30 text-amber-300 flex items-center justify-center text-xl">
                        🎤
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-amber-300 transition">Artists, Bands & Choirs</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Follow solo vocalists, live Benga bands, and church choirs. Capture follower updates without needing to create an account.
                    </p>
                </div>
                <a href="{{ route('artists.index') }}" class="px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs text-center transition">
                    Explore Directory &rarr;
                </a>
            </div>

            <!-- Service 3: Music Promotion & PR Blasts -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-cyan-500/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 flex items-center justify-center text-xl">
                        🚀
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-cyan-400 transition">Music Promotion & PR</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Promote new singles, albums, or music videos to 150K+ monthly visitors through home page priority charts and social media blasts.
                    </p>
                </div>
                <a href="{{ route('promote-music') }}" class="px-4 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-extrabold text-xs text-center transition">
                    Promote Your Track &rarr;
                </a>
            </div>

            <!-- Service 4: Banner & Display Advertising -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-pink-500/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/30 text-pink-400 flex items-center justify-center text-xl">
                        📢
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-pink-400 transition">Banner Advertising</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Reach high-intent audiences with high-visibility banner ad placements across site header, song lyrics, and sidebar zones.
                    </p>
                </div>
                <a href="{{ route('advertise') }}" class="px-4 py-2.5 rounded-xl bg-pink-500 hover:bg-pink-400 text-slate-950 font-extrabold text-xs text-center transition">
                    Advertise With Us &rarr;
                </a>
            </div>

            <!-- Service 5: Community Lyric Submissions -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-purple-500/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/30 text-purple-400 flex items-center justify-center text-xl">
                        ✍️
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-purple-400 transition">Submit Lyrics & Corrections</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Contribute unindexed song lyrics or submit correction edits to help maintain 100% accurate Ekegusii transcriptions.
                    </p>
                </div>
                <button onclick="document.getElementById('headerSearchModal')?.classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-purple-500 hover:bg-purple-400 text-slate-950 font-extrabold text-xs text-center transition">
                    Search & Submit &rarr;
                </button>
            </div>

            <!-- Service 6: Support & Voluntary Donations -->
            <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 hover:border-emerald-400/40 transition space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl">
                        💚
                    </div>
                    <h3 class="font-extrabold text-white text-base group-hover:text-emerald-400 transition">Support & Donate</h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Support our servers, domain hosting, and transcription efforts with instant M-Pesa or card donations.
                    </p>
                </div>
                <a href="{{ route('donate') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs text-center transition">
                    Support Gusii Lyrics &rarr;
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
