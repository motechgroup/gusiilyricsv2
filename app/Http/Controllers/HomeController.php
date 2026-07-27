<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        $weeklyLatestSongs = Song::with(['artist', 'genre'])
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        if ($weeklyLatestSongs->count() < 3) {
            $weeklyLatestSongs = Song::with(['artist', 'genre'])
                ->latest()
                ->take(5)
                ->get();
        }

        $topCharts = Song::with(['artist', 'genre'])
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        $topBands = Artist::where('type', 'band')
            ->withCount('songs')
            ->withSum('songs', 'views_count')
            ->orderBy('songs_sum_views_count', 'desc')
            ->take(6)
            ->get();

        if ($topBands->isEmpty()) {
            $topBands = Artist::where('type', 'band')->latest()->take(6)->get();
        }

        $topChoirs = Artist::where('type', 'choir')
            ->withCount('songs')
            ->withSum('songs', 'views_count')
            ->orderBy('songs_sum_views_count', 'desc')
            ->take(6)
            ->get();

        if ($topChoirs->isEmpty()) {
            $topChoirs = Artist::where('type', 'choir')->latest()->take(6)->get();
        }

        $topBandSongs = Song::with(['artist', 'genre'])
            ->whereHas('artist', function ($q) {
                $q->where('type', 'band');
            })
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        $topChoirSongs = Song::with(['artist', 'genre'])
            ->whereHas('artist', function ($q) {
                $q->where('type', 'choir');
            })
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        Cache::forget('home_genres');
        $genres = Genre::withCount('songs')->get();

        $stats = Cache::remember('home_stats', 600, fn() => [
            'total_songs' => Song::count(),
            'total_artists' => Artist::count(),
            'total_genres' => Genre::count(),
            'total_views' => Song::sum('views_count'),
        ]);

        return view('home', compact(
            'featuredSongs',
            'trendingSongs',
            'featuredArtists',
            'recentSongs',
            'weeklyLatestSongs',
            'topCharts',
            'topBands',
            'topChoirs',
            'topBandSongs',
            'topChoirSongs',
            'genres',
            'stats'
        ));
    }
}
