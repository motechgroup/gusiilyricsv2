@extends('layouts.admin')

@section('title', 'Music Promotions & Campaign Analytics - Admin')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Music Promotions & Campaign Analytics</h1>
            <p class="text-xs text-gray-400 mt-1">Manage artist song promotion submissions, active campaign reach, and performance tracking.</p>
        </div>

        <button onclick="document.getElementById('createPromotionModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition flex items-center gap-2 self-start sm:self-auto">
            <span>+</span> Create New Campaign
        </button>
    </div>

    <!-- Campaign Analytics Overview Grid (Un-enclosed) -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 text-center space-y-1">
            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Campaigns</span>
            <div class="text-2xl font-extrabold text-white font-mono">{{ number_format($stats['total_campaigns']) }}</div>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-emerald-500/30 text-center space-y-1">
            <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Active Promoted Songs</span>
            <div class="text-2xl font-extrabold text-emerald-400 font-mono">{{ number_format($stats['active_campaigns']) }}</div>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-rose-500/30 text-center space-y-1">
            <span class="text-[10px] text-rose-400 font-bold uppercase tracking-wider">Total Promo Views</span>
            <div class="text-2xl font-extrabold text-white font-mono">{{ number_format($stats['total_views']) }}</div>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-cyan-500/30 text-center space-y-1">
            <span class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider">Stream Link Clicks</span>
            <div class="text-2xl font-extrabold text-white font-mono">{{ number_format($stats['total_clicks']) }}</div>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-amber-500/30 text-center space-y-1 col-span-2 lg:col-span-1">
            <span class="text-[10px] text-amber-400 font-bold uppercase tracking-wider">Campaign Revenue</span>
            <div class="text-2xl font-extrabold text-amber-300 font-mono">KES {{ number_format($stats['total_budget']) }}</div>
        </div>
    </div>

    <!-- Edit Public Social Reach Cards Form -->
    <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-800 pb-3">
            <div>
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    📊 Manage Public Social Reach & Audience Cards (/promote-music)
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">Customize the audience numbers and channel titles shown to artists on the public promotion landing page.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="section_type" value="social_stats">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <!-- Web Traffic -->
                <div class="p-4 rounded-2xl bg-gray-900/60 border border-emerald-500/30 space-y-2">
                    <label class="block font-bold text-emerald-400 uppercase">Card 1: Web Traffic</label>
                    <input type="text" name="social_stat_web_traffic" value="{{ \App\Models\Setting::get('social_stat_web_traffic', '150,000+') }}" placeholder="e.g. 150,000+" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_web_label" value="{{ \App\Models\Setting::get('social_stat_web_label', 'Monthly Web Traffic') }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- YouTube -->
                <div class="p-4 rounded-2xl bg-gray-900/60 border border-rose-500/30 space-y-2">
                    <label class="block font-bold text-rose-400 uppercase">Card 2: YouTube</label>
                    <input type="text" name="social_stat_youtube_subscribers" value="{{ \App\Models\Setting::get('social_stat_youtube_subscribers', '25,000+') }}" placeholder="e.g. 25,000+" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_youtube_label" value="{{ \App\Models\Setting::get('social_stat_youtube_label', 'YouTube Subscribers') }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- Instagram -->
                <div class="p-4 rounded-2xl bg-gray-900/60 border border-pink-500/30 space-y-2">
                    <label class="block font-bold text-pink-400 uppercase">Card 3: Instagram</label>
                    <input type="text" name="social_stat_instagram_followers" value="{{ \App\Models\Setting::get('social_stat_instagram_followers', '18,500+') }}" placeholder="e.g. 18,500+" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_instagram_label" value="{{ \App\Models\Setting::get('social_stat_instagram_label', 'Instagram Followers') }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- TikTok -->
                <div class="p-4 rounded-2xl bg-gray-900/60 border border-cyan-500/30 space-y-2">
                    <label class="block font-bold text-cyan-400 uppercase">Card 4: TikTok</label>
                    <input type="text" name="social_stat_tiktok_community" value="{{ \App\Models\Setting::get('social_stat_tiktok_community', '32,000+') }}" placeholder="e.g. 32,000+" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_tiktok_label" value="{{ \App\Models\Setting::get('social_stat_tiktok_label', 'TikTok Community') }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-gray-300">
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-lg transition">
                    💾 Save Social Reach Cards
                </button>
            </div>
        </form>
    </div>
    <div class="space-y-4">
        <div class="pb-2 border-b border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Promoted Music Campaigns</h3>

            <!-- Filter Status -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.promotions.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ !request('status') ? 'bg-emerald-500 text-slate-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' }}">All</a>
                <a href="{{ route('admin.promotions.index', ['status' => 'active']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'active' ? 'bg-emerald-500 text-slate-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' }}">Active</a>
                <a href="{{ route('admin.promotions.index', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'pending' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' }}">Pending</a>
                <a href="{{ route('admin.promotions.index', ['status' => 'completed']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'completed' ? 'bg-gray-700 text-white' : 'bg-gray-900 text-gray-400 hover:text-white' }}">Completed</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-950/80 text-gray-400 font-mono uppercase tracking-wider text-[10px] border-b border-gray-800">
                    <tr>
                        <th class="py-3.5 px-4">Artist & Song</th>
                        <th class="py-3.5 px-4">Package</th>
                        <th class="py-3.5 px-4">Contact Details</th>
                        <th class="py-3.5 px-4">Campaign Reach Analytics</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60 text-gray-300">
                    @forelse($promotions as $promo)
                        <tr class="hover:bg-gray-900/40 transition">
                            <td class="py-4 px-4">
                                <div class="font-bold text-white text-sm">{{ $promo->song_title }}</div>
                                <div class="text-emerald-400 font-semibold mt-0.5">{{ $promo->artist_name }}</div>
                                @if($promo->song)
                                    <span class="inline-block mt-1 text-[10px] font-mono text-gray-400">Linked to Song ID: #{{ $promo->song->id }}</span>
                                @endif
                            </td>

                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-gray-900 border border-gray-800 text-[11px] font-semibold text-gray-300">
                                    {{ $promo->package_type }}
                                </span>
                                @if($promo->budget_amount > 0)
                                    <div class="text-[10px] text-amber-400 font-mono mt-1 font-bold">KES {{ number_format($promo->budget_amount) }}</div>
                                @endif
                            </td>

                            <td class="py-4 px-4 font-mono text-[11px]">
                                <div>{{ $promo->email }}</div>
                                <div class="text-gray-400">{{ $promo->phone }}</div>
                                @if($promo->song_url)
                                    <a href="{{ $promo->song_url }}" target="_blank" class="text-emerald-400 underline text-[10px] truncate block max-w-[150px]">Link &rarr;</a>
                                @endif
                            </td>

                            <td class="py-4 px-4 font-mono">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="text-[10px] text-gray-500 block">Views:</span>
                                        <span class="font-bold text-white text-xs">{{ number_format($promo->campaign_views) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-gray-500 block">Clicks:</span>
                                        <span class="font-bold text-cyan-400 text-xs">{{ number_format($promo->campaign_clicks) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-4">
                                @if($promo->status === 'active')
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[11px] font-bold">🟢 Active</span>
                                @elseif($promo->status === 'completed')
                                    <span class="px-2.5 py-1 rounded-full bg-gray-800 text-gray-300 text-[11px] font-bold">🏁 Completed</span>
                                @elseif($promo->status === 'paused')
                                    <span class="px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[11px] font-bold">⏸️ Paused</span>
                                @elseif($promo->status === 'rejected')
                                    <span class="px-2.5 py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-400 text-[11px] font-bold">❌ Rejected</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[11px] font-bold">⏳ Pending Review</span>
                                @endif
                            </td>

                            <td class="py-4 px-4 text-right space-y-1">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if(!empty($promo->email))
                                        <button type="button" onclick="openPromoEmailModal('{{ addslashes($promo->email) }}', '{{ addslashes($promo->artist_name) }}', 'Update regarding your music promotion: {{ addslashes($promo->song_title) }}')" class="px-2 py-1 rounded bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 text-[10px] font-bold">
                                            ✉️ Email
                                        </button>
                                    @endif

                                    <form method="POST" action="{{ route('admin.promotions.status', $promo->id) }}" class="inline-flex items-center gap-1">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="px-2 py-1 bg-gray-950 border border-gray-800 rounded-lg text-[11px] text-gray-300">
                                            <option value="pending" {{ $promo->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="active" {{ $promo->status === 'active' ? 'selected' : '' }}>Mark Active</option>
                                            <option value="paused" {{ $promo->status === 'paused' ? 'selected' : '' }}>Pause</option>
                                            <option value="completed" {{ $promo->status === 'completed' ? 'selected' : '' }}>Complete</option>
                                            <option value="rejected" {{ $promo->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                    </form>

                                    <form method="POST" action="{{ route('admin.promotions.destroy', $promo->id) }}" onsubmit="return confirm('Delete this promotion campaign?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-gray-500 hover:text-rose-400 text-xs">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 text-xs">No music promotion campaigns found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($promotions->hasPages())
            <div class="pt-4 border-t border-gray-800/80">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Create Promotion Modal -->
<div id="createPromotionModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/30 max-w-xl w-full space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <h3 class="text-base font-extrabold text-white">Create Music Promotion Campaign</h3>
            <button onclick="document.getElementById('createPromotionModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.promotions.store') }}" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-300 mb-1">Artist Name *</label>
                    <input type="text" name="artist_name" required placeholder="e.g. Douglas Otiso" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1">Song Title *</label>
                    <input type="text" name="song_title" required placeholder="e.g. Tara" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-300 mb-1">Email *</label>
                    <input type="email" name="email" required placeholder="artist@gusiilyrics.com" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1">Phone Number</label>
                    <input type="text" name="phone" placeholder="+254 712 345 678" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-300 mb-1">Link to Platform Indexed Song (Optional)</label>
                    <select name="song_id" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                        <option value="">-- Select Indexed Song --</option>
                        @foreach($songs as $song)
                            <option value="{{ $song->id }}">{{ $song->title }} ({{ $song->artist->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-300 mb-1">Song Streaming Link (YouTube/Spotify)</label>
                    <input type="url" name="song_url" placeholder="https://youtube.com/..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-emerald-400 mb-1">Promotion Package *</label>
                    <select name="package_type" required class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                        <option value="Featured Listing - Home Page Banner & Top Chart Push">Featured Listing - Home Page Banner & Chart Push</option>
                        <option value="Social Media Blast (YouTube, Instagram, TikTok)">Social Media Blast - Instagram & TikTok Feature</option>
                        <option value="Full PR Campaign - All Platforms">Full PR Campaign - All Platforms + Partner Network</option>
                        <option value="Standard Lyric Indexing">Standard Lyric Indexing</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-emerald-400 mb-1">Initial Campaign Status *</label>
                    <select name="status" required class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                        <option value="active">🟢 Active Campaign</option>
                        <option value="pending">⏳ Pending Review</option>
                        <option value="paused">⏸️ Paused</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-amber-400 mb-1">Campaign Budget / Fee (KES)</label>
                <input type="number" name="budget_amount" placeholder="e.g. 5000" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Notes / Campaign Details</label>
                <textarea name="notes" rows="2" placeholder="Internal notes, campaign goal, or target audience..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('createPromotionModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold">Cancel</button>
                <button type="submit" class="px-6 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold">Create Campaign &rarr;</button>
            </div>
        </form>
    </div>
</div>

<!-- Direct Email Composer Modal -->
<div id="promoEmailModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full relative shadow-2xl space-y-4">
        <button onclick="document.getElementById('promoEmailModal').classList.add('hidden')" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white text-xl font-bold">
            &times;
        </button>

        <div>
            <h3 class="text-xl font-extrabold text-white">Send Email to Artist / Promoter</h3>
            <p class="text-xs text-gray-400 mt-1">Dispatches a branded HTML email directly to the release contact.</p>
        </div>

        <form method="POST" action="{{ route('admin.send-custom-email') }}" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="recipient_name" id="promoRecipientName" value="">

            <div>
                <label class="block font-bold text-gray-300 mb-1">Recipient Email *</label>
                <input type="email" name="recipient_email" id="promoRecipientEmail" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Email Subject *</label>
                <input type="text" name="subject" id="promoSubject" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Message Content *</label>
                <textarea name="message_body" rows="5" required placeholder="Type your custom email message to the artist..." class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('promoEmailModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold shadow">
                    Send Email &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPromoEmailModal(email, name, subject) {
    document.getElementById('promoRecipientEmail').value = email;
    document.getElementById('promoRecipientName').value = name;
    document.getElementById('promoSubject').value = subject;
    document.getElementById('promoEmailModal').classList.remove('hidden');
}
</script>
@endsection
