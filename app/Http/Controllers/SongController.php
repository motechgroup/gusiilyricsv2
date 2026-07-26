<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with(['artist', 'genre', 'album']);

        if ($request->has('genre') && $request->genre) {
            $genre = Genre::where('slug', $request->genre)->first();
            if ($genre) {
                $query->where('genre_id', $genre->id);
            }
        }

        if ($request->has('q') && $request->q) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('lyrics_raw', 'like', $searchTerm)
                    ->orWhereHas('artist', function ($artQ) use ($searchTerm) {
                        $artQ->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Letter Filter A-Z or #
        if ($request->filled('letter')) {
            $letter = strtoupper($request->letter);
            if ($letter === '#') {
                $query->where(function ($q) {
                    for ($i = 0; $i <= 9; $i++) {
                        $q->orWhere('title', 'like', $i . '%');
                    }
                });
            } else {
                $query->where('title', 'like', $letter . '%');
            }
        }

        // Sorting
        $sort = $request->get('sort', 'asc');
        if ($sort === 'desc') {
            $query->orderBy('title', 'desc');
        } elseif ($sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } elseif ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('title', 'asc');
        }

        $songs = $query->paginate(12)->withQueryString();
        $genres = Genre::all();
        $selectedGenre = $request->genre;
        $selectedLetter = strtoupper($request->get('letter', ''));
        $selectedSort = $sort;

        return view('songs.index', compact('songs', 'genres', 'selectedGenre', 'selectedLetter', 'selectedSort'));
    }

    public function show($slug)
    {
        $song = Song::with(['artist', 'album', 'genre'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count quietly
        $song->increment('views_count');

        // Related songs by same artist or genre
        $relatedSongs = Song::with('artist')
            ->where('id', '!=', $song->id)
            ->where(function ($q) use ($song) {
                $q->where('artist_id', $song->artist_id)
                    ->orWhere('genre_id', $song->genre_id);
            })
            ->take(6)
            ->get();

        return view('songs.show', compact('song', 'relatedSongs'));
    }

    public function like($id)
    {
        $song = Song::findOrFail($id);
        $song->increment('likes_count');

        return response()->json([
            'success' => true,
            'likes_count' => $song->likes_count,
        ]);
    }

    public function searchApi(Request $request)
    {
        $term = $request->get('q');
        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $searchTerm = '%' . $term . '%';

        $songs = Song::with('artist')
            ->where('title', 'like', $searchTerm)
            ->orWhere('lyrics_raw', 'like', $searchTerm)
            ->orWhereHas('artist', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm);
            })
            ->take(8)
            ->get()
            ->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist->name,
                    'slug' => $song->slug,
                    'cover' => $song->cover_art_url,
                    'url' => route('songs.show', $song->slug),
                ];
            });

        return response()->json($songs);
    }
}
