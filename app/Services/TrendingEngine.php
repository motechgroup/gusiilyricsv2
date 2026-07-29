<?php

namespace App\Services;

use App\Models\Song;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class TrendingEngine
{
    /**
     * Get Trending Songs for Today using view count and recency decay.
     */
    public function getTrendingToday(int $limit = 10)
    {
        return Cache::remember("trending_songs_today_{$limit}", 300, function () use ($limit) {
            return Song::with(['artist', 'genre'])
                ->where('is_trending', true)
                ->orWhere('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('views_count', 'desc')
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get Trending Songs for This Week.
     */
    public function getTrendingThisWeek(int $limit = 10)
    {
        return Cache::remember("trending_songs_week_{$limit}", 600, function () use ($limit) {
            return Song::with(['artist', 'genre'])
                ->orderBy('views_count', 'desc')
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get Trending Songs for This Month.
     */
    public function getTrendingThisMonth(int $limit = 10)
    {
        return Cache::remember("trending_songs_month_{$limit}", 1800, function () use ($limit) {
            return Song::with(['artist', 'genre'])
                ->orderBy('views_count', 'desc')
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get Top 100 Songs of All Time.
     */
    public function getTop100Songs()
    {
        return Cache::remember('top_100_songs', 3600, function () {
            return Song::with(['artist', 'genre', 'album'])
                ->orderBy('views_count', 'desc')
                ->take(100)
                ->get();
        });
    }
}
