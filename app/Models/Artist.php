<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'location',
        'origin',
        'active_years',
        'label',
        'website',
        'facebook',
        'instagram',
        'youtube',
        'spotify',
        'tiktok',
        'twitter',
        'bio',
        'image',
        'genre_id',
        'is_featured',
        'followers_count',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'band' => 'Music Band',
            'choir' => 'Gospel Choir',
            'group' => 'Music Group',
            default => 'Artist',
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'band' => '🎸 Band',
            'choir' => '🎼 Choir',
            'group' => '👥 Group',
            default => '🎤 Artist',
        };
    }

    protected $casts = [
        'is_featured' => 'boolean',
        'followers_count' => 'integer',
    ];

    public function genre(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function songsAsCollaborator(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Song::class)->withTimestamps();
    }

    public function getTotalSongsCountAttribute(): int
    {
        if (isset($this->attributes['songs_count']) && isset($this->attributes['songs_as_collaborator_count'])) {
            return (int) $this->attributes['songs_count'] + (int) $this->attributes['songs_as_collaborator_count'];
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('artist_song')) {
                return Song::where('artist_id', $this->id)
                    ->orWhereHas('artists', function ($q) {
                        $q->where('artists.id', $this->id);
                    })->count();
            }
        } catch (\Throwable $e) {}

        return $this->songs()->count();
    }

    public function getSongsCountAttribute()
    {
        if (array_key_exists('songs_count', $this->attributes)) {
            $count = (int) $this->attributes['songs_count'];
            if (array_key_exists('songs_as_collaborator_count', $this->attributes)) {
                $count += (int) $this->attributes['songs_as_collaborator_count'];
            }
            return $count;
        }

        return $this->total_songs_count;
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        $siteLogo = Setting::get('site_logo', '/images/logo.png');
        $fallbackUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset(ltrim($siteLogo, '/'));

        if (empty($this->image)) {
            return $fallbackUrl;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        $clean = ltrim($this->image, '/');

        // Direct public file check
        if (file_exists(public_path($clean))) {
            return asset($clean);
        }

        // Handle /storage/ relative paths
        if (str_starts_with($this->image, '/storage/') || str_starts_with($this->image, 'storage/')) {
            $relative = preg_replace('#^/?storage/#', '', $this->image);
            if (file_exists(public_path($relative))) {
                return asset($relative);
            }
            if (file_exists(public_path('uploads/' . $relative))) {
                return asset('uploads/' . $relative);
            }
            if (file_exists(public_path('storage/' . $relative))) {
                return asset('storage/' . $relative);
            }
        }

        return $fallbackUrl;
    }

    public function getFormattedFollowersAttribute(): string
    {
        $count = $this->followers_count ?? 0;
        if ($count >= 1000000) {
            return round($count / 1000000, 1) . 'M';
        }
        if ($count >= 1000) {
            return round($count / 1000, 1) . 'K';
        }
        return (string) $count;
    }

    public function isFollowedByVisitor(?string $ipAddress = null, ?string $visitorToken = null): bool
    {
        $ip = $ipAddress ?: request()->ip();
        $token = $visitorToken ?: request()->cookie('visitor_token');

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('artist_followers')) {
                return \Illuminate\Support\Facades\DB::table('artist_followers')
                    ->where('artist_id', $this->id)
                    ->where(function ($q) use ($ip, $token) {
                        $q->where('ip_address', $ip);
                        if ($token) {
                            $q->orWhere('visitor_token', $token);
                        }
                    })->exists();
            }
        } catch (\Throwable $e) {
            // Graceful fallback
        }

        return false;
    }
}
