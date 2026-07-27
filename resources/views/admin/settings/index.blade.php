@extends('layouts.admin')

@section('title', 'Site Settings & Gateways Credentials - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Site Settings & Configurations</h1>
            <p class="text-xs text-gray-400 mt-1">Super Admin standalone setting cards. Save each setting section independently.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('storage-link') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-sky-400 font-bold border border-sky-500/30 text-xs shadow-lg transition inline-flex items-center gap-1.5">
                🔗 Link Storage (`storage:link`)
            </a>
            <a href="{{ route('run-migrations') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-extrabold text-xs shadow-lg transition inline-flex items-center gap-1.5">
                ⚡ Run DB Migrations & Clear Cache
            </a>
        </div>
    </div>

    <!-- 1. Site Branding & Preset Donation Amounts -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="branding">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                    🏷️ Site Branding & Donation Presets
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

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
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Footer Description Text</label>
                <textarea name="footer_description" rows="2" placeholder="Enter footer summary text..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">{{ $settings['footer_description'] ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">Visitor Preset Donation Amounts (Comma-Separated Values)</label>
                <input type="text" name="preset_donation_amounts" value="{{ $settings['preset_donation_amounts'] }}" placeholder="100, 250, 500, 1000, 2500, 5000" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm focus:outline-none focus:border-emerald-500">
                <span class="text-[11px] text-gray-400 mt-1 block">These preset amount pills will be rendered for visitors to select during M-Pesa or Stripe donation.</span>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save Branding & Presets
                </button>
            </div>
        </form>
    </div>

    <!-- 2. M-Pesa API Credentials & STK Push Configuration -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="mpesa">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                    💚 M-Pesa Express STK Push & Daraja API Credentials
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

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

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save M-Pesa Credentials
                </button>
            </div>
        </form>
    </div>

    <!-- 3. Stripe API Credentials Configuration -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="stripe">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider flex items-center gap-2">
                    💳 Stripe API Credentials & Payment Link
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

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

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-500 hover:bg-indigo-400 text-white font-bold text-xs shadow-lg transition">
                    Save Stripe Credentials
                </button>
            </div>
        </form>
    </div>

    <!-- 4. Social Media Profiles & Links -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="social">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider flex items-center gap-2">
                    📱 Social Media Profiles & Links (Rendered in Footer)
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

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

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save Social Links
                </button>
            </div>
        </form>
    </div>

    <!-- 5. SMTP Mail Server Configuration -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="smtp">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                    📧 SMTP Server Settings & Mail Dispatcher
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Mail Driver</label>
                    <select name="mail_mailer" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="smtp" {{ ($settings['mail_mailer'] ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP (Recommended)</option>
                        <option value="sendmail" {{ ($settings['mail_mailer'] ?? '') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        <option value="log" {{ ($settings['mail_mailer'] ?? '') === 'log' ? 'selected' : '' }}>Log Driver (Testing Only)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">SMTP Host</label>
                    <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" placeholder="mail.gusiilyrics.com or smtp.gmail.com" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">SMTP Port</label>
                    <input type="text" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" placeholder="587 or 465" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">SMTP Username / Email</label>
                    <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" placeholder="info@gusiilyrics.com" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">SMTP Password</label>
                    <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" placeholder="Enter mailbox password..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Encryption</label>
                    <select name="mail_encryption" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                        <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                        <option value="null" {{ ($settings['mail_encryption'] ?? '') === 'null' ? 'selected' : '' }}>None</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Sender Email (From Address)</label>
                    <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'info@gusiilyrics.com' }}" placeholder="info@gusiilyrics.com" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Sender Name (From Name)</label>
                    <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Gusii Lyrics' }}" placeholder="Gusii Lyrics" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save SMTP Configuration
                </button>
            </div>
        </form>
    </div>

    <!-- 6. SEO Tags & Analytics Tracking -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="seo">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    🔍 SEO Tags & Analytics Tracking
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

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

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Google Analytics Tracking ID</label>
                    <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Google AdSense Code / Publisher ID</label>
                    <input type="text" name="google_adsense_code" value="{{ $settings['google_adsense_code'] ?? '' }}" placeholder="ca-pub-XXXXXXXXXXXXXXXX or full <script> tag" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Meta Pixel ID</label>
                    <input type="text" name="meta_pixel_id" value="{{ $settings['meta_pixel_id'] ?? '' }}" placeholder="123456789012345" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save SEO & Analytics
                </button>
            </div>
        </form>
    </div>

    <!-- 8. Mobile App Downloads & Store Links Settings -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="mobile_app">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                    📱 Mobile App Downloads & Store Links
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

            <div class="space-y-4 text-xs">
                <div class="flex items-center gap-3 p-3.5 bg-gray-950 rounded-2xl border border-gray-800">
                    <input type="checkbox" id="app_download_enabled" name="app_download_enabled" value="1" {{ ($settings['app_download_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="w-4 h-4 rounded bg-gray-900 border-gray-700 text-emerald-500 focus:ring-0">
                    <label for="app_download_enabled" class="font-bold text-white cursor-pointer select-none">
                        Enable Mobile App Download Promo Banner on Homepage & Footer
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Banner Main Title</label>
                        <input type="text" name="app_banner_title" value="{{ $settings['app_banner_title'] ?? 'Take Gusii Lyrics Everywhere! Download Our Mobile App' }}" placeholder="Title..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Banner Subtitle / Description</label>
                        <input type="text" name="app_banner_subtitle" value="{{ $settings['app_banner_subtitle'] ?? 'Stream Ekegusii song lyrics, translations, audio previews, and artist profiles offline on Android & iOS.' }}" placeholder="Subtitle..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Google Play Store Link</label>
                        <input type="text" name="app_play_store_url" value="{{ $settings['app_play_store_url'] ?? '#' }}" placeholder="https://play.google.com/store/apps/details?id=..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-sky-400 mb-1">Apple App Store Link</label>
                        <input type="text" name="app_app_store_url" value="{{ $settings['app_app_store_url'] ?? '#' }}" placeholder="https://apps.apple.com/app/..." class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">Direct APK Download Link</label>
                        <input type="text" name="app_direct_apk_url" value="{{ $settings['app_direct_apk_url'] ?? '#' }}" placeholder="https://gusiilyrics.com/downloads/app.apk" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save Mobile App Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 9. Promote Music Social Reach & Audience Cards -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="section_type" value="social_stats">

            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    📊 Public Audience & Social Reach Cards (/promote-music)
                </h3>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-mono">Standalone Save</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <!-- Web Traffic -->
                <div class="p-4 rounded-2xl bg-gray-950 border border-emerald-500/30 space-y-2">
                    <label class="block font-bold text-emerald-400 uppercase">Card 1: Web Traffic</label>
                    <input type="text" name="social_stat_web_traffic" value="{{ $settings['social_stat_web_traffic'] ?? '150,000+' }}" placeholder="e.g. 150,000+" class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_web_label" value="{{ $settings['social_stat_web_label'] ?? 'Monthly Web Traffic' }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- YouTube -->
                <div class="p-4 rounded-2xl bg-gray-950 border border-rose-500/30 space-y-2">
                    <label class="block font-bold text-rose-400 uppercase">Card 2: YouTube</label>
                    <input type="text" name="social_stat_youtube_subscribers" value="{{ $settings['social_stat_youtube_subscribers'] ?? '25,000+' }}" placeholder="e.g. 25,000+" class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_youtube_label" value="{{ $settings['social_stat_youtube_label'] ?? 'YouTube Subscribers' }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- Instagram -->
                <div class="p-4 rounded-2xl bg-gray-950 border border-pink-500/30 space-y-2">
                    <label class="block font-bold text-pink-400 uppercase">Card 3: Instagram</label>
                    <input type="text" name="social_stat_instagram_followers" value="{{ $settings['social_stat_instagram_followers'] ?? '18,500+' }}" placeholder="e.g. 18,500+" class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_instagram_label" value="{{ $settings['social_stat_instagram_label'] ?? 'Instagram Followers' }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-gray-300">
                </div>

                <!-- TikTok -->
                <div class="p-4 rounded-2xl bg-gray-950 border border-cyan-500/30 space-y-2">
                    <label class="block font-bold text-cyan-400 uppercase">Card 4: TikTok</label>
                    <input type="text" name="social_stat_tiktok_community" value="{{ $settings['social_stat_tiktok_community'] ?? '32,000+' }}" placeholder="e.g. 32,000+" class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono">
                    <input type="text" name="social_stat_tiktok_label" value="{{ $settings['social_stat_tiktok_label'] ?? 'TikTok Community' }}" placeholder="Label..." class="w-full px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl text-gray-300">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-lg transition">
                    Save Social Reach Cards Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 7. SMTP Connection Tester Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/30 space-y-4">
        <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider">
            🧪 Test SMTP Server Email Connection
        </h3>
        <p class="text-xs text-gray-400">Send a test email to verify your SMTP mail credentials, host, and port settings.</p>

        <form method="POST" action="{{ route('admin.settings.test-email') }}" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="email" name="recipient" required placeholder="Enter recipient email (e.g. yourname@gmail.com)..." class="flex-grow px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shrink-0 transition">
                Send Test Email &rarr;
            </button>
        </form>
    </div>

</div>
@endsection
