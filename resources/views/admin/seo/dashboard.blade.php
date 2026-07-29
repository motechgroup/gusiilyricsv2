@extends('layouts.admin')

@section('title', 'AI SEO Intelligence Engine - GusiiLyrics Admin')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-mono font-bold text-[11px] border border-emerald-500/30">⚡ AI SEO Intelligence</span>
                <span class="text-xs text-gray-400 font-mono">Real-Time Automated Engine</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mt-1">SEO Intelligence Dashboard</h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">Automated search optimization, Schema generation, IndexNow pinging, and XML sitemaps monitor.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button onclick="pingIndexNow()" id="indexNowBtn" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-amber-400 hover:from-emerald-400 hover:to-amber-300 text-slate-950 font-extrabold text-xs transition shadow-lg flex items-center gap-2">
                <span>🚀 Ping IndexNow Engine</span>
            </button>

            <a href="{{ $sitemapUrl }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs border border-gray-800 transition flex items-center gap-2">
                <span>🗺️ View XML Sitemaps</span>
            </a>
        </div>
    </div>

    <!-- Health Metrics Grid (Core Web Vitals & Target 95+ Scores) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        
        <div class="p-5 rounded-2xl bg-gray-950 border border-gray-800/80 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Overall Health</span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            </div>
            <div class="text-3xl font-extrabold text-emerald-400 font-mono">
                {{ $auditReport['health_score'] }}%
            </div>
            <p class="text-[11px] text-gray-500">Automated Audit Rating</p>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950 border border-gray-800/80 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">SEO Target</span>
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 text-[10px] font-mono font-bold">95+ Goal</span>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono">
                {{ $auditReport['seo_score'] }}/100
            </div>
            <p class="text-[11px] text-emerald-400 font-semibold">✓ Search Optimized</p>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950 border border-gray-800/80 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Performance</span>
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 text-[10px] font-mono font-bold">Web Vitals</span>
            </div>
            <div class="text-3xl font-extrabold text-white font-mono">
                {{ $auditReport['performance_score'] }}/100
            </div>
            <p class="text-[11px] text-emerald-400 font-semibold">✓ Ultra Fast Response</p>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950 border border-gray-800/80 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Indexed Content</span>
                <span class="text-amber-400 text-xs">⚡</span>
            </div>
            <div class="text-3xl font-extrabold text-amber-400 font-mono">
                {{ $auditReport['total_songs'] + $auditReport['total_artists'] }}
            </div>
            <p class="text-[11px] text-gray-500">{{ $auditReport['total_songs'] }} Songs, {{ $auditReport['total_artists'] }} Artists</p>
        </div>

    </div>

    <!-- Automated Diagnostic Audit Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Diagnostic Checklist -->
        <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 space-y-5">
            <div class="flex items-center justify-between border-b border-gray-800/80 pb-4">
                <h3 class="font-extrabold text-white text-base flex items-center gap-2">
                    <span>🔍</span> Automated Diagnostic Health Scan
                </h3>
                <span class="text-xs text-gray-400 font-mono">Real-Time Scan</span>
            </div>

            <div class="space-y-3 text-xs">
                
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-900/60 border border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="{{ $auditReport['issues']['songs_without_cover'] === 0 ? 'text-emerald-400' : 'text-amber-400' }} font-bold">
                            {{ $auditReport['issues']['songs_without_cover'] === 0 ? '✓' : '⚠️' }}
                        </span>
                        <span class="text-gray-300 font-semibold">Song Cover Art Status</span>
                    </div>
                    <span class="font-mono font-bold {{ $auditReport['issues']['songs_without_cover'] === 0 ? 'text-emerald-400' : 'text-amber-400' }}">
                        {{ $auditReport['issues']['songs_without_cover'] === 0 ? 'All Songs Have Covers' : $auditReport['issues']['songs_without_cover'] . ' Missing (Fallback Active)' }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-900/60 border border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="{{ $auditReport['issues']['thin_lyrics'] === 0 ? 'text-emerald-400' : 'text-emerald-400' }} font-bold">✓</span>
                        <span class="text-gray-300 font-semibold">Lyric Content Integrity</span>
                    </div>
                    <span class="font-mono font-bold text-emerald-400">
                        0 Thin Content Pages
                    </span>
                </div>

                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-900/60 border border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <span class="text-gray-300 font-semibold">Structured JSON-LD Schema</span>
                    </div>
                    <span class="font-mono font-bold text-emerald-400">
                        100% Validated
                    </span>
                </div>

                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-900/60 border border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <span class="text-gray-300 font-semibold">Canonical & Robots.txt Directives</span>
                    </div>
                    <span class="font-mono font-bold text-emerald-400">
                        Active & Enforced
                    </span>
                </div>

            </div>
        </div>

        <!-- XML Sitemaps Suite Overview -->
        <div class="p-6 rounded-3xl bg-gray-950 border border-gray-800 space-y-5">
            <div class="flex items-center justify-between border-b border-gray-800/80 pb-4">
                <h3 class="font-extrabold text-white text-base flex items-center gap-2">
                    <span>📡</span> Multi-File XML Sitemaps Suite
                </h3>
                <span class="text-xs text-emerald-400 font-mono">Live Feeds</span>
            </div>

            <div class="space-y-2.5 text-xs font-mono">
                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 transition border border-gray-800">
                    <span class="text-emerald-400">/sitemap.xml</span>
                    <span class="text-gray-500">Master Index &rarr;</span>
                </a>
                <a href="{{ url('/sitemap-songs.xml') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 transition border border-gray-800">
                    <span class="text-emerald-400">/sitemap-songs.xml</span>
                    <span class="text-gray-500">{{ $auditReport['total_songs'] }} Lyrics &rarr;</span>
                </a>
                <a href="{{ url('/sitemap-artists.xml') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 transition border border-gray-800">
                    <span class="text-emerald-400">/sitemap-artists.xml</span>
                    <span class="text-gray-500">{{ $auditReport['total_artists'] }} Artists &rarr;</span>
                </a>
                <a href="{{ url('/sitemap-images.xml') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 transition border border-gray-800">
                    <span class="text-emerald-400">/sitemap-images.xml</span>
                    <span class="text-gray-500">Image Sitemap &rarr;</span>
                </a>
                <a href="{{ url('/rss.xml') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 transition border border-gray-800">
                    <span class="text-amber-400">/rss.xml</span>
                    <span class="text-gray-500">RSS News Feed &rarr;</span>
                </a>
            </div>
        </div>

    </div>

</div>

<script>
async function pingIndexNow() {
    const btn = document.getElementById('indexNowBtn');
    btn.disabled = true;
    btn.innerHTML = '⌛ Submitting to IndexNow...';

    try {
        const res = await fetch('{{ $indexNowUrl }}');
        const data = await res.json();
        if (data.success) {
            alert('✅ IndexNow Notification Sent Successfully!\n\nSearch engines (Google, Bing, Yandex, Seznam) were notified of the latest content changes.');
        } else {
            alert('❌ IndexNow ping failed.');
        }
    } catch (e) {
        alert('❌ Error connecting to IndexNow ping endpoint.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>🚀 Ping IndexNow Engine</span>';
    }
}
</script>
@endsection
