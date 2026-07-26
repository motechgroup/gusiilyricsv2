<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'placement_spot',
        'type',
        'image_path',
        'target_url',
        'code_script',
        'is_active',
        'impressions_count',
        'clicks_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return asset($this->image_path);
        }
        return null;
    }

    public static function getAdForSpot(string $spot): ?self
    {
        $ad = static::where('placement_spot', $spot)
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        if ($ad) {
            $ad->increment('impressions_count');
        }

        return $ad;
    }
}
