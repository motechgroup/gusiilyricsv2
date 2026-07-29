<?php

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clean Artist Slugs
        $artists = Artist::all();
        foreach ($artists as $artist) {
            $baseSlug = Str::slug($artist->name);
            if (empty($baseSlug)) {
                continue;
            }

            $slug = $baseSlug;
            $counter = 1;
            while (Artist::where('slug', $slug)->where('id', '!=', $artist->id)->exists()) {
                $counter++;
                $slug = $baseSlug . '-' . $counter;
            }

            if ($artist->slug !== $slug) {
                $artist->update(['slug' => $slug]);
            }
        }

        // Clean Song Slugs
        $songs = Song::all();
        foreach ($songs as $song) {
            $baseSlug = Str::slug($song->title);
            if (empty($baseSlug)) {
                continue;
            }

            $slug = $baseSlug;
            $counter = 1;
            while (Song::where('slug', $slug)->where('id', '!=', $song->id)->exists()) {
                $counter++;
                $slug = $baseSlug . '-' . $counter;
            }

            if ($song->slug !== $slug) {
                $song->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed for rollback
    }
};
