@extends('layouts.admin')

@section('title', 'Manage Music Genres - Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Manage Music Genres</h1>
            <p class="text-xs text-gray-400 mt-1">Organize Ekegusii music categories, gospel praise, Obokano folk, and modern pop genres.</p>
        </div>
        <button onclick="document.getElementById('createGenreModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow transition flex items-center gap-2 self-start sm:self-auto">
            <span>+</span> Create New Genre
        </button>
    </div>

    <!-- Genres List Table (Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Icon & Genre Name</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Lyrics Count</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @forelse($genres as $genre)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-lg">
                                {{ $genre->icon ?: '🎵' }}
                            </span>
                            <div>
                                <span class="text-sm block">{{ $genre->name }}</span>
                                <span class="text-[10px] text-gray-500 font-mono">/lyrics?genre={{ $genre->slug }}</span>
                            </div>
                        </td>

                        <td class="p-4 text-gray-400 max-w-sm">
                            {{ $genre->description ?: 'No description added.' }}
                        </td>

                        <td class="p-4 font-mono font-bold text-emerald-400">
                            {{ $genre->songs_count }} Lyrics
                        </td>

                        <td class="p-4 text-right space-x-2">
                            <button onclick="openEditGenreModal({{ $genre->id }}, '{{ addslashes($genre->name) }}', '{{ addslashes($genre->icon) }}', '{{ addslashes($genre->description) }}')" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-emerald-400 font-semibold">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.genres.destroy', $genre->id) }}" class="inline" onsubmit="return confirm('Delete this genre? Associated songs will remain indexed.');">
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
                        <td colspan="4" class="p-8 text-center text-gray-500 text-xs">
                            No music genres found. Create one above!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Create Genre Modal -->
<div id="createGenreModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-purple-500/30 max-w-md w-full space-y-6">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <h3 class="text-base font-extrabold text-white">Create Music Genre</h3>
            <button onclick="document.getElementById('createGenreModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.genres.store') }}" class="space-y-4 text-xs">
            @csrf

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-gray-300 mb-1">Icon / Emoji</label>
                    <input type="text" name="icon" placeholder="🎵" value="🎵" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-center text-lg">
                </div>

                <div class="col-span-2">
                    <label class="block font-bold text-gray-300 mb-1">Genre Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Gospel & Praise" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" placeholder="Brief description of this genre..." class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('createGenreModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold">Create Genre &rarr;</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Genre Modal -->
<div id="editGenreModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/30 max-w-md w-full space-y-6">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <h3 class="text-base font-extrabold text-white">Edit Music Genre</h3>
            <button onclick="document.getElementById('editGenreModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
        </div>

        <form id="editGenreForm" method="POST" action="" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-gray-300 mb-1">Icon / Emoji</label>
                    <input type="text" id="edit_icon" name="icon" placeholder="🎵" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-center text-lg">
                </div>

                <div class="col-span-2">
                    <label class="block font-bold text-gray-300 mb-1">Genre Name *</label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Description</label>
                <textarea id="edit_description" name="description" rows="3" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('editGenreModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold">Update Genre &rarr;</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditGenreModal(id, name, icon, description) {
    const form = document.getElementById('editGenreForm');
    form.action = '/admin/genres/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_description').value = description;
    document.getElementById('editGenreModal').classList.remove('hidden');
}
</script>
@endsection
