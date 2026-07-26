<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = \App\Models\Setting::get('site_name', 'Gusii Lyrics');
        $pendingRequests = \App\Models\LyricRequest::where('status', 'pending')->count();
        $pendingCorrections = \App\Models\Correction::where('status', 'pending')->count();
        $pendingAdInquiries = \App\Models\AdInquiry::where('status', 'pending')->count();
    @endphp

    <title>@yield('title', 'Admin Dashboard - ' . $siteName)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#090d16] text-gray-100 font-sans antialiased min-h-screen flex">

    <!-- Sidebar Navigation (Desktop & Mobile Drawer) -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0c121e] border-r border-gray-800/80 transform -translate-x-full md:translate-x-0 transition-transform duration-300 flex flex-col justify-between shadow-2xl">
        
        <div class="p-5 space-y-6">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-slate-950 font-black text-base shadow-md">
                        G
                    </div>
                    <div>
                        <span class="text-base font-extrabold text-white">Gusii<span class="text-gradient-emerald">Lyrics</span></span>
                        <span class="block text-[9px] uppercase font-bold tracking-widest text-emerald-400/80 -mt-1">Staff Portal</span>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button id="closeSidebarBtn" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- User Badge Profile -->
            @if(Auth::check())
                <div class="p-3 rounded-2xl bg-gray-900/90 border border-gray-800/80 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</h4>
                        <span class="inline-block text-[9px] font-mono font-bold uppercase tracking-wider px-1.5 py-0.5 rounded {{ Auth::user()->isAdmin() ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' }}">
                            {{ Auth::user()->isAdmin() ? 'Super Admin' : 'Editor' }}
                        </span>
                    </div>
                </div>
            @endif

            <!-- Navigation Links List -->
            <nav class="space-y-1">
                <div class="px-2 text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2">Main Menu</div>

                <!-- Dashboard Link (Super Admin Only) -->
                @if(Auth::user() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard Overview</span>
                    </a>
                @endif

                <!-- Manage Lyrics (All Staff) -->
                <a href="{{ route('admin.songs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.songs.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                    <span>Manage Lyrics</span>
                </a>

                <!-- Manage Artists (All Staff) -->
                <a href="{{ route('admin.artists.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.artists.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                    <span>Manage Artists</span>
                </a>

                <!-- Lyric Requests (All Staff) -->
                <a href="{{ route('admin.requests.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.requests.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Lyric Requests</span>
                    </div>
                    @if($pendingRequests > 0)
                        <span class="px-1.5 py-0.5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-bold">{{ $pendingRequests }}</span>
                    @endif
                </a>

                <!-- Lyric Corrections (All Staff) -->
                <a href="{{ route('admin.corrections.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.corrections.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Lyric Corrections</span>
                    </div>
                    @if($pendingCorrections > 0)
                        <span class="px-1.5 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-bold">{{ $pendingCorrections }}</span>
                    @endif
                </a>

                <!-- Super Admin Dedicated Tools Section -->
                @if(Auth::user() && Auth::user()->isAdmin())
                    <div class="pt-4 border-t border-gray-800/80 space-y-1">
                        <div class="px-2 text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2">Super Admin Tools</div>
                        
                        <!-- Dedicated Site Analytics Page -->
                        <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.analytics.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span>Site Analytics</span>
                        </a>

                        <!-- Manage Donations -->
                        <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.donations.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Manage Donations</span>
                        </a>

                        <!-- Ad Inquiries -->
                        <a href="{{ route('admin.ad-inquiries.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.ad-inquiries.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <span>Ad Inquiries</span>
                            </div>
                            @if($pendingAdInquiries > 0)
                                <span class="px-1.5 py-0.5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-bold">{{ $pendingAdInquiries }}</span>
                            @endif
                        </a>

                        <!-- Site Ad Banners & Spots -->
                        <a href="{{ route('admin.ads.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.ads.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Site Ad Banners</span>
                        </a>

                        <!-- Music Promotions & Campaign Analytics -->
                        <a href="{{ route('admin.promotions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.promotions.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span>Music Promotions</span>
                        </a>

                        <!-- Pages & Legal Content -->
                        <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.pages.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Pages & Legal</span>
                        </a>

                        <!-- Staff & Editors -->
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Staff & Editors</span>
                        </a>

                        <!-- Site Settings -->
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-gray-300 hover:bg-gray-800/60 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Settings & Gateways</span>
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- Sidebar Bottom Footer -->
        <div class="p-5 border-t border-gray-800/80 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-400 hover:text-white hover:bg-gray-800 transition">
                <span>View Public Site</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition">
                    <span>Logout</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow md:ml-64 min-h-screen flex flex-col">
        
        <!-- Admin Top Navigation Header -->
        <header class="glass-nav sticky top-0 z-40 px-4 sm:px-6 lg:px-8 py-3 border-b border-gray-800/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button id="openSidebarBtn" class="md:hidden p-2 rounded-lg text-gray-300 hover:bg-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <span class="text-xs sm:text-sm font-extrabold text-white tracking-tight hidden sm:inline">
                    Gusii Lyrics <span class="text-emerald-400">Staff Portal</span>
                </span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-gray-300 text-xs font-semibold border border-gray-800 transition hidden sm:inline-flex items-center gap-1">
                    <span>View Site</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>

                <!-- Top Navbar Prominent Logout Button -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 font-bold text-xs transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-grow p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="p-4 mb-6 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-6 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-xs sm:text-sm">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Sidebar Mobile Toggle Script -->
    <script>
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('adminSidebar');

        if (openBtn && sidebar) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
            });
        }
        if (closeBtn && sidebar) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });
        }
    </script>
</body>
</html>
