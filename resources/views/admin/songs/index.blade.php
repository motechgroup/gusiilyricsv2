@extends('layouts.admin')

@section('title', 'Manage Lyrics - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Lyrics</h1>
            <p class="text-xs text-gray-400 mt-1">Create, edit, search, filter, and manage Ekegusii song lyrics.</p>
        </div>
        <a href="{{ route('admin.songs.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow">
            + Add New Song Lyric
        </a>
    </div>

    <!-- Search & Filter Form (Un-enclosed) -->
    <form method="GET" action="{{ route('admin.songs.index') }}" class="flex flex-col md:flex-row items-center gap-3">
        <!-- Search Keyword -->
        <div class="w-full md:flex-grow">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by song title, lyrics line, or artist..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white placeholder-gray-500 text-xs focus:outline-none focus:border-emerald-500">
        </div>

        <!-- Filter by Artist -->
        <div class="w-full md:w-48">
            <select name="artist_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-gray-300 text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Artists</option>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ request('artist_id') == $artist->id ? 'selected' : '' }}>
                        {{ $artist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter by Genre -->
        @if(isset($genres) && count($genres) > 0)
            <div class="w-full md:w-40">
                <select name="genre_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-gray-300 text-xs focus:outline-none focus:border-emerald-500">
                    <option value="">All Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Filter Status -->
        <div class="w-full md:w-40">
            <select name="filter" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-gray-300 text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Songs</option>
                <option value="featured" {{ request('filter') === 'featured' ? 'selected' : '' }}>Featured</option>
                <option value="trending" {{ request('filter') === 'trending' ? 'selected' : '' }}>Trending</option>
                <option value="promoted" {{ request('filter') === 'promoted' ? 'selected' : '' }}>Promoted</option>
            </select>
        </div>

        <button type="submit" class="w-full md:w-auto px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shrink-0">
            Filter
        </button>

        @if(request('q') || request('artist_id') || request('genre_id') || request('filter'))
            <a href="{{ route('admin.songs.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-semibold shrink-0">
                Reset
            </a>
        @endif
    </form>

    <!-- Table (Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Song Title</th>
                    <th class="p-4">Artist</th>
                    <th class="p-4">Flags & Promoted</th>
                    <th class="p-4">Streaming Links</th>
                    <th class="p-4">Views</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($songs as $song)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white">
                            <a href="{{ route('songs.show', $song->slug) }}" target="_blank" class="hover:text-emerald-400">
                                {{ $song->title }}
                            </a>
                        </td>

                        <td class="p-4 text-gray-300 font-semibold">
                            {{ $song->artist->name }}
                        </td>

                        <td class="p-4 space-x-1">
                            @if($song->is_promoted)
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono text-[10px] font-bold">🟢 PROMOTED</span>
                            @endif
                            @if($song->is_featured)
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono text-[10px]">Featured</span>
                            @endif
                            @if($song->is_trending)
                                <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 font-mono text-[10px]">Trending</span>
                            @endif
                        </td>

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
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 text-xs">
                            No song lyrics found matching your current filter or search criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($songs->hasPages())
        <div class="mt-6">
            {{ $songs->links() }}
        </div>
    @endif

</div>
@endsection
