<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_id',
        'ad_inquiry_id',
        'artist_name',
        'song_title',
        'email',
        'phone',
        'song_url',
        'package_type',
        'status',
        'budget_amount',
        'campaign_views',
        'campaign_clicks',
        'starts_at',
        'ends_at',
        'lyrics_text',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'budget_amount' => 'decimal:2',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function adInquiry()
    {
        return $this->belongsTo(AdInquiry::class);
    }

    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'active' => '🟢 Active Campaign',
            'completed' => '🏁 Completed',
            'paused' => '⏸️ Paused',
            'rejected' => '❌ Rejected',
            default => '⏳ Pending Review',
        };
    }
}
