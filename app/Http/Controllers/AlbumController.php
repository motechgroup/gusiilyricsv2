<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')
            ->withCount('songs')
            ->orderBy('release_year', 'desc')
            ->orderBy('title', 'asc')
            ->paginate(12);

        return view('albums.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = Album::with(['artist', 'songs.artist'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('albums.show', compact('album'));
    }
}
