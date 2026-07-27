@extends('layouts.app')

@section('title', 'About Us - Gusii Lyrics Cultural Preservation & Music Archive')
@section('meta_description', 'Discover Gusii Lyrics, the premier digital cultural music vault preserving Ekegusii song lyrics, translations, artist profiles, and music promotion services.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <!-- Professional Hero Banner (Un-Enclosed, High Contrast Typography) -->
    <div class="space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-xs font-extrabold font-mono tracking-wider">
            <span>🎵 EKEGUSII CULTURAL MUSIC VAULT</span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
            Preserving Ekegusii Musical Heritage & <span class="bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400 bg-clip-text text-transparent">Linguistic Legacy</span>
        </h1>

        <p class="text-gray-300 text-base sm:text-lg leading-relaxed max-w-3xl">
            Gusii Lyrics is a premier digital music archive dedicated to indexing, translating, and celebrating Ekegusii song lyrics, Gospel praise anthems, live Benga compositions, and traditional Obokano folklore from Kisii and Nyamira counties.
        </p>

        <!-- Inline Impact Metric Bar (No Enclosed Boxes) -->
        <div class="pt-4 flex flex-wrap items-center gap-6 sm:gap-12 border-t border-b border-gray-900 py-6 text-xs sm:text-sm">
            <div>
                <span class="text-2xl sm:text-3xl font-black text-emerald-400 font-mono block">{{ number_format($stats['total_songs']) }}+</span>
                <span class="text-gray-400 uppercase tracking-wider text-[11px] font-bold">Indexed Lyrics</span>
            </div>

            <div class="hidden sm:block w-px h-8 bg-gray-900"></div>

            <div>
                <span class="text-2xl sm:text-3xl font-black text-amber-400 font-mono block">{{ number_format($stats['total_artists']) }}+</span>
                <span class="text-gray-400 uppercase tracking-wider text-[11px] font-bold">Artists, Bands & Choirs</span>
            </div>

            <div class="hidden sm:block w-px h-8 bg-gray-900"></div>

            <div>
                <span class="text-2xl sm:text-3xl font-black text-cyan-400 font-mono block">{{ number_format($stats['total_genres']) }}</span>
                <span class="text-gray-400 uppercase tracking-wider text-[11px] font-bold">Music Categories</span>
            </div>

            <div class="hidden sm:block w-px h-8 bg-gray-900"></div>

            <div>
                <span class="text-2xl sm:text-3xl font-black text-pink-400 font-mono block">{{ number_format($stats['total_views']) }}+</span>
                <span class="text-gray-400 uppercase tracking-wider text-[11px] font-bold">Lyrics Read & Streamed</span>
            </div>
        </div>
    </div>

    <!-- Section 1: Executive Overview & Mission -->
    <div class="space-y-6 pt-4">
        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="text-emerald-400 font-mono">01.</span> Executive Overview & Cultural Mission
        </h2>

        <div class="space-y-4 text-sm sm:text-base text-gray-300 leading-relaxed max-w-4xl">
            <p>
                Music serves as the living oral history of Abagusii. For decades, song lyrics have captured ancestral wisdom, spiritual devotion, social commentary, and cultural pride. However, much of this artistic legacy remained fragmented across analog cassette tapes, unindexed recordings, or lost oral traditions.
            </p>
            <p>
                Founded to solve this challenge, <strong>Gusii Lyrics</strong> provides a centralized, SEO-optimized digital repository. We combine orthographic precision with multi-language translations (English and Swahili), enabling listeners across Kenya, the diaspora, and international researchers to understand and appreciate the depth of Ekegusii compositions.
            </p>
        </div>
    </div>

    <!-- Section 2: Core Archival Pillars -->
    <div class="space-y-8 border-t border-gray-900 pt-10">
        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="text-emerald-400 font-mono">02.</span> Core Archival Pillars
        </h2>

        <div class="space-y-8 text-sm text-gray-300">
            <!-- Pillar 1 -->
            <div class="space-y-2">
                <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                    <span class="text-amber-400 font-bold">✦</span> Linguistic & Orthographic Precision
                </h3>
                <p class="leading-relaxed text-gray-300">
                    We enforce strict Ekegusii spelling standards, accent marks, and dialectal nuances. Every song submission undergoes editorial review to ensure proper grammar, word spacing, and stanza separation.
                </p>
            </div>

            <!-- Pillar 2 -->
            <div class="space-y-2">
                <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                    <span class="text-amber-400 font-bold">✦</span> Cross-Cultural Translation Framework
                </h3>
                <p class="leading-relaxed text-gray-300">
                    To make Ekegusii music accessible to younger generations and international listeners, our verified song pages provide accurate line-by-line translations alongside cultural commentary on metaphors, proverbs, and biblical references.
                </p>
            </div>

            <!-- Pillar 3 -->
            <div class="space-y-2">
                <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                    <span class="text-amber-400 font-bold">✦</span> Inclusive Ecosystem for All Music Entities
                </h3>
                <p class="leading-relaxed text-gray-300">
                    Our platform categorizes music into dedicated sub-directories for <strong>🎤 Solo Artists</strong>, <strong>🎸 Live Benga Bands</strong>, <strong>🎼 Church Gospel Choirs</strong>, and <strong>👥 Music Groups</strong>, ensuring every musical genre receives structured visibility.
                </p>
            </div>
        </div>
    </div>

    <!-- Section 3: Comprehensive Platform Services & Resourceful Solutions -->
    <div class="space-y-10 border-t border-gray-900 pt-10">
        <div class="space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                <span class="text-emerald-400 font-mono">03.</span> Platform Services & Resourceful Solutions
            </h2>
            <p class="text-gray-400 text-xs sm:text-sm">Explore our suite of public services designed for music fans, artists, gospel ministries, and advertisers.</p>
        </div>

        <div class="divide-y divide-gray-900 space-y-6">

            <!-- Service Item 1 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>🔍</span> Ekegusii Lyric Archive & Multi-Language Translation
                    </h3>
                    <a href="{{ route('songs.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300 uppercase tracking-wider">
                        Browse Lyrics Library &rarr;
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    Search and read verified lyrics for hundreds of Ekegusii songs. Features instant audio previews, A-Z index filtering, song metadata, and printable lyric layouts for church choir practice and study.
                </p>
            </div>

            <!-- Service Item 2 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>🎤</span> Artist, Gospel Choir & Live Band Directory
                    </h3>
                    <a href="{{ route('artists.index') }}" class="inline-flex items-center text-xs font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                        Explore Artist Directory &rarr;
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    Dedicated profile pages showcasing full discographies, artist biographies, location info, verified streaming links (Spotify, YouTube, Apple Music), and direct social media channels. Fans can follow artists to stay updated on new releases.
                </p>
            </div>

            <!-- Service Item 3 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>🚀</span> Music PR & Priority Chart Promotion
                    </h3>
                    <a href="{{ route('promote-music') }}" class="inline-flex items-center text-xs font-bold text-cyan-400 hover:text-cyan-300 uppercase tracking-wider">
                        Submit Track for Promotion &rarr;
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    Comprehensive promotional services for recording artists, gospel choirs, and music producers. Packages include homepage chart priority placement, featured artist banners, lyric transcription verification, and multi-channel social media blasts.
                </p>
            </div>

            <!-- Service Item 4 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>📢</span> Brand Advertising & Dedicated Display Banners
                    </h3>
                    <a href="{{ route('advertise') }}" class="inline-flex items-center text-xs font-bold text-pink-400 hover:text-pink-300 uppercase tracking-wider">
                        View Advertising Options &rarr;
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    Connect your brand, event, or business directly with over 150,000+ monthly Ekegusii music enthusiasts. Flexible display ad spots available across high-visibility header placement, lyric page sidebars, and custom sponsored placements.
                </p>
            </div>

            <!-- Service Item 5 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>✍️</span> Community Lyric Submissions & Editorial Edits
                    </h3>
                    <button onclick="document.getElementById('headerSearchModal')?.classList.remove('hidden')" class="inline-flex items-center text-xs font-bold text-purple-400 hover:text-purple-300 uppercase tracking-wider">
                        Search & Submit Lyrics &rarr;
                    </button>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    We welcome lyric contributions from musicians, fans, and language scholars. Submit unindexed lyrics or propose correction edits to ensure our database maintains 100% historical and linguistic accuracy.
                </p>
            </div>

            <!-- Service Item 6 -->
            <div class="pt-6 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>💚</span> Cultural Preservation & Infrastructure Funding
                    </h3>
                    <a href="{{ route('donate') }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300 uppercase tracking-wider">
                        Make a Voluntary Support Contribution &rarr;
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                    Gusii Lyrics is an independent cultural initiative. Voluntary contributions made via M-Pesa STK Push or card directly fund cloud hosting infrastructure, domain maintenance, transcription labor, and digital preservation tools.
                </p>
            </div>

        </div>
    </div>

    <!-- Section 4: Contact & Institutional Engagement -->
    <div class="space-y-4 border-t border-gray-900 pt-10">
        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="text-emerald-400 font-mono">04.</span> Contact & Partnerships
        </h2>
        <p class="text-xs sm:text-sm text-gray-300 leading-relaxed max-w-3xl">
            For press inquiries, music archiving partnerships, copyright inquiries, or institutional collaboration, reach out to our editorial team directly at <a href="mailto:info@gusiilyrics.com" class="text-emerald-400 font-bold underline">info@gusiilyrics.com</a> or via our official communication channels.
        </p>
    </div>

</div>
@endsection
