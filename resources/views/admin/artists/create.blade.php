@extends('layouts.admin')

@section('title', 'Create Artist - Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <h1 class="text-2xl font-extrabold text-white">Create Artist Profile</h1>
        <a href="{{ route('admin.artists.index') }}" class="text-xs text-gray-400 hover:text-emerald-400">&larr; Cancel & Back</a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-6">
        <form method="POST" action="{{ route('admin.artists.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Artist Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Fenny Kerubo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Location / Origin</label>
                <input type="text" name="location" value="Kisii, Kenya" placeholder="e.g. Kisii, Kenya" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <!-- Upload Artist Profile Picture File or Paste URL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">Upload Profile Picture File</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">OR Paste Image URL</label>
                    <input type="url" name="image" value="{{ old('image') }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Biography</label>
                <textarea name="bio" rows="4" placeholder="Brief biography of the artist..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs leading-relaxed focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <label class="flex items-center gap-2 text-xs font-semibold text-gray-300 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" class="accent-emerald-500 w-4 h-4 rounded">
                <span>Featured Artist on Homepage</span>
            </label>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition">
                Create Artist Profile
            </button>
        </form>
    </div>

</div>
@endsection
