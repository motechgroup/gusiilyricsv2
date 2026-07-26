<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_title',
        'artist_name',
        'genre',
        'lyrics',
        'english_translation',
        'swahili_translation',
        'submitter_name',
        'submitter_email',
        'status',
    ];
}
