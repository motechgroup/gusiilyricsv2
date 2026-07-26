@extends('layouts.app')

@section('title', 'Promote Your Music - Reach 150K+ Ekegusii Music Fans')
@section('meta_description', 'Submit your Ekegusii song releases, singles, and music videos for promotion on Gusii Lyrics and affiliated media channels.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Hero Header -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
            Artist & Record Label Music Promotion
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
            Promote Your Music to <span class="text-gradient-emerald">Abagusii Worldwide</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
            Get your Ekegusii song lyrics indexed on the #1 Gusii music platform, featured on our home page charts, and distributed across our social & partner network.
        </p>
    </div>

    <!-- Live Social Reach & Audience Stats Grid (Official Platform Icons) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <!-- Website Traffic -->
        <div class="glass-panel p-6 rounded-3xl border border-emerald-500/30 text-center space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center mx-auto text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-white font-mono">{{ $stats['monthly_visitors'] }}</div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Monthly Web Traffic</p>
        </div>

        <!-- YouTube Subscribers -->
        <div class="glass-panel p-6 rounded-3xl border border-rose-500/30 text-center space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-center justify-center mx-auto text-rose-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-rose-400 font-mono">{{ $stats['youtube_subscribers'] }}</div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">YouTube Subscribers</p>
        </div>

        <!-- Instagram Followers -->
        <div class="glass-panel p-6 rounded-3xl border border-pink-500/30 text-center space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/30 flex items-center justify-center mx-auto text-pink-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-pink-400 font-mono">{{ $stats['instagram_followers'] }}</div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Instagram Followers</p>
        </div>

        <!-- TikTok Community -->
        <div class="glass-panel p-6 rounded-3xl border border-cyan-500/30 text-center space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center mx-auto text-cyan-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02.48-.04 1.47-.04 1.95v.02c-1.54-.42-3.23-.1-4.48.82-1.26.91-1.99 2.45-1.91 4.02.04 1.05.51 2.06 1.29 2.77.92.85 2.19 1.25 3.44 1.1 1.43-.11 2.74-.97 3.39-2.24.42-.82.61-1.77.59-2.71V.02z"/></svg>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-cyan-400 font-mono">{{ $stats['tiktok_followers'] }}</div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">TikTok Community</p>
        </div>
    </div>

    <!-- Why Promote With Us Section -->
    <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-gray-800 space-y-6">
        <h2 class="text-2xl font-extrabold text-white text-center">Why Promote Your Releases With Gusii Lyrics?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-white">#1 Google Search Ranking</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    When fans search for your song name or lyrics on Google, our SEO structured data ensures your music appears right at the top with verified stream links.
                </p>
            </div>

            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-white">Home Page Charting</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Promoted tracks receive priority placements on our Top 10 Daily Charts, Featured Hero Banners, and Recommended Songs directory.
                </p>
            </div>

            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-white">Affiliated Media Partners</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    We partner with regional radio stations, music blogs, YouTube channels, and cultural curators across Kisii, Nyamira, Nairobi, and the diaspora.
                </p>
            </div>
        </div>
    </div>

    <!-- Music Submission Form -->
    <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-emerald-500/30 shadow-2xl space-y-6 max-w-3xl mx-auto">
        <div class="text-center space-y-2 border-b border-gray-800 pb-6">
            <h2 class="text-2xl font-extrabold text-white">Submit Your Music for Promotion</h2>
            <p class="text-xs text-gray-400">Fill out the form below to submit your track for editorial review and promotion.</p>
        </div>

        <form method="POST" action="{{ route('promote-music.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist / Band Name *</label>
                    <input type="text" name="artist_name" required value="{{ old('artist_name') }}" placeholder="e.g. Fenny Kerubo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Contact Person Name</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="e.g. Manager / Artist Name" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="artist@gusiilyrics.com" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Phone Number / WhatsApp *</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="e.g. +254 712 345 678" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Title *</label>
                    <input type="text" name="song_title" required value="{{ old('song_title') }}" placeholder="e.g. Enyangi Ekero Enyene" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Link (YouTube, Spotify, Audiomack) *</label>
                    <input type="url" name="song_url" required value="{{ old('song_url') }}" placeholder="https://youtube.com/watch?v=..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Select Promotion Package *</label>
                <select name="package_type" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    <option value="Standard Lyric Indexing & Streaming Links">Standard Listing - Lyric Transcription & Streaming Links (Free)</option>
                    <option value="Home Page Chart Priority & Featured Banner">Featured Listing - Home Page Banner & Top Chart Push</option>
                    <option value="Social Media Blast (YouTube, Instagram, TikTok)">Social Media Blast - Instagram, YouTube & TikTok Feature</option>
                    <option value="Full PR & Media Partner Distribution">Full PR Campaign - All Platforms + Partner Network</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Lyrics (Optional)</label>
                <textarea name="lyrics_text" rows="4" placeholder="Paste Ekegusii song lyrics if available..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">{{ old('lyrics_text') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Additional Notes / Special Instructions</label>
                <textarea name="message" rows="3" placeholder="Tell us more about your song release date, story, or video details..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm shadow-lg transition">
                Submit Song for Promotion &rarr;
            </button>
        </form>
    </div>

</div>
@endsection
