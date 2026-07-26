@extends('layouts.app')

@section('title', 'Promote Your Music - Reach 150K+ Ekegusii Music Fans')
@section('meta_description', 'Submit your Ekegusii song releases, singles, and music videos for promotion on Gusii Lyrics and affiliated media channels.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-14">

    <!-- Hero Header (Green & Yellow Gold Contrast Theme, No Badge) -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight">
            Promote Your Music to <span class="bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400 bg-clip-text text-transparent">Omogusii Worldwide</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
            Get your song lyrics indexed on the #1 Gusii music platform, featured on our home page charts, and distributed across our social & partner network.
        </p>
    </div>

    <!-- Live Social Reach & Audience Stats Grid (Hover Effects & Number Counter Effect) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <!-- Website Traffic -->
        <div onmouseenter="triggerCardCounter(this)" class="p-6 rounded-3xl bg-gray-950/80 hover:bg-gray-900 border border-emerald-500/30 hover:border-amber-400/60 text-center space-y-3 transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] shadow-xl hover:shadow-2xl hover:shadow-emerald-500/10 cursor-pointer group">
            <div class="w-13 h-13 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 group-hover:border-amber-400/50 group-hover:bg-amber-400/10 flex items-center justify-center mx-auto text-emerald-400 group-hover:text-amber-300 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-emerald-400 group-hover:text-amber-300 font-mono transition-colors counter-element" data-count="150000" data-suffix="+">
                150,000+
            </div>
            <p class="text-[11px] text-gray-400 group-hover:text-white font-bold uppercase tracking-wider transition">Monthly Web Traffic</p>
        </div>

        <!-- YouTube Subscribers -->
        <div onmouseenter="triggerCardCounter(this)" class="p-6 rounded-3xl bg-gray-950/80 hover:bg-gray-900 border border-rose-500/30 hover:border-amber-400/60 text-center space-y-3 transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] shadow-xl hover:shadow-2xl hover:shadow-rose-500/10 cursor-pointer group">
            <div class="w-13 h-13 rounded-2xl bg-rose-500/10 border border-rose-500/30 group-hover:border-amber-400/50 group-hover:bg-amber-400/10 flex items-center justify-center mx-auto text-rose-500 group-hover:text-amber-300 transition-colors">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-rose-400 group-hover:text-amber-300 font-mono transition-colors counter-element" data-count="25000" data-suffix="+">
                25,000+
            </div>
            <p class="text-[11px] text-gray-400 group-hover:text-white font-bold uppercase tracking-wider transition">YouTube Subscribers</p>
        </div>

        <!-- Instagram Followers -->
        <div onmouseenter="triggerCardCounter(this)" class="p-6 rounded-3xl bg-gray-950/80 hover:bg-gray-900 border border-pink-500/30 hover:border-amber-400/60 text-center space-y-3 transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] shadow-xl hover:shadow-2xl hover:shadow-pink-500/10 cursor-pointer group">
            <div class="w-13 h-13 rounded-2xl bg-pink-500/10 border border-pink-500/30 group-hover:border-amber-400/50 group-hover:bg-amber-400/10 flex items-center justify-center mx-auto text-pink-500 group-hover:text-amber-300 transition-colors">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-pink-400 group-hover:text-amber-300 font-mono transition-colors counter-element" data-count="18500" data-suffix="+">
                18,500+
            </div>
            <p class="text-[11px] text-gray-400 group-hover:text-white font-bold uppercase tracking-wider transition">Instagram Followers</p>
        </div>

        <!-- TikTok Community -->
        <div onmouseenter="triggerCardCounter(this)" class="p-6 rounded-3xl bg-gray-950/80 hover:bg-gray-900 border border-cyan-500/30 hover:border-amber-400/60 text-center space-y-3 transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] shadow-xl hover:shadow-2xl hover:shadow-cyan-500/10 cursor-pointer group">
            <div class="w-13 h-13 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 group-hover:border-amber-400/50 group-hover:bg-amber-400/10 flex items-center justify-center mx-auto text-cyan-400 group-hover:text-amber-300 transition-colors">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02.48-.04 1.47-.04 1.95v.02c-1.54-.42-3.23-.1-4.48.82-1.26.91-1.99 2.45-1.91 4.02.04 1.05.51 2.06 1.29 2.77.92.85 2.19 1.25 3.44 1.1 1.43-.11 2.74-.97 3.39-2.24.42-.82.61-1.77.59-2.71V.02z"/></svg>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-cyan-400 group-hover:text-amber-300 font-mono transition-colors counter-element" data-count="32000" data-suffix="+">
                32,000+
            </div>
            <p class="text-[11px] text-gray-400 group-hover:text-white font-bold uppercase tracking-wider transition">TikTok Community</p>
        </div>
    </div>

    <!-- Why Promote With Us Section (Un-enclosed & High Contrast Green/Yellow Accent) -->
    <div class="space-y-8 pt-8 border-t border-gray-800/80">
        <h2 class="text-2xl sm:text-3xl font-black text-white text-center tracking-tight">
            Why Promote Your Releases With <span class="text-amber-400">Gusii Lyrics</span>?
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-2">
            <div class="p-6 rounded-2xl bg-gray-950/60 border border-gray-800 hover:border-emerald-500/40 transition space-y-3 group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 group-hover:text-amber-400 group-hover:border-amber-400/40 flex items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-extrabold text-white group-hover:text-emerald-400 transition">#1 Google Search Ranking</h3>
                <p class="text-xs text-gray-300 leading-relaxed">
                    When fans search for your song name or lyrics on Google, our SEO structured data ensures your music appears right at the top with verified stream links.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-950/60 border border-gray-800 hover:border-emerald-500/40 transition space-y-3 group">
                <div class="w-12 h-12 rounded-2xl bg-amber-400/15 border border-amber-400/30 text-amber-400 group-hover:text-emerald-400 group-hover:border-emerald-400/40 flex items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-lg font-extrabold text-white group-hover:text-amber-400 transition">Home Page Charting</h3>
                <p class="text-xs text-gray-300 leading-relaxed">
                    Promoted tracks receive priority placements on our Top 10 Daily Charts, Featured Hero Banners, and Recommended Songs directory.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-950/60 border border-gray-800 hover:border-emerald-500/40 transition space-y-3 group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 group-hover:text-amber-400 group-hover:border-amber-400/40 flex items-center justify-center transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-lg font-extrabold text-white group-hover:text-emerald-400 transition">Affiliated Media Partners</h3>
                <p class="text-xs text-gray-300 leading-relaxed">
                    We partner with regional radio stations, music blogs, YouTube channels, and cultural curators across Kisii, Nyamira, Nairobi, and the diaspora.
                </p>
            </div>
        </div>

        <div class="text-center pt-8">
            <button onclick="document.getElementById('promoteFormModal').classList.remove('hidden')" class="px-9 py-4 rounded-xl bg-gradient-to-r from-emerald-500 via-amber-400 to-emerald-400 hover:from-emerald-400 hover:to-amber-300 text-slate-950 font-black text-sm sm:text-base shadow-xl shadow-amber-400/20 transition transform hover:-translate-y-1 hover:scale-105 inline-flex items-center gap-2">
                <span>Submit Your Song for Promotion 🚀</span>
            </button>
        </div>
    </div>

</div>

<!-- Music Submission Modal (High Contrast Green/Yellow Styling) -->
<div id="promoteFormModal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-amber-400/40 shadow-2xl space-y-6 max-w-2xl w-full my-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-white">Submit Music for Promotion</h2>
                <p class="text-xs text-amber-400 font-semibold mt-0.5">Fill out the form below to submit your track for editorial review.</p>
            </div>
            <button onclick="document.getElementById('promoteFormModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-xl font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('promote-music.store') }}" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Artist / Band Name *</label>
                    <input type="text" name="artist_name" required value="{{ old('artist_name') }}" placeholder="e.g. Fenny Kerubo" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Contact Person Name</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="e.g. Manager / Artist Name" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="artist@gusiilyrics.com" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Phone Number / WhatsApp *</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="e.g. +254 712 345 678" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Song Title *</label>
                    <input type="text" name="song_title" required value="{{ old('song_title') }}" placeholder="e.g. Enyangi Ekero Enyene" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Song Link (YouTube, Spotify, Audiomack) *</label>
                    <input type="url" name="song_url" required value="{{ old('song_url') }}" placeholder="https://youtube.com/watch?v=..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                </div>
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-emerald-400 mb-1">Select Promotion Package *</label>
                <select name="package_type" required class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">
                    <option value="Standard Lyric Indexing & Streaming Links">Standard Listing - Lyric Transcription & Streaming Links (Free)</option>
                    <option value="Home Page Chart Priority & Featured Banner">Featured Listing - Home Page Banner & Top Chart Push</option>
                    <option value="Social Media Blast (YouTube, Instagram, TikTok)">Social Media Blast - Instagram, YouTube & TikTok Feature</option>
                    <option value="Full PR & Media Partner Distribution">Full PR Campaign - All Platforms + Partner Network</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Song Lyrics (Optional)</label>
                <textarea name="lyrics_text" rows="3" placeholder="Paste Ekegusii song lyrics if available..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">{{ old('lyrics_text') }}</textarea>
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider text-gray-300 mb-1">Additional Notes / Special Instructions</label>
                <textarea name="message" rows="2" placeholder="Tell us more about your song release date, story, or video details..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400">{{ old('message') }}</textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('promoteFormModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-gray-800 text-gray-300 font-bold">Cancel</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold">Submit Song for Promotion &rarr;</button>
            </div>
        </form>
    </div>
</div>

<script>
function triggerCardCounter(cardElement) {
    const counterEl = cardElement.querySelector('.counter-element');
    if (!counterEl) return;

    const target = parseInt(counterEl.getAttribute('data-count'), 10);
    const suffix = counterEl.getAttribute('data-suffix') || '';
    if (!target || counterEl.dataset.animating === "true") return;

    counterEl.dataset.animating = "true";
    let start = 0;
    const duration = 1000;
    const startTime = performance.now();

    function step(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out cubic
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const currentVal = Math.floor(easeOut * target);

        counterEl.textContent = currentVal.toLocaleString() + suffix;

        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            counterEl.dataset.animating = "false";
        }
    }

    requestAnimationFrame(step);
}
</script>
@endsection
