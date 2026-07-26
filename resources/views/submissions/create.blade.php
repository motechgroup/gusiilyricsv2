@extends('layouts.app')

@section('title', 'Submit Ekegusii Song Lyrics - Gusii Lyrics')
@section('meta_description', 'Contribute Ekegusii lyrics and song info to the Gusii Lyrics library.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-10 text-center">
        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold uppercase tracking-wider">
            Community Heritage Contribution
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mt-3">
            Submit Ekegusii <span class="text-gradient-emerald">Song Lyrics</span>
        </h1>
        <p class="text-gray-400 text-sm mt-2 max-w-xl mx-auto">Help preserve Gusii language & culture by submitting lyrics and song details.</p>
    </div>

    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-emerald-500/20 shadow-2xl">
        <form method="POST" action="{{ route('submissions.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Song Title -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">
                        Song Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="song_title" required value="{{ old('song_title') }}" placeholder="e.g. Tara Yeso" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500 text-sm">
                </div>

                <!-- Artist Name -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">
                        Artist Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="artist_name" required value="{{ old('artist_name') }}" placeholder="e.g. Douglas Otiso" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500 text-sm">
                </div>
            </div>

            <!-- Genre -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">
                    Music Category / Genre
                </label>
                <input type="text" name="genre" value="{{ old('genre') }}" placeholder="e.g. Ekegusii Gospel, Benga, Traditional" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500 text-sm">
            </div>

            <!-- Ekegusii Lyrics RAW -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">
                    Ekegusii Song Lyrics <span class="text-rose-500">*</span>
                </label>
                <textarea name="lyrics" rows="10" required placeholder="Type or paste the full Ekegusii lyrics line by line..." class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500 text-sm leading-relaxed">{{ old('lyrics') }}</textarea>
            </div>

            <!-- Submitter Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-800">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Your Name</label>
                    <input type="text" name="submitter_name" value="{{ old('submitter_name') }}" placeholder="e.g. Kwamboka" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Your Email</label>
                    <input type="email" name="submitter_email" value="{{ old('submitter_email') }}" placeholder="e.g. kwamboka@example.com" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500 text-sm">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-slate-950 font-bold text-base shadow-xl shadow-emerald-500/25 transition active:scale-98">
                    Ebaora Mno! Submit Lyrics to Library
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
