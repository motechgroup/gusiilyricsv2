@extends('layouts.admin')

@section('title', 'Manage Artists - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Gusii Artists</h1>
            <p class="text-xs text-gray-400 mt-1">Create and manage artist profiles.</p>
        </div>
        <a href="{{ route('admin.artists.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow">
            + Create New Artist
        </a>
    </div>

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

    <div class="mt-6">
        {{ $artists->links() }}
    </div>

</div>
@endsection
