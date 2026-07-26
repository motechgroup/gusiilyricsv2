@extends('layouts.admin')

@section('title', 'Manage Lyrics - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Lyrics</h1>
            <p class="text-xs text-gray-400 mt-1">Create, edit, and update Ekegusii song lyrics.</p>
        </div>
        <a href="{{ route('admin.songs.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow">
            + Add New Song Lyric
        </a>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden border border-gray-800">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Song Title</th>
                    <th class="p-4">Artist</th>
                    <th class="p-4">Streaming Links</th>
                    <th class="p-4">Views</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($songs as $song)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white">
                            <a href="{{ route('songs.show', $song->slug) }}" target="_blank" class="hover:text-emerald-400">
                                {{ $song->title }}
                            </a>
                        </td>
                        <td class="p-4 text-gray-300">{{ $song->artist->name }}</td>
                        <td class="p-4 space-x-1">
                            @if($song->spotify_url)<span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-mono text-[10px]">Spotify</span>@endif
                            @if($song->youtube_url)<span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-mono text-[10px]">YouTube</span>@endif
                        </td>
                        <td class="p-4 font-mono">{{ number_format($song->views_count) }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.songs.edit', $song->id) }}" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-emerald-400 font-semibold">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.songs.destroy', $song->id) }}" class="inline" onsubmit="return confirm('Delete this song lyric permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $songs->links() }}
    </div>

</div>
@endsection
