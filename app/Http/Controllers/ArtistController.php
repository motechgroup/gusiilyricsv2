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
        $artist = Artist::with(['songs' => function ($q) {
            $q->orderBy('views_count', 'desc');
        }, 'albums.songs'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('artists.show', compact('artist'));
    }
}
