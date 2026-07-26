@extends('layouts.admin')

@section('title', 'Manage Pages & Legal Content - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Pages & Legal Content Manager</h1>
            <p class="text-xs text-gray-400 mt-1">Super Admin manager for public Terms of Service (/terms) and Privacy Policy (/privacy).</p>
        </div>
    </div>

    <!-- Legal Pages List Table (Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider text-[10px] border-b border-gray-800">
                <tr>
                    <th class="py-3 px-4">Page Title & Scope</th>
                    <th class="py-3 px-4">Public URL</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Last Updated</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @foreach($pages as $p)
                    <tr class="hover:bg-gray-900/40 transition">
                        <td class="py-4 px-4 font-bold text-white">
                            <strong class="block text-sm text-white">{{ $p['title'] }}</strong>
                            <span class="text-gray-400 text-[11px] font-normal leading-relaxed max-w-md block mt-0.5">{{ $p['description'] }}</span>
                        </td>
                        <td class="py-4 px-4 font-mono text-emerald-400 text-[11px]">
                            <a href="{{ $p['url'] }}" target="_blank" class="hover:underline flex items-center gap-1">
                                <span>/{{ $p['slug'] }}</span>
                                <span class="text-[10px]">&nearr;</span>
                            </a>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold uppercase text-[10px]">
                                🟢 Published
                            </span>
                        </td>
                        <td class="py-4 px-4 font-mono text-gray-400 text-[11px]">
                            {{ $p['updated_at'] }}
                        </td>
                        <td class="py-4 px-4 text-right space-x-2">
                            <a href="{{ route('pages.edit', $p['slug']) }}" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs shadow-md transition inline-flex items-center gap-1">
                                <span>✏️ Edit Page Content</span>
                            </a>
                            <a href="{{ $p['url'] }}" target="_blank" class="px-3 py-2 rounded-xl bg-gray-900 hover:bg-gray-800 text-gray-300 hover:text-white font-bold text-xs border border-gray-800 transition inline-flex items-center gap-1">
                                <span>Preview &nearr;</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
