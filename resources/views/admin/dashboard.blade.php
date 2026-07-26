@extends('layouts.admin')

@section('title', 'Staff Dashboard & Visitor Analytics - Gusii Lyrics')

@section('content')
<div class="space-y-8">

    <!-- Admin Nav Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Staff Dashboard & Visitor Analytics</h1>
            <p class="text-xs text-gray-400 mt-1">Real-time performance metrics, visitor tracking & content management.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.songs.create') }}" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md">
                + Add New Song Lyric
            </a>
            <a href="{{ route('admin.artists.create') }}" class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-white font-bold text-xs border border-gray-700">
                + Create Artist Profile
            </a>
        </div>
    </div>

    @if(Auth::user()->isAdmin() && isset($analytics))
        <!-- Real-Time Site Visitor Analytics Cards -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider">📈 Site Traffic & Visitor Performance Tracker</h3>
                <span class="text-[10px] font-mono text-gray-400">Live Server Logging</span>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pageviews Today -->
                <div class="glass-panel p-5 rounded-2xl border border-emerald-500/30">
                    <div class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Pageviews Today</div>
                    <div class="text-3xl font-black text-white mt-2">{{ number_format($analytics['today_pageviews']) }}</div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Lifetime: {{ number_format($analytics['total_pageviews']) }}</span>
                </div>

                <!-- Unique Visitors Today -->
                <div class="glass-panel p-5 rounded-2xl border border-indigo-500/30">
                    <div class="text-[11px] font-bold text-indigo-400 uppercase tracking-wider">Unique Visitors Today</div>
                    <div class="text-3xl font-black text-white mt-2">{{ number_format($analytics['today_unique_ips']) }}</div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Unique IPs: {{ number_format($analytics['total_unique_ips']) }}</span>
                </div>

                <!-- Content Library Stats -->
                <div class="glass-panel p-5 rounded-2xl border border-gray-800">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Published Lyrics</div>
                    <div class="text-3xl font-black text-white mt-2">{{ number_format($stats['total_songs']) }}</div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Indexed Artists: {{ number_format($stats['total_artists']) }}</span>
                </div>

                <!-- Pending Visitor Actions -->
                <div class="glass-panel p-5 rounded-2xl border border-amber-500/30">
                    <div class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Pending Action Requests</div>
                    <div class="text-3xl font-black text-white mt-2">{{ $stats['pending_requests'] + $stats['pending_corrections'] }}</div>
                    <span class="text-[10px] text-gray-400 mt-1 block">{{ $stats['pending_requests'] }} requests • {{ $stats['pending_corrections'] }} corrections</span>
                </div>
            </div>

            <!-- Device Breakdown Widget & Top Traffic Referrers -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-2">
                
                <!-- Device Breakdown (Mobile vs Desktop) -->
                <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">📱 Device Breakdown</h4>
                    
                    <div class="space-y-3">
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-300 font-semibold">Mobile Devices</span>
                                <span class="font-bold text-emerald-400 font-mono">{{ $analytics['mobile_pct'] }}%</span>
                            </div>
                            <div class="w-full h-2.5 rounded-full bg-gray-900 overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $analytics['mobile_pct'] }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-300 font-semibold">Desktop / Laptop</span>
                                <span class="font-bold text-indigo-400 font-mono">{{ $analytics['desktop_pct'] }}%</span>
                            </div>
                            <div class="w-full h-2.5 rounded-full bg-gray-900 overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $analytics['desktop_pct'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Traffic Referrers -->
                <div class="lg:col-span-2 glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">🌐 Top Traffic Referral Sources</h4>
                    <div class="space-y-2">
                        @forelse($analytics['top_referrers'] as $ref)
                            <div class="p-2.5 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                                <span class="text-gray-300 font-mono truncate max-w-xs">{{ parse_url($ref->referrer, PHP_URL_HOST) ?? $ref->referrer }}</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">{{ number_format($ref->total) }} Visits</span>
                            </div>
                        @empty
                            <div class="text-center py-4 text-xs text-gray-500">Direct traffic / Organic search index visits.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- Most Popular Lyrics & Recent Activity Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Most Viewed Lyrics -->
        <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white">🔥 Most Popular Lyrics</h3>
                <a href="{{ route('admin.songs.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">View All &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($mostViewedSongs as $song)
                    <div class="p-3 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <img src="{{ $song->cover_art_url }}" class="w-9 h-9 rounded-lg object-cover">
                            <div>
                                <strong class="text-white block">{{ $song->title }}</strong>
                                <span class="text-gray-400">By {{ $song->artist->name }}</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono font-bold text-[10px]">
                            👁️ {{ number_format($song->views_count) }} Views
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-gray-500">No songs published yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Visitor Requests -->
        <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white">📬 Recent Visitor Song Requests</h3>
                <a href="{{ route('admin.requests.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">View All &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentRequests as $req)
                    <div class="p-3 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                        <div>
                            <strong class="text-white block">{{ $req->song_title }}</strong>
                            <span class="text-gray-400">By {{ $req->artist_name }}</span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $req->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                            {{ $req->status }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-gray-500">No lyric requests yet.</div>
                @endforelse
        <!-- Music Promotions & Active Campaigns -->
        <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-4 col-span-1 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    🎵 Promoted Music Campaigns
                </h3>
                <a href="{{ route('admin.promotions.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">Manage All Promotions &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @forelse($recentPromotions ?? [] as $promo)
                    <div class="p-3.5 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                        <div class="min-w-0 pr-2">
                            <strong class="text-white block truncate">{{ $promo->song_title }}</strong>
                            <span class="text-emerald-400 block truncate">{{ $promo->artist_name }}</span>
                            <span class="text-[10px] text-gray-500 font-mono">{{ $promo->package_type }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            @if($promo->status === 'active')
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">🟢 Active</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold text-[10px]">⏳ {{ ucfirst($promo->status) }}</span>
                            @endif
                            <div class="text-[10px] font-mono text-gray-400 mt-1">👁️ {{ number_format($promo->campaign_views) }} views</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-gray-500 col-span-2">No music promotions submitted yet.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
