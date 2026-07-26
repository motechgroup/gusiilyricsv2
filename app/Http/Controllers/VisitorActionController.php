<?php

namespace App\Http\Controllers;

use App\Models\Correction;
use App\Models\LyricRequest;
use Illuminate\Http\Request;

class VisitorActionController extends Controller
{
    public function requestLyric(Request $request)
    {
        $validated = $request->validate([
            'song_title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
        ]);

        LyricRequest::create($validated);

        return redirect()->back()->with('success', 'Ebaora! Your lyric request has been received. Our team will add it soon.');
    }

    public function submitCorrection(Request $request)
    {
        $validated = $request->validate([
            'song_id' => 'required|exists:songs,id',
            'visitor_name' => 'nullable|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'correction_type' => 'required|string',
            'details' => 'required|string|min:10',
        ]);

        Correction::create($validated);

        return redirect()->back()->with('success', 'Thank you! Your lyric correction report has been submitted for review.');
    }
}
