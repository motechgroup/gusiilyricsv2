<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'album_id',
        'genre_id',
        'title',
        'slug',
        'lyrics_raw',
        'english_translation',
        'swahili_translation',
        'spotify_url',
        'apple_music_url',
        'youtube_url',
        'audio_url',
        'cover_image',
        'views_count',
        'likes_count',
        'is_featured',
        'is_trending',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(Correction::class);
    }

    public function getCoverArtUrlAttribute(): string
    {
        if ($this->cover_image) {
            return $this->cover_image;
        }

        if ($this->album && $this->album->cover_image) {
            return $this->album->cover_image;
        }

        if ($this->artist && $this->artist->image) {
            return $this->artist->image;
        }

        return 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&auto=format&fit=crop&q=80';
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_url) return null;

        // Parse YouTube video ID
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        if (isset($matches[1])) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return null;
    }
}
