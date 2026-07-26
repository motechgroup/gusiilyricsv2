@extends('layouts.app')

@section('title', 'Advertise With Us - Reach Thousands of Gusii Music Fans')
@section('meta_description', 'Promote your brand, music release, or business on Gusii Lyrics Vault.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Header Banner -->
    <div class="text-center space-y-3">
        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider">
            📢 Brand & Artist Promotion
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Advertise on <span class="text-gradient-emerald">Gusii Lyrics</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
            Reach tens of thousands of active Ekegusii music listeners, music fans, and cultural enthusiasts daily across Kenya and worldwide.
        </p>
    </div>

    <!-- Placement Opportunities Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-6 rounded-3xl border border-emerald-500/30 space-y-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl font-bold">
                🎯
            </div>
            <h3 class="text-base font-extrabold text-white">Header Top Banner</h3>
            <p class="text-xs text-gray-400 leading-relaxed">
                Prime visibility position at the top of every page layout across desktop and mobile devices.
            </p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-indigo-500/30 space-y-3">
            <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xl font-bold">
                🎶
            </div>
            <h3 class="text-base font-extrabold text-white">In-Lyrics Banners</h3>
            <p class="text-xs text-gray-400 leading-relaxed">
                High-engagement placements integrated directly above and below trending song lyrics.
            </p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-amber-500/30 space-y-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl font-bold">
                ⭐
            </div>
            <h3 class="text-base font-extrabold text-white">Sponsored Artist / Event</h3>
            <p class="text-xs text-gray-400 leading-relaxed">
                Featured music video spotlights and exclusive brand sponsorships for cultural festivals.
            </p>
        </div>
    </div>

    <!-- Ad Booking Submission Form -->
    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-gray-800 space-y-6">
        <div class="border-b border-gray-800 pb-4">
            <h2 class="text-xl font-extrabold text-white">Submit Ad Booking Inquiry</h2>
            <p class="text-xs text-gray-400 mt-1">Fill out your campaign requirements below and our team will get in touch with rate cards and stats.</p>
        </div>

        <form method="POST" action="{{ route('advertise.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Your Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="advertiser_name" required placeholder="e.g. Mogaka James" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Company / Brand Name</label>
                    <input type="text" name="company_name" placeholder="e.g. Gusii Music Awards / Brand Inc" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="e.g. mogaka@example.com" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Phone / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" required placeholder="e.g. 0712345678" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Target Ad Placement Spot <span class="text-rose-500">*</span></label>
                    <select name="placement_spot" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="header_banner">Header Top Banner (All Pages)</option>
                        <option value="in_lyrics">In-Lyrics Banner (Song Pages)</option>
                        <option value="sidebar">Sidebar / Homepage Banner</option>
                        <option value="footer">Footer Sponsorship Spot</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Budget / Duration Range</label>
                    <select name="budget_range" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="1_week">1 Week Trial Campaign</option>
                        <option value="1_month">1 Month Featured Campaign</option>
                        <option value="3_months">3 Months Quarter Package</option>
                        <option value="custom">Custom Long-Term Campaign</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Upload Ad Banner Artwork / Logo (Optional)</label>
                <input type="file" name="banner_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Campaign Details / Target Link</label>
                <textarea name="message" rows="4" placeholder="Tell us about your brand, target website URL, or desired campaign launch dates..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-sm transition">
                🚀 Submit Ad Campaign Booking Inquiry
            </button>
        </form>
    </div>

</div>
@endsection
