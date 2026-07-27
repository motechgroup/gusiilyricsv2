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
    </div>

    <!-- Section 1: Executive Overview & Mission -->
    <div class="space-y-6 border-t border-gray-900 pt-10">
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
    <div class="space-y-6 border-t border-gray-900 pt-10">
        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="text-emerald-400 font-mono">04.</span> Contact & Partnerships
        </h2>
        <p class="text-xs sm:text-sm text-gray-300 leading-relaxed max-w-3xl">
            For press inquiries, music archiving partnerships, copyright inquiries, or general feedback, click the button below to open our interactive contact form or send an email directly to our editorial desk.
        </p>

        <div class="pt-2 flex flex-wrap items-center gap-4">
            <button onclick="document.getElementById('contactUsModal').classList.remove('hidden')" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-amber-400 to-emerald-400 hover:from-emerald-400 hover:to-amber-300 text-slate-950 font-black text-xs uppercase tracking-wider inline-flex items-center gap-2 shadow-xl hover:scale-105 transition cursor-pointer select-none">
                <span>Open Contact Form ✉️</span>
            </button>
            <a href="mailto:info@gusiilyrics.com" class="px-5 py-3.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs border border-gray-800 transition">
                Email: info@gusiilyrics.com
            </a>
        </div>
    </div>

</div>

<!-- Interactive Contact Us Modal Form -->
<div id="contactUsModal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/40 shadow-2xl space-y-6 max-w-xl w-full my-8">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                    <span>✉️</span> Contact Gusii Lyrics Team
                </h2>
                <p class="text-xs text-emerald-400 font-semibold mt-0.5">Send us your message, feedback, or partnership request.</p>
            </div>
            <button onclick="document.getElementById('contactUsModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-xl font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Your Full Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. Ombati John" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-400">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@example.com" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Phone / WhatsApp (Optional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +254 700 000 000" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-400">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider text-amber-400 mb-1">Inquiry Subject *</label>
                    <input type="text" name="subject" required value="{{ old('subject') }}" placeholder="e.g. Partnership / General Inquiry" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-400">
                </div>
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Your Message *</label>
                <textarea name="message" rows="4" required placeholder="Type your detailed message here..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-400">{{ old('message') }}</textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('contactUsModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-gray-800 text-gray-300 font-bold">Cancel</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold">Send Message &rarr;</button>
            </div>
        </form>
    </div>
</div>
@endsection
