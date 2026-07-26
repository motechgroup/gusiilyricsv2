@extends('layouts.admin')

@section('title', 'Edit Song Lyrics - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <h1 class="text-2xl font-extrabold text-white">Edit Song Lyrics: {{ $song->title }}</h1>
        <a href="{{ route('admin.songs.index') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Cancel & Back</a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.songs.update', $song->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $song->title) }}" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist <span class="text-rose-500">*</span></label>
                    <select name="artist_id" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ $song->artist_id == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Upload Cover File -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Upload New Song Cover Artwork File</label>
                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                @if($song->cover_image)
                    <div class="mt-2 flex items-center gap-3">
                        <span class="text-xs text-gray-400">Current Artwork:</span>
                        <img src="{{ $song->cover_art_url }}" class="w-10 h-10 rounded-lg object-cover border border-emerald-500/30">
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Spotify URL</label>
                    <input type="url" name="spotify_url" value="{{ old('spotify_url', $song->spotify_url) }}" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-rose-400 mb-1">YouTube Video URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $song->youtube_url) }}" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-pink-400 mb-1">Apple Music URL</label>
                    <input type="url" name="apple_music_url" value="{{ old('apple_music_url', $song->apple_music_url) }}" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Song Lyrics <span class="text-rose-500">*</span></label>
                <textarea name="lyrics_raw" rows="12" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm leading-relaxed focus:outline-none focus:border-emerald-500">{{ old('lyrics_raw', $song->lyrics_raw) }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ $song->is_featured ? 'checked' : '' }} class="accent-emerald-500 w-4 h-4 rounded">
                    <span>Feature on Homepage</span>
                </label>
                <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
                    <input type="checkbox" name="is_trending" value="1" {{ $song->is_trending ? 'checked' : '' }} class="accent-emerald-500 w-4 h-4 rounded">
                    <span>Mark as Trending</span>
                </label>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Update Song Lyrics
            </button>
        </form>
    </div>

</div>
@endsection
