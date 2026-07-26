@extends('layouts.admin')

@section('title', 'Lyric Corrections - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Visitor Lyric Corrections</h1>
            <p class="text-xs text-gray-400 mt-1">Review reported typos, missing verses, or translation fixes.</p>
        </div>
    </div>

    <!-- Corrections Table (Completely Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="py-3 px-4">Target Song</th>
                    <th class="py-3 px-4">Type</th>
                    <th class="py-3 px-4">Details</th>
                    <th class="py-3 px-4">Submitted By</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @forelse($corrections as $cor)
                    <tr class="hover:bg-gray-900/40 transition">
                        <td class="py-4 px-4 font-bold text-white">
                            @if($cor->song)
                                <a href="{{ route('songs.show', $cor->song->slug) }}" target="_blank" class="hover:text-emerald-400">
                                    {{ $cor->song->title }}
                                </a>
                            @else
                                <span class="text-gray-500">Deleted Song</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 font-mono text-emerald-400">{{ $cor->correction_type }}</td>
                        <td class="py-4 px-4 max-w-xs leading-relaxed font-mono">{{ $cor->details }}</td>
                        <td class="py-4 px-4 text-gray-400 font-mono">{{ $cor->visitor_name ?? 'Anonymous' }}</td>
                        <td class="py-4 px-4 text-right space-x-2">
                            <form method="POST" action="{{ route('admin.corrections.status', $cor->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="reviewed">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-semibold">
                                    Mark Reviewed
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 text-xs">
                            No lyric correction reports submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($corrections->hasPages())
        <div class="pt-4 border-t border-gray-800/80">
            {{ $corrections->links() }}
        </div>
    @endif

</div>
@endsection
