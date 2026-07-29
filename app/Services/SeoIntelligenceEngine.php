<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use App\Models\Album;
use Illuminate\Support\Str;

class SeoIntelligenceEngine
{
    /**
     * Generate complete SEO metadata payload for a Song model.
     */
    public function generateSongSeoData(Song $song): array
    {
        $artistName = $song->display_artist_names;
        $title = $song->title;
        $genreName = $song->genre ? $song->genre->name : 'Ekegusii Music';
        $albumTitle = $song->album ? $song->album->title : '';

        // 1. Optimized Title (55-60 chars target)
        $seoTitle = "{$title} Lyrics – {$artistName} | GusiiLyrics";
        if (mb_strlen($seoTitle) > 60) {
            $seoTitle = mb_substr($seoTitle, 0, 57) . '...';
        }

        // 2. Optimized Meta Description (140-160 chars target)
        $metaDescription = "Read the complete lyrics of {$title} by {$artistName}. Discover related songs, album credits, English translations, and trending Ekegusii music on GusiiLyrics.";
        if (mb_strlen($metaDescription) > 160) {
            $metaDescription = mb_substr($metaDescription, 0, 157) . '...';
        }

        // 3. Focus and Long-Tail Keywords
        $keywords = [
            $title,
            "{$title} Lyrics",
            "{$title} by {$artistName}",
            "{$artistName} Lyrics",
            "{$artistName} Songs",
            "Latest {$artistName} Songs",
            "New {$artistName} Song",
            "{$title} Translation",
            "{$title} Meaning",
            "{$title} Download",
            "Ekegusii Lyrics",
            "Kisii Song Lyrics",
            "Gusii Gospel Lyrics",
            "Kenyan Vernacular Lyrics",
            "African Lyrics",
            "Trending Kisii Songs"
        ];

        // 4. Image ALT & Title Metadata
        $imageAlt = "Official Cover Art and Lyrics for {$title} by {$artistName}";
        $imageTitle = "{$title} - {$artistName} GusiiLyrics";
        $imageCaption = "Album cover art for {$title} performed by {$artistName}";

        // 5. FAQs Generator
        $faqs = $this->generateFaqsForSong($song);

        // 6. JSON-LD Structured Data
        $schemas = $this->generateSongJsonLd($song, $faqs);

        // 7. Open Graph & Twitter Cards
        $social = [
            'og_title' => $seoTitle,
            'og_description' => $metaDescription,
            'og_url' => $song->seo_url,
            'og_type' => 'music.song',
            'og_image' => $song->cover_art_url,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $seoTitle,
            'twitter_description' => $metaDescription,
            'twitter_image' => $song->cover_art_url,
        ];

        // 8. Dynamic Breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Lyrics', 'url' => route('songs.index')],
            ['name' => $artistName, 'url' => route('artists.show', $song->artist ? $song->artist->slug : 'artist')],
            ['name' => $title, 'url' => $song->seo_url],
        ];

        return [
            'title' => $seoTitle,
            'meta_description' => $metaDescription,
            'canonical_url' => $song->seo_url,
            'keywords' => implode(', ', array_unique($keywords)),
            'focus_keyword' => "{$title} Lyrics",
            'image_alt' => $imageAlt,
            'image_title' => $imageTitle,
            'image_caption' => $imageCaption,
            'social' => $social,
            'faqs' => $faqs,
            'schemas' => $schemas,
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    /**
     * Generate complete SEO metadata payload for an Artist model.
     */
    public function generateArtistSeoData(Artist $artist): array
    {
        $name = $artist->name;
        $location = $artist->location ?: 'Kisii, Kenya';

        // 1. Title & Meta Description
        $seoTitle = "{$name} Songs, Lyrics, Albums, Videos & Biography | GusiiLyrics";
        if (mb_strlen($seoTitle) > 60) {
            $seoTitle = mb_substr($seoTitle, 0, 57) . '...';
        }

        $metaDescription = "Read all {$name} song lyrics, latest songs, albums, videos, collaborations, biography and trending music only on GusiiLyrics.com.";
        if (mb_strlen($metaDescription) > 160) {
            $metaDescription = mb_substr($metaDescription, 0, 157) . '...';
        }

        // 2. Keywords
        $keywords = [
            $name,
            "{$name} Lyrics",
            "{$name} Songs",
            "Latest {$name} Songs",
            "New {$name} Music",
            "{$name} Album",
            "{$name} Videos",
            "{$name} Biography",
            "Best {$name} Songs",
            "Trending {$name} Songs",
            "Popular {$name} Songs",
            "{$name} mp3",
            "{$name} lyrics download",
            "Kisii Musician",
            "Ekegusii Music",
            "Kisii Love Songs",
            "Kenyan Vernacular Music"
        ];

        // 3. FAQs
        $faqs = $this->generateFaqsForArtist($artist);

        // 4. JSON-LD Schemas
        $schemas = $this->generateArtistJsonLd($artist, $faqs);

        $social = [
            'og_title' => $seoTitle,
            'og_description' => $metaDescription,
            'og_url' => route('artists.show', $artist->slug),
            'og_type' => 'profile',
            'og_image' => $artist->avatar_url,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $seoTitle,
            'twitter_description' => $metaDescription,
            'twitter_image' => $artist->avatar_url,
        ];

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Artists', 'url' => route('artists.index')],
            ['name' => $name, 'url' => route('artists.show', $artist->slug)],
        ];

        return [
            'title' => $seoTitle,
            'meta_description' => $metaDescription,
            'canonical_url' => route('artists.show', $artist->slug),
            'keywords' => implode(', ', array_unique($keywords)),
            'focus_keyword' => "{$name} Lyrics",
            'image_alt' => "Official Profile Picture of {$name} - Gusii Recording Artist",
            'social' => $social,
            'faqs' => $faqs,
            'schemas' => $schemas,
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    /**
     * Generate dynamic FAQ items for a Song.
     */
    public function generateFaqsForSong(Song $song): array
    {
        $artistName = $song->display_artist_names;
        $title = $song->title;
        $year = $song->release_year ?: 'recent';

        return [
            [
                'question' => "Who sings {$title}?",
                'answer' => "{$title} is performed by renowned Kisii recording artist {$artistName}."
            ],
            [
                'question' => "What language is {$title} sung in?",
                'answer' => "{$title} is performed in the Ekegusii language from Kenya, featuring line-by-line lyrics and English translations."
            ],
            [
                'question' => "Where can I read official {$title} lyrics?",
                'answer' => "You can read verified full word-for-word lyrics, English translations, and watch official music videos for {$title} right here on GusiiLyrics.com."
            ],
            [
                'question' => "When was {$title} released?",
                'answer' => "{$title} by {$artistName} is part of the {$year} Ekegusii music discography available on GusiiLyrics."
            ]
        ];
    }

    /**
     * Generate dynamic FAQ items for an Artist.
     */
    public function generateFaqsForArtist(Artist $artist): array
    {
        $name = $artist->name;
        $location = $artist->location ?: 'Kisii, Kenya';

        return [
            [
                'question' => "Who is {$name}?",
                'answer' => "{$name} is an influential Ekegusii recording artist hailing from {$location}, known for popular song releases, albums, and music performances across East Africa."
            ],
            [
                'question' => "Where can I find all song lyrics by {$name}?",
                'answer' => "You can browse and read the complete song lyrics, album tracklists, and English translations for all releases by {$name} on GusiiLyrics.com."
            ],
            [
                'question' => "What are the most popular songs by {$name}?",
                'answer' => "Explore {$name}'s top-ranking songs, trending tracks, and collaboration singles directly on their official GusiiLyrics artist profile page."
            ]
        ];
    }

    /**
     * Generate JSON-LD Schemas for Song.
     */
    protected function generateSongJsonLd(Song $song, array $faqs): array
    {
        $recordingSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'MusicRecording',
            'name' => $song->title,
            'url' => $song->seo_url,
            'image' => $song->cover_art_url,
            'byArtist' => [
                '@type' => 'MusicGroup',
                'name' => $song->display_artist_names,
            ],
            'inLanguage' => 'ekegusii',
        ];

        if ($song->album) {
            $recordingSchema['inAlbum'] = [
                '@type' => 'MusicAlbum',
                'name' => $song->album->title,
            ];
        }

        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ];
            }, $faqs),
        ];

        return [$recordingSchema, $faqSchema];
    }

    /**
     * Generate JSON-LD Schemas for Artist.
     */
    protected function generateArtistJsonLd(Artist $artist, array $faqs): array
    {
        $artistSchema = [
            '@context' => 'https://schema.org',
            '@type' => $artist->type === 'band' || $artist->type === 'choir' ? 'MusicGroup' : 'Person',
            'name' => $artist->name,
            'url' => route('artists.show', $artist->slug),
            'image' => $artist->avatar_url,
            'description' => $artist->bio ?: "Official discography and song lyrics by {$artist->name}.",
        ];

        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ];
            }, $faqs),
        ];

        return [$artistSchema, $faqSchema];
    }

    /**
     * Calculate 8-12 Related Songs based on weighted artist, genre, theme, and collaborators.
     */
    public function getRelatedSongs(Song $song, int $limit = 8): \Illuminate\Database\Eloquent\Collection
    {
        return Song::with(['artist', 'genre'])
            ->where('id', '!=', $song->id)
            ->where(function ($q) use ($song) {
                $q->where('artist_id', $song->artist_id);
                if ($song->genre_id) {
                    $q->orWhere('genre_id', $song->genre_id);
                }
            })
            ->orderBy('views_count', 'desc')
            ->take($limit)
            ->get();
    }
}
