@extends('layouts.admin')

@section('title', 'Manage Site Ad Banners & Spots - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">🖼️ Site Ad Banners & Placement Spots</h1>
            <p class="text-xs text-gray-400 mt-1">Manage active ad campaigns, banners, and Google AdSense scripts across header, lyrics pages, and footer.</p>
        </div>
        <div>
            <a href="{{ route('admin.ads.create') }}" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition flex items-center gap-1.5 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Create New Ad Campaign</span>
            </a>
        </div>
    </div>

    <!-- Ads Table (Completely Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 uppercase tracking-wider text-[10px] border-b border-gray-800">
                <tr>
                    <th class="py-3 px-4">Ad Title & Type</th>
                    <th class="py-3 px-4">Placement Spot</th>
                    <th class="py-3 px-4">Preview</th>
                    <th class="py-3 px-4">Impressions</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @forelse($ads as $ad)
                    <tr class="hover:bg-gray-900/40 transition">
                        <td class="py-4 px-4 font-medium text-white">
                            <strong class="block text-sm text-white">{{ $ad->title }}</strong>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono uppercase {{ $ad->type === 'image' ? 'bg-indigo-500/20 text-indigo-300' : 'bg-amber-500/20 text-amber-300' }}">
                                {{ strtoupper($ad->type) }} AD
                            </span>
                        </td>

                        <td class="py-4 px-4 font-bold text-emerald-400 uppercase text-[10px]">
                            {{ str_replace('_', ' ', $ad->placement_spot) }}
                        </td>

                        <td class="py-4 px-4">
                            @if($ad->type === 'image' && $ad->image_path)
                                <a href="{{ $ad->image_url }}" target="_blank">
                                    <img src="{{ $ad->image_url }}" class="h-10 w-24 object-cover rounded border border-gray-800 hover:scale-105 transition">
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 font-mono italic">HTML/Script Code</span>
                            @endif
                        </td>

                        <td class="py-4 px-4 font-mono text-gray-300">
                            {{ number_format($ad->impressions_count) }} views
                        </td>

                        <td class="py-4 px-4">
                            <form method="POST" action="{{ route('admin.ads.toggle', $ad->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase transition {{ $ad->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                                    {{ $ad->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>

                        <td class="py-4 px-4 text-right space-x-2">
                            <a href="{{ route('admin.ads.edit', $ad->id) }}" class="px-2.5 py-1 rounded-lg bg-gray-800 text-gray-300 hover:text-white text-[10px] font-bold">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.ads.destroy', $ad->id) }}" class="inline" onsubmit="return confirm('Delete this ad campaign?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 text-[10px] font-bold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 text-xs">
                            No active ad campaigns created yet. Click "Create New Ad Campaign" above to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($ads->hasPages())
        <div class="pt-4 border-t border-gray-800/80">
            {{ $ads->links() }}
        </div>
    @endif

</div>
@endsection
