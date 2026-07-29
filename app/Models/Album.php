<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'title',
        'slug',
        'cover_image',
        'release_year',
        'description',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function getCoverArtUrlAttribute(): string
    {
        $siteLogo = Setting::get('site_logo', '/images/logo.png');
        $fallbackUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset(ltrim($siteLogo, '/'));

        if ($this->cover_image) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }
            $clean = ltrim($this->cover_image, '/');
            if (file_exists(public_path($clean))) {
                return asset($clean);
            }
        }

        if ($this->artist && !empty($this->artist->image)) {
            return $this->artist->avatar_url;
        }

        return $fallbackUrl;
    }
}
