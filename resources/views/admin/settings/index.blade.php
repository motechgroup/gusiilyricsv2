@extends('layouts.admin')

@section('title', 'Site Settings & Gateways Credentials - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Site Settings & Payment Credentials</h1>
            <p class="text-xs text-gray-400 mt-1">Super Admin configuration for branding, SEO, tracking, M-Pesa STK Push, and Stripe API keys.</p>
        </div>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- 1. Site Branding & Preset Donation Amounts -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                    🏷️ Site Branding & Donation Presets
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] }}" placeholder="e.g. Gusii Lyrics" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Upload Site Logo</label>
                        <input type="file" name="site_logo_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                        @if($settings['site_logo'])
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[10px] text-gray-500">Current:</span>
                                <img src="{{ $settings['site_logo'] }}" class="h-6 w-auto rounded">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Upload Favicon (.ico / .png)</label>
                        <input type="file" name="favicon_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                        @if($settings['favicon'])
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[10px] text-gray-500">Current:</span>
                                <img src="{{ $settings['favicon'] }}" class="h-5 w-5 rounded">
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">Visitor Preset Donation Amounts (Comma-Separated Values)</label>
                    <input type="text" name="preset_donation_amounts" value="{{ $settings['preset_donation_amounts'] }}" placeholder="100, 250, 500, 1000, 2500, 5000" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm focus:outline-none focus:border-emerald-500">
                    <span class="text-[11px] text-gray-400 mt-1 block">These preset amount pills will be rendered for visitors to select during M-Pesa or Stripe donation.</span>
                </div>
            </div>

            <!-- 2. M-Pesa API Credentials & STK Push Configuration -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                    💚 M-Pesa Express STK Push & Daraja API Credentials
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">M-Pesa API Environment</label>
                        <select name="mpesa_env" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                            <option value="sandbox" {{ $settings['mpesa_env'] === 'sandbox' ? 'selected' : '' }}>Sandbox Test Environment</option>
                            <option value="production" {{ $settings['mpesa_env'] === 'production' ? 'selected' : '' }}>Live Production Environment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Consumer Key</label>
                        <input type="password" name="mpesa_consumer_key" value="{{ $settings['mpesa_consumer_key'] }}" placeholder="M-Pesa API Consumer Key..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Consumer Secret</label>
                        <input type="password" name="mpesa_consumer_secret" value="{{ $settings['mpesa_consumer_secret'] }}" placeholder="M-Pesa API Consumer Secret..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Lipa Na M-Pesa Passkey</label>
                        <input type="password" name="mpesa_passkey" value="{{ $settings['mpesa_passkey'] }}" placeholder="Passkey string..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">STK Shortcode / Business Code</label>
                        <input type="text" name="mpesa_shortcode" value="{{ $settings['mpesa_shortcode'] }}" placeholder="e.g. 174379" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Buy Goods Till Number</label>
                        <input type="text" name="mpesa_till" value="{{ $settings['mpesa_till'] }}" placeholder="e.g. 5421908" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 3. Stripe API Credentials Configuration -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                    💳 Stripe API Credentials & Payment Link
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Publishable Key (pk_live_...)</label>
                        <input type="text" name="stripe_publishable_key" value="{{ $settings['stripe_publishable_key'] }}" placeholder="pk_test_..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Secret Key (sk_live_...)</label>
                        <input type="password" name="stripe_secret_key" value="{{ $settings['stripe_secret_key'] }}" placeholder="sk_test_..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Webhook Signing Secret (whsec_...)</label>
                        <input type="password" name="stripe_webhook_secret" value="{{ $settings['stripe_webhook_secret'] }}" placeholder="whsec_..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-indigo-400 mb-1">Stripe Checkout / Donate Link</label>
                        <input type="url" name="stripe_url" value="{{ $settings['stripe_url'] }}" placeholder="https://buy.stripe.com/..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 4. Social Media Profiles & Links -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                    📱 Social Media Profiles & Links (Rendered in Site Footer)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Instagram Profile URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] }}" placeholder="https://instagram.com/..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">X / Twitter Profile URL</label>
                        <input type="url" name="social_x" value="{{ $settings['social_x'] }}" placeholder="https://x.com/..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Facebook Page URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] }}" placeholder="https://facebook.com/..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">YouTube Channel URL</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] }}" placeholder="https://youtube.com/@..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">TikTok Profile URL</label>
                        <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] }}" placeholder="https://tiktok.com/@..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 5. SEO & Tracking -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider border-b border-gray-800 pb-2">
                    🔍 SEO Tags & Analytics Tracking
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">SEO Title Tag</label>
                        <input type="text" name="seo_title" value="{{ $settings['seo_title'] }}" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Meta Keywords</label>
                        <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] }}" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Meta Description</label>
                    <textarea name="seo_description" rows="2" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">{{ $settings['seo_description'] }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Save All Credentials & Preset Amounts
            </button>
        </form>
    </div>

</div>
@endsection
