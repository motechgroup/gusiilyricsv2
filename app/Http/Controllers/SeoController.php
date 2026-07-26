<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;

class SeoController extends Controller
{
    public function sitemap()
    {
        $songs = Song::select('slug', 'updated_at')->latest()->get();
        $artists = Artist::select('slug', 'updated_at')->latest()->get();

        $content = view('seo.sitemap', compact('songs', 'artists'))->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $sitemapUrl = url('/sitemap.xml');
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\n\nSitemap: {$sitemapUrl}\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
