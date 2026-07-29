<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;

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
        $xml .= '<sitemap><loc>' . url('/sitemap-images.xml') . '</loc></sitemap>';
        $xml .= '<sitemap><loc>' . url('/sitemap-videos.xml') . '</loc></sitemap>';
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
            url('/about'),
            url('/promote-music'),
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
            url('/trending-songs'),
            url('/top-songs'),
            url('/most-viewed-songs'),
            url('/most-viewed-lyrics'),
            url('/recently-added'),
            url('/gospel'),
            url('/top-gospel-songs'),
            url('/top-secular-songs'),
            url('/love-songs'),
            url('/top-love-songs'),
            url('/traditional'),
            url('/wedding-songs'),
            url('/top-wedding-songs'),
            url('/worship'),
            url('/top-worship-songs'),
            url('/urban'),
            url('/top-urban-songs'),
            url('/top-collaborations'),
            url('/trending-artists'),
            url('/top-artists'),
            url('/artist-rankings'),
            url('/top-lyrics-today'),
            url('/most-searched-lyrics'),
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
            $xml .= '<url><loc>' . url('/artists/' . $artist->slug) . '</loc><lastmod>' . $artist->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            $xml .= '<url><loc>' . url('/artist/' . $artist->slug) . '</loc><lastmod>' . $artist->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
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
            $xml .= '<url><loc>' . $url . '</loc><lastmod>' . $song->updated_at->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function imagesSitemap()
    {
        $artists = Artist::all();
        $songs = Song::all();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        foreach ($artists as $artist) {
            $xml .= '<url><loc>' . url('/artists/' . $artist->slug) . '</loc>';
            $xml .= '<image:image><image:loc>' . htmlspecialchars($artist->avatar_url) . '</image:loc><image:title>' . htmlspecialchars($artist->name) . '</image:title></image:image>';
            $xml .= '</url>';
        }

        foreach ($songs as $song) {
            $xml .= '<url><loc>' . $song->seo_url . '</loc>';
            $xml .= '<image:image><image:loc>' . htmlspecialchars($song->cover_art_url) . '</image:loc><image:title>' . htmlspecialchars($song->title . ' Lyrics - ' . $song->display_artist_names) . '</image:title></image:image>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function videosSitemap()
    {
        $songs = Song::with('artist')->whereNotNull('youtube_url')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';

        foreach ($songs as $song) {
            if (!$song->youtube_embed_url) continue;
            $xml .= '<url><loc>' . $song->seo_url . '</loc>';
            $xml .= '<video:video>';
            $xml .= '<video:thumbnail_loc>' . htmlspecialchars($song->cover_art_url) . '</video:thumbnail_loc>';
            $xml .= '<video:title>' . htmlspecialchars($song->title . ' Official Video - ' . $song->artist->name) . '</video:title>';
            $xml .= '<video:description>' . htmlspecialchars('Watch official video and read complete Ekegusii lyrics for ' . $song->title . ' by ' . $song->artist->name) . '</video:description>';
            $xml .= '<video:player_loc>' . htmlspecialchars($song->youtube_embed_url) . '</video:player_loc>';
            $xml .= '</video:video>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function rssFeed()
    {
        $songs = Song::with('artist')->latest()->take(30)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
        $xml .= '<channel>';
        $xml .= '<title>Gusii Lyrics - Latest Ekegusii Song Lyrics</title>';
        $xml .= '<link>' . url('/') . '</link>';
        $xml .= '<description>Official Ekegusii song lyrics, translations, and stream links.</description>';
        $xml .= '<atom:link href="' . url('/rss.xml') . '" rel="self" type="application/rss+xml" />';

        foreach ($songs as $song) {
            $xml .= '<item>';
            $xml .= '<title>' . htmlspecialchars($song->title . ' Lyrics - ' . $song->display_artist_names) . '</title>';
            $xml .= '<link>' . $song->seo_url . '</link>';
            $xml .= '<guid>' . $song->seo_url . '</guid>';
            $xml .= '<pubDate>' . $song->created_at->toRssString() . '</pubDate>';
            $xml .= '<description>' . htmlspecialchars('Read full lyrics for ' . $song->title . ' by ' . $song->display_artist_names . ' on GusiiLyrics.') . '</description>';
            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function indexNowTxt()
    {
        $key = "gusiilyrics2026indexnowkey";
        return response($key, 200)->header('Content-Type', 'text/plain');
    }

    public function pingIndexNow(Request $request)
    {
        $key = "gusiilyrics2026indexnowkey";
        $urls = [
            url('/'),
            url('/songs'),
            url('/artists'),
        ];

        // Collect latest song URLs
        foreach (Song::latest()->take(10)->get() as $s) {
            $urls[] = $s->seo_url;
        }

        $payload = [
            'host' => 'gusiilyrics.com',
            'key' => $key,
            'keyLocation' => url('/' . $key . '.txt'),
            'urlList' => array_values(array_unique($urls)),
        ];

        return response()->json([
            'success' => true,
            'message' => 'IndexNow payload generated successfully.',
            'payload' => $payload,
        ]);
    }

    public function robots()
    {
        $sitemapUrl = url('/sitemap.xml');
        $rssUrl = url('/rss.xml');
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\nDisallow: /mkuu\n\nSitemap: {$sitemapUrl}\nSitemap: " . url('/sitemap-images.xml') . "\nSitemap: " . url('/sitemap-videos.xml') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
