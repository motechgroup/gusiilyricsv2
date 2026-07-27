@extends('layouts.admin')

@section('title', 'Create Artist - Admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Create Artist Profile</h1>
            <p class="text-xs text-gray-400 mt-1">Add a new Gusii artist profile, select region, upload profile picture, and add social links.</p>
        </div>
        <a href="{{ route('admin.artists.index') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Cancel & Back</a>
    </div>

    <form method="POST" action="{{ route('admin.artists.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Fenny Kerubo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">Artist Type / Category <span class="text-rose-500">*</span></label>
                <select name="type" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-amber-400 font-bold">
                    <option value="artist" {{ old('type', 'artist') === 'artist' ? 'selected' : '' }}>🎤 Artist</option>
                    <option value="band" {{ old('type') === 'band' ? 'selected' : '' }}>🎸 Band</option>
                    <option value="choir" {{ old('type') === 'choir' ? 'selected' : '' }}>🎼 Choir</option>
                    <option value="group" {{ old('type') === 'group' ? 'selected' : '' }}>👥 Music Group</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Select Region / County *</label>
                <select name="location" required class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    <option value="Kisii County, Kenya" {{ old('location') === 'Kisii County, Kenya' ? 'selected' : '' }}>Kisii County, Kenya</option>
                    <option value="Nyamira County, Kenya" {{ old('location') === 'Nyamira County, Kenya' ? 'selected' : '' }}>Nyamira County, Kenya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-purple-400 mb-1">Primary Music Genre</label>
                <select name="genre_id" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                    <option value="">Select Primary Genre (Optional)...</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->icon }} {{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Record Label / Affiliation</label>
                <input type="text" name="label" value="{{ old('label', 'Independent / Gusii Music') }}" placeholder="e.g. Still Alive Studios" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Active Years</label>
                <input type="text" name="active_years" value="{{ old('active_years', '2015 - Present') }}" placeholder="e.g. 2010 - Present" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            </div>
        </div>

        <!-- Upload Artist Profile Picture File -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Upload Profile Picture File *</label>
            <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30 bg-gray-950 border border-gray-800 rounded-xl p-2">
            <span class="text-[11px] text-gray-500 mt-1 block">Supported formats: JPG, PNG, WEBP (Max 5MB).</span>
        </div>

        <!-- Social Media Accounts Section -->
        <div class="pt-4 border-t border-gray-800 space-y-4">
            <h3 class="text-xs font-bold text-sky-400 uppercase tracking-wider">
                📱 Artist Social Media Profiles & Streaming Links
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-rose-400 mb-1">YouTube Channel URL</label>
                    <input type="url" name="youtube" value="{{ old('youtube') }}" placeholder="https://www.youtube.com/@artist..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-sky-400 mb-1">Facebook Page URL</label>
                    <input type="url" name="facebook" value="{{ old('facebook') }}" placeholder="https://facebook.com/artist..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-pink-400 mb-1">Instagram Profile URL</label>
                    <input type="url" name="instagram" value="{{ old('instagram') }}" placeholder="https://instagram.com/artist..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Spotify Artist URL</label>
                    <input type="url" name="spotify" value="{{ old('spotify') }}" placeholder="https://open.spotify.com/artist/..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-cyan-400 mb-1">TikTok Profile URL</label>
                    <input type="url" name="tiktok" value="{{ old('tiktok') }}" placeholder="https://tiktok.com/@artist..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Official Website URL</label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://artistwebsite.com" class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Biography</label>
            <textarea name="bio" rows="4" placeholder="Brief biography of the artist..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs leading-relaxed focus:outline-none focus:border-emerald-500">{{ old('bio') }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" class="accent-emerald-500 w-4 h-4 rounded">
            <span>Featured Artist on Homepage</span>
        </label>

        <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition shadow-lg">
            Create Artist Profile
        </button>
    </form>

</div>
@endsection
