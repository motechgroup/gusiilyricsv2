@extends('layouts.admin')

@section('title', 'Add New Song Lyric - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <h1 class="text-2xl font-extrabold text-white">Add New Song Lyrics</h1>
        <a href="{{ route('admin.songs.index') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Cancel & Back</a>
    </div>

    <form method="POST" action="{{ route('admin.songs.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Title <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Nore pipo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist <span class="text-rose-500">*</span></label>
                <select name="artist_id" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="">Select Artist...</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-purple-400 mb-1">Music Genre / Category</label>
                <select name="genre_id" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="">Select Genre (Optional)...</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->icon }} {{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Collaborating Artists (Multi-Select) -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">
                Collaborating / Featured Artists (Optional - Multi-Select)
            </label>
            <p class="text-[11px] text-gray-400 mb-2">Select any featured or collaborating artists. This lyric will automatically show under all selected artists' profiles.</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 max-h-40 overflow-y-auto p-3 bg-gray-950 rounded-xl border border-gray-800">
                @foreach($artists as $artist)
                    <label class="flex items-center gap-2 text-xs text-gray-300 hover:text-white cursor-pointer select-none">
                        <input type="checkbox" name="collaborator_ids[]" value="{{ $artist->id }}" class="w-4 h-4 rounded bg-gray-900 border-gray-700 text-emerald-500 focus:ring-0">
                        <span>{{ $artist->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Upload Cover File -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Upload Song Cover Artwork File</label>
            <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Spotify URL</label>
                <input type="url" name="spotify_url" placeholder="https://open.spotify.com/track/..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-rose-400 mb-1">YouTube Video URL</label>
                <input type="url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-pink-400 mb-1">Apple Music URL</label>
                <input type="url" name="apple_music_url" placeholder="https://music.apple.com/..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
            </div>
        </div>

        <!-- Interactive Song Structure Lyrics Blocks Builder -->
        @include('admin.songs._lyrics_builder')

        <div class="flex items-center gap-6 pt-2">
            <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" class="accent-emerald-500 w-4 h-4 rounded">
                <span>Feature on Homepage</span>
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
                <input type="checkbox" name="is_trending" value="1" class="accent-emerald-500 w-4 h-4 rounded">
                <span>Mark as Trending</span>
            </label>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
            Save & Publish Lyrics
        </button>
    </form>

</div>
@endsection
