@extends('layouts.admin')

@section('title', 'Site Analytics & Traffic Tracker - Admin')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">📈 Site Analytics & Performance Tracker</h1>
            <p class="text-xs text-gray-400 mt-1">Deep insights into site traffic, pageviews, visitor devices, referrers, and song popularity.</p>
        </div>
    </div>

    <!-- Analytics Key Metrics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pageviews Today -->
        <div class="glass-panel p-5 rounded-2xl border border-emerald-500/30">
            <div class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Pageviews Today</div>
            <div class="text-3xl font-black text-white mt-2">{{ number_format($metrics['today_pageviews']) }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Lifetime Pageviews: {{ number_format($metrics['total_pageviews']) }}</span>
        </div>

        <!-- Unique Visitors Today -->
        <div class="glass-panel p-5 rounded-2xl border border-indigo-500/30">
            <div class="text-[11px] font-bold text-indigo-400 uppercase tracking-wider">Unique Visitors Today</div>
            <div class="text-3xl font-black text-white mt-2">{{ number_format($metrics['today_unique_ips']) }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Unique IPs: {{ number_format($metrics['total_unique_ips']) }}</span>
        </div>

        <!-- Mobile Traffic % -->
        <div class="glass-panel p-5 rounded-2xl border border-amber-500/30">
            <div class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Mobile Traffic Ratio</div>
            <div class="text-3xl font-black text-white mt-2">{{ $metrics['mobile_pct'] }}%</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Desktop: {{ $metrics['desktop_pct'] }}% • Tablet: {{ $metrics['tablet_pct'] }}%</span>
        </div>

        <!-- Server Tracker Health -->
        <div class="glass-panel p-5 rounded-2xl border border-rose-500/30">
            <div class="text-[11px] font-bold text-rose-400 uppercase tracking-wider">Tracker Logging</div>
            <div class="text-3xl font-black text-white mt-2">Active</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Real-time HTTP requests</span>
        </div>
    </div>

    <!-- Device & Referrer Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Device Breakdown Card -->
        <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-6">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">📱 Device Type Breakdown</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="text-gray-300 font-semibold">Mobile Devices (Phones)</span>
                        <span class="font-bold text-emerald-400 font-mono">{{ $metrics['mobile_pct'] }}%</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-gray-950 overflow-hidden border border-gray-800">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $metrics['mobile_pct'] }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="text-gray-300 font-semibold">Desktop / Laptop Computers</span>
                        <span class="font-bold text-indigo-400 font-mono">{{ $metrics['desktop_pct'] }}%</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-gray-950 overflow-hidden border border-gray-800">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $metrics['desktop_pct'] }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="text-gray-300 font-semibold">Tablet Devices</span>
                        <span class="font-bold text-amber-400 font-mono">{{ $metrics['tablet_pct'] }}%</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-gray-950 overflow-hidden border border-gray-800">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $metrics['tablet_pct'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Referral Sources -->
        <div class="lg:col-span-2 glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">🌐 Top Traffic Referral Domains</h3>
            
            <div class="space-y-2">
                @forelse($topReferrers as $ref)
                    <div class="p-3 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                        <span class="text-gray-300 font-mono truncate max-w-sm">{{ parse_url($ref->referrer, PHP_URL_HOST) ?? $ref->referrer }}</span>
                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300 font-bold text-xs">{{ number_format($ref->total) }} Visits</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-500">Direct traffic / Organic search index visits.</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Top 10 Most Popular Songs -->
    <div class="glass-panel p-6 rounded-3xl border border-gray-800 space-y-4">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider">🔥 Top 10 Most Viewed Songs</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($popularSongs as $song)
                <div class="p-3 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <img src="{{ $song->cover_art_url }}" class="w-10 h-10 rounded-xl object-cover">
                        <div>
                            <a href="{{ route('songs.show', $song->slug) }}" target="_blank" class="font-bold text-white hover:text-emerald-400 block">
                                {{ $song->title }}
                            </a>
                            <span class="text-gray-400 text-[11px]">By {{ $song->artist->name }}</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300 font-mono font-bold text-xs">
                        👁️ {{ number_format($song->views_count) }} Views
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Live Visitor Traffic Logs Table -->
    <div class="space-y-4">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider">📑 Live Visitor Traffic Log Feed</h3>
        
        <div class="glass-panel rounded-3xl overflow-hidden border border-gray-800">
            <table class="w-full text-left text-xs text-gray-300">
                <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                    <tr>
                        <th class="p-4">Timestamp</th>
                        <th class="p-4">IP Address</th>
                        <th class="p-4">Visited Page URL</th>
                        <th class="p-4">Device</th>
                        <th class="p-4">Referrer Source</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($recentLogs as $log)
                        <tr class="hover:bg-gray-800/40">
                            <td class="p-4 font-mono text-gray-400">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="p-4 font-mono text-emerald-400">{{ $log->ip_address }}</td>
                            <td class="p-4 font-mono text-white truncate max-w-xs">{{ parse_url($log->url, PHP_URL_PATH) }}</td>
                            <td class="p-4 uppercase text-[10px] font-bold font-mono">
                                <span class="px-2 py-0.5 rounded {{ $log->device_type === 'mobile' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-indigo-500/20 text-indigo-300' }}">
                                    {{ $log->device_type }}
                                </span>
                            </td>
                            <td class="p-4 font-mono text-gray-500 truncate max-w-xs">{{ $log->referrer ?? 'Direct' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $recentLogs->links() }}
        </div>
    </div>

</div>
@endsection
