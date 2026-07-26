<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featuredSongs = Song::with(['artist', 'genre'])
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $trendingSongs = Song::with(['artist', 'genre'])
            ->orderBy('views_count', 'desc')
            ->take(8)
            ->get();

        $featuredArtists = Artist::where('is_featured', true)
            ->withCount('songs')
            ->take(6)
            ->get();

        $recentSongs = Song::with(['artist', 'genre'])
            ->latest()
            ->take(8)
            ->get();

        $genres = Genre::withCount('songs')->get();

        $stats = [
            'total_songs' => Song::count(),
            'total_artists' => Artist::count(),
            'total_genres' => Genre::count(),
            'total_views' => Song::sum('views_count'),
        ];

        return view('home', compact(
            'featuredSongs',
            'trendingSongs',
            'featuredArtists',
            'recentSongs',
            'genres',
            'stats'
        ));
    }
}
