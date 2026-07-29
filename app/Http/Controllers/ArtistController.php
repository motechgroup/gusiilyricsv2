<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::withCount(['songs', 'songsAsCollaborator']);

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

        // Artist Type Filter (artist, band, choir, group)
        $selectedType = $request->get('type', '');
        if ($selectedType && in_array($selectedType, ['artist', 'band', 'choir', 'group'])) {
            $query->where('type', $selectedType);
        }

        // Sorting (Default to popular/traffic ranking)
        $sort = $request->get('sort', 'traffic');
        if ($sort === 'followers') {
            $query->orderBy('followers_count', 'desc');
        } elseif ($sort === 'traffic' || $sort === 'popular') {
            $query->withSum('songs', 'views_count')
                ->orderBy('songs_sum_views_count', 'desc')
                ->orderBy('songs_count', 'desc');
        } elseif ($sort === 'desc') {
            $query->orderBy('name', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $artists = $query->paginate(24)->withQueryString();
        $selectedLetter = strtoupper($request->get('letter', ''));
        $selectedSort = $sort;

        return view('artists.index', compact('artists', 'selectedLetter', 'selectedSort', 'selectedType'));
    }

    public function show($slug)
    {
        $artist = Artist::with(['albums.songs'])
            ->where('slug', $slug)
            ->first();

        if (!$artist) {
            $cleanSlug = preg_replace('/-[a-zA-Z0-9]{4,5}$/', '', $slug);
            $artist = Artist::where('slug', $cleanSlug)->first();

            if (!$artist) {
                $artist = Artist::where('slug', 'like', $cleanSlug . '%')->firstOrFail();
            }

            return redirect()->route('artists.show', $artist->slug, [], 301);
        }

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

    public function follow(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $ip = $request->ip();

        $visitorToken = $request->cookie('visitor_token');
        if (!$visitorToken) {
            $visitorToken = \Illuminate\Support\Str::uuid()->toString();
            cookie()->queue('visitor_token', $visitorToken, 525600);
        }

        $isFollowing = false;
        $message = '';

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('artist_followers')) {
                $existing = \Illuminate\Support\Facades\DB::table('artist_followers')
                    ->where('artist_id', $artist->id)
                    ->where(function ($q) use ($ip, $visitorToken) {
                        $q->where('ip_address', $ip);
                        if ($visitorToken) {
                            $q->orWhere('visitor_token', $visitorToken);
                        }
                    })->first();

                if ($existing) {
                    \Illuminate\Support\Facades\DB::table('artist_followers')->where('id', $existing->id)->delete();
                    $artist->decrement('followers_count');
                    $isFollowing = false;
                    $message = 'You unfollowed ' . $artist->name;
                } else {
                    \Illuminate\Support\Facades\DB::table('artist_followers')->insert([
                        'artist_id' => $artist->id,
                        'ip_address' => $ip,
                        'visitor_token' => $visitorToken,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $artist->increment('followers_count');
                    $isFollowing = true;
                    $message = 'You are now following ' . $artist->name . '! 🎉';
                }
            } else {
                $artist->increment('followers_count');
                $isFollowing = true;
                $message = 'You are now following ' . $artist->name . '! 🎉';
            }
        } catch (\Throwable $e) {
            $artist->increment('followers_count');
            $isFollowing = true;
            $message = 'Thank you for following ' . $artist->name;
        }

        $freshCount = max(0, $artist->fresh()->followers_count);
        $formattedCount = $artist->fresh()->formatted_followers;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_following' => $isFollowing,
                'followers_count' => $freshCount,
                'formatted_followers' => $formattedCount,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
