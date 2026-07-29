<?php

namespace App\Observers;

use App\Models\Song;
use Illuminate\Support\Facades\Cache;

class SongObserver
{
    public function created(Song $song): void
    {
        $this->clearSeoCache();
    }

    public function updated(Song $song): void
    {
        $this->clearSeoCache();
    }

    public function deleted(Song $song): void
    {
        $this->clearSeoCache();
    }

    protected function clearSeoCache(): void
    {
        Cache::forget('trending_songs_today_10');
        Cache::forget('trending_songs_week_10');
        Cache::forget('trending_songs_month_10');
        Cache::forget('top_100_songs');
    }
}
