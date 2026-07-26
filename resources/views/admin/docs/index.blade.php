@extends('layouts.admin')

@section('title', 'System Version & Documentation - Admin')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-white">📖 System Version & Documentation</h1>
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-mono font-bold">
                    {{ $systemInfo['app_version'] }}
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Technical specifications, system environment specifications, and developer operations guide for Gusii Lyrics Vault.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.settings.index') }}" class="px-3.5 py-2 rounded-xl bg-gray-900 hover:bg-gray-800 text-gray-300 text-xs font-bold border border-gray-800 transition">
                ⚙️ Gateways & Settings &rarr;
            </a>
        </div>
    </div>

    <!-- System Version & Environment Specs Grid (Un-enclosed) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-gray-950/80 border border-emerald-500/30 space-y-1">
            <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider block">Application Version</span>
            <div class="text-xl font-extrabold text-white font-mono">{{ $systemInfo['app_version'] }}</div>
            <span class="text-[10px] text-gray-400 block truncate">{{ $systemInfo['release_name'] }}</span>
        </div>

        <div class="p-4 rounded-2xl bg-gray-950/80 border border-indigo-500/30 space-y-1">
            <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider block">Framework Core</span>
            <div class="text-xl font-extrabold text-white font-mono">Laravel {{ $systemInfo['laravel_version'] }}</div>
            <span class="text-[10px] text-gray-400 block font-mono">PHP {{ $systemInfo['php_version'] }}</span>
        </div>

        <div class="p-4 rounded-2xl bg-gray-950/80 border border-amber-500/30 space-y-1">
            <span class="text-[10px] text-amber-400 font-bold uppercase tracking-wider block">Environment & Mode</span>
            <div class="text-xl font-extrabold text-white font-mono uppercase">{{ $systemInfo['environment'] }}</div>
            <span class="text-[10px] text-gray-400 block truncate">{{ $systemInfo['debug_mode'] }}</span>
        </div>

        <div class="p-4 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-1">
            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Database & Server</span>
            <div class="text-xl font-extrabold text-white font-mono uppercase">{{ $systemInfo['database_driver'] }}</div>
            <span class="text-[10px] text-gray-400 block font-mono truncate">{{ $systemInfo['server_software'] }}</span>
        </div>
    </div>

    <!-- Shared Hosting CLI Command Web Runners -->
    <div class="p-6 rounded-2xl bg-emerald-950/20 border border-emerald-500/30 space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-lg">⚡</span>
                <h3 class="text-sm font-bold text-emerald-300">Shared Hosting Web Command Runners</h3>
            </div>
            <span class="text-[10px] font-mono text-emerald-400/80 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">Secret Key Authorized</span>
        </div>

        <p class="text-xs text-gray-300 leading-relaxed">
            Since this production application is deployed on shared hosting environments (cPanel/DirectAdmin) without terminal SSH access, administrative commands can be executed via browser triggers:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
            <div class="p-4 rounded-xl bg-gray-950/90 border border-gray-800 space-y-2">
                <div class="flex items-center justify-between">
                    <strong class="text-xs text-white">Database Migrations & Cache Clear</strong>
                    <a href="/run-migrations?key=gusii2026" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 text-[10px] font-extrabold hover:bg-emerald-400 transition">
                        Run Now &nearr;
                    </a>
                </div>
                <p class="text-[11px] text-gray-400 font-mono">GET /run-migrations?key=gusii2026</p>
                <span class="text-[10px] text-gray-500 block">Executes `php artisan migrate --force` and clears view & route caches.</span>
            </div>

            <div class="p-4 rounded-xl bg-gray-950/90 border border-gray-800 space-y-2">
                <div class="flex items-center justify-between">
                    <strong class="text-xs text-white">Storage Symlink Generator</strong>
                    <a href="/storage-link?key=gusii2026" target="_blank" class="px-3 py-1 rounded-lg bg-indigo-600 text-white text-[10px] font-extrabold hover:bg-indigo-500 transition">
                        Link Storage &nearr;
                    </a>
                </div>
                <p class="text-[11px] text-gray-400 font-mono">GET /storage-link?key=gusii2026</p>
                <span class="text-[10px] text-gray-500 block">Executes `php artisan storage:link` to link public media uploads to storage/app/public.</span>
            </div>
        </div>
    </div>

    <!-- Technical System Documentation Manual -->
    <div class="space-y-6">

        <div class="pb-2 border-b border-gray-800 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-white">📘 Administrator & Operations Manual</h3>
            <span class="text-xs text-gray-400">Gusii Lyrics Vault Technical Architecture</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">

            <!-- Card 1: Artist Catalog & Regional Rules -->
            <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-3">
                <div class="flex items-center gap-2 text-emerald-400 font-bold text-sm">
                    <span>🎤</span>
                    <span>Artist Catalog & Regional Rules</span>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Artist regional origins are strictly restricted to official Gusii counties:
                </p>
                <ul class="list-disc list-inside text-gray-400 space-y-1 font-mono text-[11px]">
                    <li><strong class="text-emerald-400">Kisii County, Kenya</strong></li>
                    <li><strong class="text-emerald-400">Nyamira County, Kenya</strong></li>
                </ul>
                <p class="text-gray-300 leading-relaxed mt-2">
                    Artist avatar images must be uploaded directly via file upload (<code class="text-amber-300 font-mono">image_file</code>). Direct image URL text inputs are disabled to prevent broken external hotlinks.
                </p>
            </div>

            <!-- Card 2: Song Lyrics & Copy Protection -->
            <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-3">
                <div class="flex items-center gap-2 text-indigo-400 font-bold text-sm">
                    <span>🎵</span>
                    <span>Lyrics Indexing & Copy Protection</span>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Song pages feature built-in cultural protection utilities (<code class="text-indigo-300 font-mono">.unselectable</code>) preventing unauthorized text highlight selection and copying.
                </p>
                <p class="text-gray-300 leading-relaxed">
                    Lyrics can be indexed with audio stream links (YouTube, Spotify, Apple Music), Ekegusii verse transcriptions, English translations, and assigned genres.
                </p>
            </div>

            <!-- Card 3: Ad Booking & Spot Placements -->
            <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-3">
                <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                    <span>📢</span>
                    <span>Ad Campaigns & Spot Specs</span>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    The platform supports custom image banner advertising and Google AdSense HTML/Script embedding across 5 strategic locations:
                </p>
                <div class="grid grid-cols-2 gap-2 text-[10px] font-mono">
                    <div class="p-2 rounded bg-gray-900 border border-gray-800 text-amber-300">HEADER TOP</div>
                    <div class="p-2 rounded bg-gray-900 border border-gray-800 text-amber-300">HOMEPAGE MID</div>
                    <div class="p-2 rounded bg-gray-900 border border-gray-800 text-amber-300">HOMEPAGE BOTTOM</div>
                    <div class="p-2 rounded bg-gray-900 border border-gray-800 text-amber-300">LYRICS SIDEBAR</div>
                    <div class="p-2 rounded bg-gray-900 border border-gray-800 text-amber-300 col-span-2">LYRICS BETWEEN BLOCKS</div>
                </div>
            </div>

            <!-- Card 4: Payments & Gateways -->
            <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-3">
                <div class="flex items-center gap-2 text-cyan-400 font-bold text-sm">
                    <span>💳</span>
                    <span>Financial Gateways & Donations</span>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Voluntary visitor donations and artist promotion packages are processed via dual gateways:
                </p>
                <ul class="list-disc list-inside text-gray-400 space-y-1 font-mono text-[11px]">
                    <li><strong class="text-emerald-400">M-Pesa STK Push</strong>: Instant mobile money prompts via Safaricom Daraja API.</li>
                    <li><strong class="text-indigo-400">Stripe Checkout</strong>: Global debit/credit card payments (can be toggled/disabled in Settings).</li>
                </ul>
            </div>

            <!-- Card 5: Role-Based Access Control (RBAC) -->
            <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800 space-y-3 col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 text-rose-400 font-bold text-sm">
                    <span>🔐</span>
                    <span>Staff Roles & Permission Matrix</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px] text-gray-300">
                        <thead class="bg-gray-900 text-gray-400 font-mono uppercase text-[10px] border-b border-gray-800">
                            <tr>
                                <th class="p-2">Portal Feature / Area</th>
                                <th class="p-2">Editor Account</th>
                                <th class="p-2">Super Admin Account</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/60 font-mono">
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Manage Lyrics & Songs</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Manage Artists & Genres</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Lyric Requests & Corrections</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Site Analytics & Financial Logs</td>
                                <td class="p-2 text-gray-500 font-bold">✗ Restricted</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Ad Banners, Campaigns & Inquiries</td>
                                <td class="p-2 text-gray-500 font-bold">✗ Restricted</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                            <tr>
                                <td class="p-2 font-sans font-medium text-white">Site Gateways, Legal Pages & Staff Accounts</td>
                                <td class="p-2 text-gray-500 font-bold">✗ Restricted</td>
                                <td class="p-2 text-emerald-400 font-bold">✓ Full Access</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
