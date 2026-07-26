<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function create()
    {
        return view('submissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'song_title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'lyrics' => 'required|string|min:20',
            'english_translation' => 'nullable|string',
            'swahili_translation' => 'nullable|string',
            'submitter_name' => 'nullable|string|max:255',
            'submitter_email' => 'nullable|email|max:255',
        ]);

        Submission::create($validated);

        return redirect()->back()->with('success', 'Ebaora mno! Thank you for contributing lyrics to the Gusii community. Your submission has been received and is under review.');
    }
}
