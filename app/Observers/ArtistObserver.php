<?php

namespace App\Observers;

use App\Models\Artist;
use Illuminate\Support\Facades\Cache;

class ArtistObserver
{
    public function created(Artist $artist): void
    {
        $this->clearSeoCache();
    }

    public function updated(Artist $artist): void
    {
        $this->clearSeoCache();
    }

    public function deleted(Artist $artist): void
    {
        $this->clearSeoCache();
    }

    protected function clearSeoCache(): void
    {
        Cache::forget('trending_artists');
    }
}
