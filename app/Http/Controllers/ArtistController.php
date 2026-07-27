<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::withCount('songs');

        if ($request->has('q') && $request->q) {
            $searchTerm = '%' . $request->q . '%';
            $query->where('name', 'like', $searchTerm);
        }

        // Letter Filter A-Z or #
        if ($request->filled('letter')) {
            $letter = strtoupper($request->letter);
            if ($letter === '#') {
                $query->where(function ($q) {
                    for ($i = 0; $i <= 9; $i++) {
                        $q->orWhere('name', 'like', $i . '%');
                    }
                });
            } else {
                $query->where('name', 'like', $letter . '%');
            }
        }

        // Sorting
        $sort = $request->get('sort', 'asc');
        if ($sort === 'desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'popular') {
            $query->orderBy('songs_count', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $artists = $query->paginate(15)->withQueryString();
        $selectedLetter = strtoupper($request->get('letter', ''));
        $selectedSort = $sort;

        return view('artists.index', compact('artists', 'selectedLetter', 'selectedSort'));
    }

    public function show($slug)
    {
        $artist = Artist::with(['albums.songs'])
            ->where('slug', $slug)
            ->firstOrFail();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('artist_song')) {
                $allSongs = Song::with(['artist', 'artists', 'genre'])
                    ->where(function ($query) use ($artist) {
                        $query->where('artist_id', $artist->id)
                            ->orWhereHas('artists', function ($q) use ($artist) {
                                $q->where('artists.id', $artist->id);
                            });
                    })
                    ->orderBy('views_count', 'desc')
                    ->get();
            } else {
                $allSongs = Song::with(['artist', 'genre'])
                    ->where('artist_id', $artist->id)
                    ->orderBy('views_count', 'desc')
                    ->get();
            }
        } catch (\Throwable $e) {
            $allSongs = Song::with(['artist', 'genre'])
                ->where('artist_id', $artist->id)
                ->orderBy('views_count', 'desc')
                ->get();
        }

        return view('artists.show', compact('artist', 'allSongs'));
    }
}
