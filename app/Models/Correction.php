<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Correction extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_id',
        'visitor_name',
        'visitor_email',
        'correction_type',
        'details',
        'status',
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}
