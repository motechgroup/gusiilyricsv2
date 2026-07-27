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
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function songsAsCollaborator(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Song::class)->withTimestamps();
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80';
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

        return asset($clean);
    }
}
