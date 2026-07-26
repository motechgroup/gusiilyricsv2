@extends('layouts.app')

@section('title', 'Promote Your Music - Reach 150K+ Ekegusii Music Fans')
@section('meta_description', 'Submit your Ekegusii song releases, singles, and music videos for promotion on Gusii Lyrics and affiliated media channels.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Hero Header -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
            🎵 Artist & Record Label Music Promotion
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
            Promote Your Music to <span class="text-gradient-emerald">Abagusii Worldwide</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
            Get your Ekegusii song lyrics indexed on the #1 Gusii music platform, featured on our home page charts, and distributed across our social & partner network.
        </p>
    </div>

    <!-- Live Social Reach & Audience Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="glass-panel p-6 rounded-3xl border border-gray-800 text-center space-y-2">
            <div class="text-3xl">🌐</div>
            <div class="text-2xl sm:text-3xl font-extrabold text-white font-mono">{{ $stats['monthly_visitors'] }}</div>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Monthly Website Traffic</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-rose-500/30 text-center space-y-2">
            <div class="text-3xl">📺</div>
            <div class="text-2xl sm:text-3xl font-extrabold text-rose-400 font-mono">{{ $stats['youtube_subscribers'] }}</div>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">YouTube Subscribers</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-pink-500/30 text-center space-y-2">
            <div class="text-3xl">📸</div>
            <div class="text-2xl sm:text-3xl font-extrabold text-pink-400 font-mono">{{ $stats['instagram_followers'] }}</div>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Instagram Followers</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-cyan-500/30 text-center space-y-2">
            <div class="text-3xl">🎵</div>
            <div class="text-2xl sm:text-3xl font-extrabold text-cyan-400 font-mono">{{ $stats['tiktok_followers'] }}</div>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">TikTok Community</p>
        </div>
    </div>

    <!-- Why Promote With Us Section -->
    <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-gray-800 space-y-6">
        <h2 class="text-2xl font-extrabold text-white text-center">Why Promote Your Releases With Gusii Lyrics?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    🔍
                </div>
                <h3 class="text-base font-bold text-white">#1 Google Search Ranking</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    When fans search for your song name or lyrics on Google, our SEO structured data ensures your music appears right at the top with verified stream links.
                </p>
            </div>

            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    📊
                </div>
                <h3 class="text-base font-bold text-white">Home Page Charting</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Promoted tracks receive priority placements on our Top 10 Daily Charts, Featured Hero Banners, and Recommended Songs directory.
                </p>
            </div>

            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    🤝
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
