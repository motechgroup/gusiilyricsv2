<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = \App\Models\Setting::get('site_name', 'Gusii Lyrics');
        $siteLogo = \App\Models\Setting::get('site_logo', '/images/logo.png');
        $favicon = \App\Models\Setting::get('favicon', '/images/favicon.png');
        $defaultSeoTitle = \App\Models\Setting::get('seo_title', 'Gusii Lyrics - Ekegusii Song Lyrics');
        $defaultSeoDesc = \App\Models\Setting::get('seo_description', 'Read official Ekegusii lyrics and stream songs on Spotify & YouTube.');
        $defaultKeywords = \App\Models\Setting::get('seo_keywords', 'Ekegusii lyrics, Kisii music');
        $gaId = \App\Models\Setting::get('google_analytics_id', '');
        $adsenseCode = \App\Models\Setting::get('google_adsense_code', '');
        $metaPixelId = \App\Models\Setting::get('meta_pixel_id', '');

        $socialInstagram = \App\Models\Setting::get('social_instagram', 'https://instagram.com');
        $socialX = \App\Models\Setting::get('social_x', 'https://x.com');
        $socialFacebook = \App\Models\Setting::get('social_facebook', 'https://facebook.com');
        $socialYoutube = \App\Models\Setting::get('social_youtube', '');
        $socialTiktok = \App\Models\Setting::get('social_tiktok', '');
    @endphp

    <title>@yield('title', $defaultSeoTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultSeoDesc)">
    <meta name="keywords" content="{{ $defaultKeywords }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OpenGraph SEO Tags -->
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@yield('title', $defaultSeoTitle)">
    <meta property="og:description" content="@yield('meta_description', $defaultSeoDesc)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @if($siteLogo)
        <meta property="og:image" content="{{ url($siteLogo) }}">
    @endif

    <!-- Favicon -->
    @if($favicon)
        <link rel="icon" href="{{ $favicon }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ $favicon }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Analytics (GA4) -->
    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ $gaId }}');
        </script>
    @endif

    <!-- Meta / Facebook Ads Pixel -->
    @if($metaPixelId)
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{ $metaPixelId }}');
          fbq('track', 'PageView');
        </script>
    @endif

    <!-- Google AdSense Code -->
    @if($adsenseCode)
        {!! $adsenseCode !!}
    @endif
    <!-- WebSite Sitelinks Search Box JSON-LD Schema -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "@type": "WebSite",
      "name": "GusiiLyrics",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/songs') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
</head>
<body class="bg-[#090d16] text-gray-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-slate-950">

    <!-- Header Navigation -->
    <header class="glass-nav sticky top-0 z-40 px-4 sm:px-6 lg:px-8 py-3.5 border-b border-gray-800/80">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-10 sm:h-11 w-auto object-contain">
                @else
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-slate-950 font-black text-base shadow-lg shadow-emerald-500/20">
                            G
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                            Gusii<span class="text-gradient-emerald">Lyrics</span>
                        </span>
                    </div>
                @endif
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-xs font-bold uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-emerald-400 transition {{ request()->routeIs('home') ? 'text-emerald-400' : 'text-gray-300' }}">Home</a>
                <a href="{{ route('songs.index') }}" class="hover:text-emerald-400 transition {{ request()->routeIs('songs.*') ? 'text-emerald-400' : 'text-gray-300' }}">Lyrics</a>
                <a href="{{ route('artists.index') }}" class="hover:text-emerald-400 transition {{ request()->routeIs('artists.*') ? 'text-emerald-400' : 'text-gray-300' }}">Artists</a>
                <a href="{{ route('donate') }}" class="hover:text-emerald-400 transition {{ request()->routeIs('donate') ? 'text-emerald-400' : 'text-gray-300' }}">Donate</a>
            </nav>

            <!-- Mobile Hamburger Toggle Button -->
            <button id="mobileNavToggleBtn" class="md:hidden p-2 rounded-xl text-gray-300 hover:bg-gray-800/80 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <!-- Collapsible Mobile Navigation Drawer -->
        <div id="mobileNavDrawer" class="hidden md:hidden pt-4 pb-2 px-2 border-t border-gray-800/80 mt-3 space-y-2 text-xs font-bold uppercase tracking-wider">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl transition {{ request()->routeIs('home') ? 'bg-emerald-500/20 text-emerald-400' : 'text-gray-300 hover:bg-gray-800' }}">Home</a>
            <a href="{{ route('songs.index') }}" class="block px-3 py-2.5 rounded-xl transition {{ request()->routeIs('songs.*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-gray-300 hover:bg-gray-800' }}">Lyrics</a>
            <a href="{{ route('artists.index') }}" class="block px-3 py-2.5 rounded-xl transition {{ request()->routeIs('artists.*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-gray-300 hover:bg-gray-800' }}">Artists</a>
            <a href="{{ route('donate') }}" class="block px-3 py-2.5 rounded-xl transition {{ request()->routeIs('donate') ? 'bg-emerald-500/20 text-emerald-400' : 'text-gray-300 hover:bg-gray-800' }}">Donate</a>
        </div>
    </header>

    <!-- Main Page Content -->
    <main class="flex-grow">
        @php
            $headerAd = \App\Models\SiteAd::getAdForSpot('header_top');
            $footerAd = \App\Models\SiteAd::getAdForSpot('footer');
        @endphp

        <!-- Header Top Ad Banner Spot -->
        @if($headerAd)
            <div class="max-w-7xl mx-auto px-4 mt-4 text-center">
                @if($headerAd->type === 'image' && $headerAd->image_path)
                    <a href="{{ $headerAd->target_url ?? '#' }}" target="_blank" rel="noopener" class="inline-block max-w-full">
                        <img src="{{ $headerAd->image_url }}" alt="{{ $headerAd->title }}" class="max-h-24 w-auto rounded-2xl border border-gray-800 shadow-lg mx-auto">
                    </a>
                @elseif($headerAd->type === 'script' && $headerAd->code_script)
                    <div class="inline-block max-w-full">
                        {!! $headerAd->code_script !!}
                    </div>
                @endif
            </div>
        @endif

        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Ad Banner Spot -->
    @php
        $footerAd = \App\Models\SiteAd::getAdForSpot('footer');
    @endphp
    @if($footerAd)
        <div class="max-w-7xl mx-auto px-4 mt-8 text-center">
            @if($footerAd->type === 'image' && $footerAd->image_path)
                <a href="{{ $footerAd->target_url ?? '#' }}" target="_blank" rel="noopener" class="inline-block max-w-full">
                    <img src="{{ $footerAd->image_url }}" alt="{{ $footerAd->title }}" class="max-h-24 w-auto rounded-2xl border border-gray-800 shadow-lg mx-auto">
                </a>
            @elseif($footerAd->type === 'script' && $footerAd->code_script)
                <div class="inline-block max-w-full">
                    {!! $footerAd->code_script !!}
                </div>
            @endif
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-950 border-t border-gray-800/80 py-10 mt-16 text-xs text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <p class="text-white font-bold text-sm">{{ $siteName }}</p>
                <p class="text-gray-400">Preserving Ekegusii music heritage, song lyrics & official streaming links.</p>
            </div>

            <!-- Circular Social Media Icons (Admin Managed) -->
            <div class="flex items-center space-x-3">
                @if($socialInstagram)
                    <a href="{{ $socialInstagram }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="w-11 h-11 rounded-full bg-gray-800/80 hover:bg-emerald-500 text-white hover:text-slate-950 transition flex items-center justify-center shadow-lg border border-gray-700/50">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif

                @if($socialX)
                    <a href="{{ $socialX }}" target="_blank" rel="noopener noreferrer" title="X (Twitter)" class="w-11 h-11 rounded-full bg-gray-800/80 hover:bg-emerald-500 text-white hover:text-slate-950 transition flex items-center justify-center shadow-lg border border-gray-700/50">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif

                @if($socialFacebook)
                    <a href="{{ $socialFacebook }}" target="_blank" rel="noopener noreferrer" title="Facebook" class="w-11 h-11 rounded-full bg-gray-800/80 hover:bg-emerald-500 text-white hover:text-slate-950 transition flex items-center justify-center shadow-lg border border-gray-700/50">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif

                @if($socialYoutube)
                    <a href="{{ $socialYoutube }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="w-11 h-11 rounded-full bg-gray-800/80 hover:bg-emerald-500 text-white hover:text-slate-950 transition flex items-center justify-center shadow-lg border border-gray-700/50">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif

                @if($socialTiktok)
                    <a href="{{ $socialTiktok }}" target="_blank" rel="noopener noreferrer" title="TikTok" class="w-11 h-11 rounded-full bg-gray-800/80 hover:bg-emerald-500 text-white hover:text-slate-950 transition flex items-center justify-center shadow-lg border border-gray-700/50">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02.48-.04 1.47-.04 1.95v.02c-1.54-.42-3.23-.1-4.48.82-1.26.91-1.99 2.45-1.91 4.02.04 1.05.51 2.06 1.29 2.77.92.85 2.19 1.25 3.44 1.1 1.43-.11 2.74-.97 3.39-2.24.42-.82.61-1.77.59-2.71V.02z"/></svg>
                    </a>
                @endif
            </div>

            <div class="flex flex-wrap items-center justify-center md:justify-end space-x-4 sm:space-x-6 gap-y-2 text-xs">
                <a href="{{ route('categories.top-100') }}" class="hover:text-emerald-400">Top 100 Songs</a>
                <a href="{{ route('categories.gospel') }}" class="hover:text-emerald-400">Gospel Songs</a>
                <a href="{{ route('categories.traditional') }}" class="hover:text-emerald-400">Traditional</a>
                <a href="{{ route('categories.love-songs') }}" class="hover:text-emerald-400">Love Songs</a>
                <a href="{{ route('categories.wedding') }}" class="hover:text-emerald-400">Wedding Songs</a>
                <a href="{{ route('albums.index') }}" class="hover:text-emerald-400">Albums</a>
                <a href="{{ route('donate') }}" class="hover:text-emerald-400">Donate</a>
                <a href="{{ route('advertise') }}" class="hover:text-emerald-400">Advertise</a>
                <a href="{{ route('pages.terms') }}" class="hover:text-emerald-400">Terms</a>
                <a href="{{ route('pages.privacy') }}" class="hover:text-emerald-400">Privacy</a>
            </div>
        </div>
    </footer>

    <!-- M-Pesa STK Push Donation Modal -->
    <div id="donateModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
            <button onclick="closeDonateModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="text-center space-y-1">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 mx-auto flex items-center justify-center text-2xl font-bold mb-2">
                    ❤️
                </div>
                <h3 class="text-xl font-extrabold text-white">Support Gusii Lyrics</h3>
                <p class="text-xs text-gray-400">Enter your M-Pesa phone number to receive the PIN prompt on your phone screen.</p>
            </div>

            @php
                $rawPresetsModal = \App\Models\Setting::get('preset_donation_amounts', '100, 250, 500, 1000, 2500, 5000');
                $presetAmountsModal = array_filter(array_map('trim', explode(',', $rawPresetsModal)));
                $stripeUrlModal = \App\Models\Setting::get('stripe_url', '');
            @endphp

            <div class="space-y-4">
                <!-- Preset Amount Selection Pills -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">Select Donation Amount (KES)</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($presetAmountsModal as $amt)
                            <button type="button" onclick="setModalAmount('{{ $amt }}')" class="modal-amt-btn px-2 py-2 rounded-xl bg-gray-950 hover:bg-emerald-500/20 text-white font-mono text-xs border border-gray-800 transition">
                                KES {{ number_format($amt) }}
                            </button>
                        @endforeach
                    </div>
                    <input type="number" id="modalAmount" value="500" class="w-full mt-2 px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500" placeholder="Custom amount...">
                </div>

                <!-- M-Pesa STK Push Form -->
                <form onsubmit="triggerModalStk(event)" class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-emerald-400">
                        <span>📲 M-Pesa Express Phone Prompt</span>
                        <span id="modalActiveAmountBadge" class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono text-[11px] font-bold">KES 500</span>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-300 mb-1">M-Pesa Phone Number <span class="text-rose-500">*</span></label>
                        <input type="tel" id="modalPhone" required placeholder="e.g. 0712345678 or 254712345678" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500">
                    </div>

                    <button type="submit" id="modalStkBtn" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs transition active:scale-98">
                        Send M-Pesa PIN Prompt to Phone
                    </button>
                </form>

                <div id="modalStkStatus" class="hidden p-3 rounded-xl border text-xs"></div>

                @if($stripeUrlModal)
                    <div class="pt-2 text-center">
                        <a href="{{ $stripeUrlModal }}" target="_blank" class="text-xs text-indigo-400 hover:underline">
                            Or pay via Credit Card / Stripe &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Request Song Lyric Modal -->
    <div id="requestModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl space-y-4">
            <button onclick="closeRequestModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div>
                <h3 class="text-xl font-extrabold text-white">Request Ekegusii Lyric</h3>
                <p class="text-xs text-gray-400 mt-1">Can't find a song? Tell us and our editors will transcribe it!</p>
            </div>

            <form method="POST" action="{{ route('actions.request-lyric') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="song_title" required placeholder="e.g. Nyasae Monyene" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="artist_name" required placeholder="e.g. Fenny Kerubo" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Your Email (Optional)</label>
                    <input type="email" name="visitor_email" placeholder="Get notified when uploaded..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition">
                    Submit Lyric Request
                </button>
            </form>
        </div>
    </div>

    <script>
        const mobileNavToggleBtn = document.getElementById('mobileNavToggleBtn');
        const mobileNavDrawer = document.getElementById('mobileNavDrawer');

        function toggleMobileNav() {
            if (mobileNavDrawer) {
                mobileNavDrawer.classList.toggle('hidden');
            }
        }

        if (mobileNavToggleBtn) {
            mobileNavToggleBtn.addEventListener('click', toggleMobileNav);
        }

        function openDonateModal() { document.getElementById('donateModal').classList.remove('hidden'); }
        function closeDonateModal() { document.getElementById('donateModal').classList.add('hidden'); }
        function openRequestModal() { document.getElementById('requestModal').classList.remove('hidden'); }
        function closeRequestModal() { document.getElementById('requestModal').classList.add('hidden'); }

        function setModalAmount(amt) {
            document.getElementById('modalAmount').value = amt;
            const badge = document.getElementById('modalActiveAmountBadge');
            if (badge) {
                badge.innerText = 'KES ' + Number(amt).toLocaleString();
            }

            // Highlight selected pill
            document.querySelectorAll('.modal-amt-btn').forEach(btn => {
                if (btn.innerText.includes(Number(amt).toLocaleString())) {
                    btn.classList.add('bg-emerald-500', 'text-slate-950', 'font-black');
                    btn.classList.remove('bg-gray-950', 'text-white');
                } else {
                    btn.classList.remove('bg-emerald-500', 'text-slate-950', 'font-black');
                    btn.classList.add('bg-gray-950', 'text-white');
                }
            });
        }

        async function triggerModalStk(e) {
            e.preventDefault();
            const phone = document.getElementById('modalPhone').value;
            const amount = document.getElementById('modalAmount').value;
            const btn = document.getElementById('modalStkBtn');
            const status = document.getElementById('modalStkStatus');

            if (!phone || !amount) { alert('Enter phone number and amount'); return; }

            btn.disabled = true;
            btn.innerHTML = '⌛ Sending Prompt...';
            status.classList.remove('hidden', 'bg-emerald-500/10', 'bg-rose-500/10');
            status.classList.add('bg-emerald-500/10', 'border-emerald-500/30', 'text-emerald-300');
            status.innerHTML = 'Connecting to M-Pesa...';

            try {
                const res = await fetch('{{ route("api.mpesa.stkpush") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ phone, amount })
                });
                const data = await res.json();

                if (res.ok && data.success) {
                    status.className = 'p-3 rounded-xl border bg-emerald-500/10 border-emerald-500/30 text-emerald-300 text-xs';
                    status.innerHTML = `<strong>📲 Prompt Sent!</strong><p>${data.message}</p>`;
                } else {
                    status.className = 'p-3 rounded-xl border bg-rose-500/10 border-rose-500/30 text-rose-300 text-xs';
                    status.innerHTML = `<strong>❌ Error:</strong><p>${data.message}</p>`;
                }
            } catch (err) {
                status.className = 'p-3 rounded-xl border bg-rose-500/10 border-rose-500/30 text-rose-300 text-xs';
                status.innerHTML = '<strong>❌ Network error.</strong>';
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Send M-Pesa PIN Prompt to Phone';
            }
        }
    </script>

    <!-- Cookie Consent Popup Banner -->
    <div id="cookieConsentBanner" class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:max-w-md z-50 p-5 rounded-3xl bg-gray-900/95 border border-gray-800 shadow-2xl backdrop-blur-xl hidden space-y-3">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-xl">🍪</span>
                <h4 class="text-sm font-extrabold text-white">We Value Your Privacy</h4>
            </div>
            <button onclick="acceptCookies()" class="text-gray-400 hover:text-white text-xs">&times;</button>
        </div>
        <p class="text-xs text-gray-300 leading-relaxed">
            We use cookies and analytics to enhance your experience, measure traffic, and optimize Ekegusii lyrics delivery. Read our <a href="{{ route('pages.privacy') }}" class="text-emerald-400 underline">Privacy Policy</a>.
        </p>
        <div class="flex items-center justify-end gap-2 pt-1">
            <button onclick="acceptCookies()" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs transition shadow-md">
                Accept Cookies & Continue
            </button>
        </div>
    </div>

    <script>
        // Cookie Consent Logic
        document.addEventListener('DOMContentLoaded', () => {
            if (!localStorage.getItem('gusiilylrics_cookie_consent')) {
                const banner = document.getElementById('cookieConsentBanner');
                if (banner) { banner.classList.remove('hidden'); }
            }
        });

        function acceptCookies() {
            localStorage.setItem('gusiilylrics_cookie_consent', 'accepted');
            const banner = document.getElementById('cookieConsentBanner');
            if (banner) { banner.classList.add('hidden'); }
        }
    </script>
</body>
</html>
