@extends('layouts.admin')

@section('title', ($ad->exists ? 'Edit' : 'Create') . ' Ad Campaign - Admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">{{ $ad->exists ? 'Edit Ad Campaign' : 'Create New Ad Campaign' }}</h1>
            <p class="text-xs text-gray-400 mt-1">Configure ad placement spot, banner artwork, or custom HTML/Script code.</p>
        </div>
        <a href="{{ route('admin.ads.index') }}" class="px-3 py-1.5 rounded-xl bg-gray-800 text-gray-300 hover:text-white text-xs font-bold border border-gray-700">
            &larr; Back to Ads List
        </a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800">
        <form method="POST" action="{{ $ad->exists ? route('admin.ads.update', $ad->id) : route('admin.ads.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($ad->exists)
                @method('PUT')
            @endif

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Campaign Title <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $ad->title) }}" required placeholder="e.g. Header Pepsi Banner Campaign" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Placement Spot <span class="text-rose-500">*</span></label>
                    <select name="placement_spot" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="header_top" {{ old('placement_spot', $ad->placement_spot) === 'header_top' ? 'selected' : '' }}>Header Top Banner (728x90 or 320x50 px)</option>
                        <option value="lyrics_above" {{ old('placement_spot', $ad->placement_spot) === 'lyrics_above' ? 'selected' : '' }}>Lyrics Page Above (728x90 or 468x60 px)</option>
                        <option value="in_lyrics" {{ old('placement_spot', $ad->placement_spot) === 'in_lyrics' ? 'selected' : '' }}>In Between Verses / Chorus Lyrics Blocks (In-Article Responsive / 300x250 px)</option>
                        <option value="lyrics_below" {{ old('placement_spot', $ad->placement_spot) === 'lyrics_below' ? 'selected' : '' }}>Lyrics Page Below (728x90 or 468x60 px)</option>
                        <option value="sidebar" {{ old('placement_spot', $ad->placement_spot) === 'sidebar' ? 'selected' : '' }}>Sidebar / Content Spot (300x250 or 336x280 px)</option>
                        <option value="footer" {{ old('placement_spot', $ad->placement_spot) === 'footer' ? 'selected' : '' }}>Footer Spot (728x90 or 970x90 px)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Ad Format Type <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="image" {{ old('type', $ad->type) === 'image' ? 'selected' : '' }}>Image Banner Upload</option>
                        <option value="script" {{ old('type', $ad->type) === 'script' ? 'selected' : '' }}>Custom Script / HTML / AdSense Code</option>
                    </select>
                </div>
            </div>

            <!-- Ad Dimensions Cheat-Sheet Guide -->
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-300 space-y-2 text-xs">
                <div class="font-extrabold uppercase tracking-wider flex items-center gap-2 text-amber-400">
                    <span>📏 Recommended Image Banner Dimensions & Sizes</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-mono leading-relaxed">
                    <div>• <strong>Header Top Banner:</strong> 728×90 px (Leaderboard) or 320×50 px (Mobile)</div>
                    <div>• <strong>Lyrics Page (Above/Below):</strong> 728×90 px or 468×60 px (Banner)</div>
                    <div>• <strong>Sidebar / Content Spot:</strong> 300×250 px (Medium Box) or 336×280 px</div>
                    <div>• <strong>Footer Spot:</strong> 728×90 px or 970×90 px (Large Leaderboard)</div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Image Banner Details</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Upload Banner Image</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                        @if($ad->image_path)
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[10px] text-gray-500">Current Preview:</span>
                                <img src="{{ $ad->image_url }}" class="h-8 rounded border border-gray-800">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Target Click URL</label>
                        <input type="url" name="target_url" value="{{ old('target_url', $ad->target_url) }}" placeholder="https://example.com/promo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <div class="space-y-2 pt-4 border-t border-gray-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-amber-400">Custom AdSense / HTML Script Code</h3>
                <textarea name="code_script" rows="5" placeholder="Paste <script> or HTML iframe code here..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500 leading-relaxed">{{ old('code_script', $ad->code_script) }}</textarea>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $ad->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-800 text-emerald-500 focus:ring-0 bg-gray-950">
                <label for="is_active" class="text-xs font-bold text-white">Enable & Activate this Ad Campaign immediately</label>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                {{ $ad->exists ? 'Save & Update Ad Campaign' : 'Publish New Ad Campaign' }}
            </button>
        </form>
    </div>

</div>
@endsection
