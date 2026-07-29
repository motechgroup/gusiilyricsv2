@extends('layouts.admin')

@section('title', 'Manage Artists - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Gusii Artists</h1>
            <p class="text-xs text-gray-400 mt-1">Create and manage artist profiles.</p>
        </div>
        <a href="{{ route('admin.artists.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow shrink-0">
            + Create New Artist
        </a>
    </div>

    <!-- Search & Category Filter Bar -->
    <form method="GET" action="{{ route('admin.artists.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-grow">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search artist name, location, label..." class="w-full pl-10 pr-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
        </div>

        <select name="type" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            <option value="">All Categories</option>
            <option value="artist" {{ request('type') === 'artist' ? 'selected' : '' }}>🎤 Solo Artist</option>
            <option value="band" {{ request('type') === 'band' ? 'selected' : '' }}>🎸 Music Band</option>
            <option value="choir" {{ request('type') === 'choir' ? 'selected' : '' }}>🎼 Gospel Choir</option>
            <option value="group" {{ request('type') === 'group' ? 'selected' : '' }}>👥 Music Group</option>
        </select>

        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition shrink-0">
            Search
        </button>

        @if(request('q') || request('type'))
            <a href="{{ route('admin.artists.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold text-xs transition flex items-center justify-center shrink-0">
                Reset
            </a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Artist Name</th>
                    <th class="p-4">Category / Type</th>
                    <th class="p-4">Location</th>
                    <th class="p-4">Total Lyrics</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($artists as $artist)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white flex items-center gap-3">
                            <img src="{{ $artist->avatar_url }}" class="w-9 h-9 rounded-full object-cover border border-gray-700">
                            <span>{{ $artist->name }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold font-mono text-[11px]">
                                {{ $artist->type_badge }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-400 font-mono">{{ $artist->location }}</td>
                        <td class="p-4 font-mono">{{ $artist->songs_count }} Lyrics</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.artists.edit', $artist->id) }}" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-emerald-400 font-semibold">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.artists.destroy', $artist->id) }}" class="inline" onsubmit="return confirm('Delete artist and their songs?');">
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

    @if($artists->hasPages())
        <div class="mt-6">
            {{ $artists->links() }}
        </div>
    @endif

</div>
@endsection
