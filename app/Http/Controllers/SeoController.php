<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;

class SeoController extends Controller
{
    public function indexSitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= '<sitemap><loc>' . url('/sitemap-pages.xml') . '</loc></sitemap>';
        $xml .= '<sitemap><loc>' . url('/sitemap-categories.xml') . '</loc></sitemap>';
        $xml .= '<sitemap><loc>' . url('/sitemap-artists.xml') . '</loc></sitemap>';
        $xml .= '<sitemap><loc>' . url('/sitemap-albums.xml') . '</loc></sitemap>';
        $xml .= '<sitemap><loc>' . url('/sitemap-songs.xml') . '</loc></sitemap>';
        $xml .= '</sitemapindex>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function pagesSitemap()
    {
        $urls = [
            url('/'),
            url('/songs'),
            url('/artists'),
            url('/albums'),
            url('/genres'),
            url('/donate'),
            url('/terms'),
            url('/privacy'),
            url('/advertise'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . $url . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function categoriesSitemap()
    {
        $categoryUrls = [
            url('/top-gusii-songs'),
            url('/latest-songs'),
            url('/gospel'),
            url('/love-songs'),
            url('/traditional'),
            url('/wedding-songs'),
            url('/most-viewed-songs'),
            url('/trending-artists'),
        ];

        $genres = Genre::all();
        foreach ($genres as $genre) {
            $categoryUrls[] = url('/genres/' . $genre->slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($categoryUrls as $url) {
            $xml .= '<url><loc>' . $url . '</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function artistsSitemap()
    {
        $artists = Artist::select('slug', 'updated_at')->latest()->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($artists as $artist) {
            $xml .= '<url><loc>' . url('/artists/' . $artist->slug) . '</loc><lastmod>' . $artist->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function albumsSitemap()
    {
        $albums = Album::select('slug', 'updated_at')->latest()->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($albums as $album) {
            $xml .= '<url><loc>' . url('/albums/' . $album->slug) . '</loc><lastmod>' . $album->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function songsSitemap()
    {
        $songs = Song::with('artist')->select('slug', 'artist_id', 'updated_at')->latest()->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($songs as $song) {
            $url = $song->seo_url;
            $xml .= '<url><loc>' . $url . '</loc><lastmod>' . $song->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $sitemapUrl = url('/sitemap.xml');
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\nDisallow: /mkuu\n\nSitemap: {$sitemapUrl}\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
