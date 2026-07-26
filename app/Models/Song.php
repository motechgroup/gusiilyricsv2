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
        'description',
        'song_meaning',
        'song_credits',
        'language',
        'release_year',
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
        'is_promoted',
        'promoted_badge_text',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_promoted' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'release_year' => 'integer',
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

    public function promotions(): HasMany
    {
        return $this->hasMany(MusicPromotion::class);
    }

    public function getFormattedViewsAttribute(): string
    {
        $num = $this->views_count ?? 0;
        if ($num >= 1000000) {
            return round($num / 1000000, 1) . 'M';
        }
        if ($num >= 1000) {
            return round($num / 1000, 1) . 'K';
        }
        return (string) $num;
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(Correction::class);
    }

    public function getCoverArtUrlAttribute(): string
    {
        if ($this->cover_image) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }
            return asset(ltrim($this->cover_image, '/'));
        }

        if ($this->album && $this->album->cover_image) {
            if (str_starts_with($this->album->cover_image, 'http://') || str_starts_with($this->album->cover_image, 'https://')) {
                return $this->album->cover_image;
            }
            return asset(ltrim($this->album->cover_image, '/'));
        }

        if ($this->artist && $this->artist->image) {
            return $this->artist->avatar_url;
        }

        return 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&auto=format&fit=crop&q=80';
    }

    public function getSeoUrlAttribute(): string
    {
        if ($this->artist) {
            return url('/lyrics/' . $this->artist->slug . '/' . $this->slug);
        }
        return route('songs.show', $this->slug);
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
