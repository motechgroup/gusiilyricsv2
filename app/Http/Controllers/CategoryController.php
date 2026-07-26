<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function topGusiiSongs()
    {
        $title = "Top 100 Gusii Songs - Official Ekegusii Music Charts";
        $metaDescription = "Explore the top 100 greatest Ekegusii songs of all time. Read official lyrics, translations, and stream trending classics from iconic Kisii recording artists on GusiiLyrics.";
        $badge = "🔥 Top 100 Charts";
        $seoContent = "Welcome to the definitive Top 100 Ekegusii Music Charts on GusiiLyrics.com. Gusii music encompasses a rich tapestry of cultural storytelling, spiritual praise, traditional acoustic rhythms, and contemporary Afro-Benga melodies. From legendary pioneers such as Kebaso Moriasi and Christopher Monyoncho to modern gospel powerhouses like Fenny Kerubo and Embarambamba, Ekegusii songs celebrate identity, faith, community, and heritage. On this chart, songs are dynamically ranked based on verified listener engagement, total lyric views, community popularity, and streaming activity. Explore full lyrics, English and Swahili translations, release credits, and embedded official music videos for the top hits across Gusii land.";

        $songs = Song::with(['artist', 'genre', 'album'])
            ->orderBy('views_count', 'desc')
            ->take(100)
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function latestSongs()
    {
        $title = "Latest Gusii Songs & New Ekegusii Lyrics Releases";
        $metaDescription = "Stay up to date with the latest Ekegusii music releases, single drops, and newly indexed song lyrics from top Gusii artists on GusiiLyrics.com.";
        $badge = "🆕 New Releases";
        $seoContent = "Discover the newest Ekegusii song releases, single drops, and official lyric transcriptions added daily to GusiiLyrics.com. The Gusii music scene is vibrant and rapidly evolving, featuring weekly releases from gospel vocalists, Benga bands, and contemporary Ekegusii pop artists across Kisii and Nyamira counties. Our editorial team works continuously to transcribe newly published music, ensuring fans have instant access to accurate lyrics, song meanings, streaming links, and official YouTube music videos right as songs drop.";

        $songs = Song::with(['artist', 'genre', 'album'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function gospel()
    {
        $title = "Gusii Gospel Songs - Ekegusii Praise & Worship Lyrics";
        $metaDescription = "Read official lyrics for the most powerful Ekegusii gospel praise and worship songs. Discover Fenny Kerubo, Embarambamba, and top Kisii christian vocalists.";
        $badge = "🙌 Ekegusii Gospel Vault";
        $seoContent = "Gusii gospel music holds a cherished place in Abagusii spiritual life, serving as an uplifting medium of faith, thanksgiving, prayer, and community worship. From soul-stirring hymns performed during church fellowships to high-energy contemporary praise anthems, Ekegusii gospel music inspires millions across Kenya and the diaspora. On GusiiLyrics.com, explore comprehensive transcriptions of famous Ekegusii gospel songs by vocalists like Fenny Kerubo, Embarambamba, Douglas Otiso, and local choir ensembles. Each song entry includes complete lyrics, theological context, song meanings, and direct streaming links.";

        $genre = Genre::where('slug', 'gospel')->first();
        $songs = Song::with(['artist', 'genre', 'album'])
            ->where('genre_id', $genre ? $genre->id : 0)
            ->orWhere('title', 'like', '%nyasae%')
            ->orWhere('title', 'like', '%yesu%')
            ->orWhere('lyrics_raw', 'like', '%nyasae%')
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function loveSongs()
    {
        $title = "Ekegusii Love Songs & Romantic Ballads Lyrics";
        $metaDescription = "Browse romantic Ekegusii love songs, wedding courtship ballads, and sentimental lyrics from famous Kisii artists on GusiiLyrics.com.";
        $badge = "❤️ Ekegusii Love Ballads";
        $seoContent = "Love, romance, and courtship have inspired some of the most memorable melodies in Ekegusii musical history. Ekegusii love songs blend poetic lyrics, heartfelt acoustic guitar chords, and traditional accordion accompaniment to express devotion, admiration, and matrimonial joy. Whether you are seeking classic Benga love ballads or contemporary acoustic love songs for romantic occasions, our curated collection provides complete line-by-line lyrics, translations, and video streams.";

        $songs = Song::with(['artist', 'genre', 'album'])
            ->where('lyrics_raw', 'like', '%love%')
            ->orWhere('lyrics_raw', 'like', '%omogusii%')
            ->orWhere('lyrics_raw', 'like', '%ningwanetie%')
            ->orWhere('lyrics_raw', 'like', '%mwaitu%')
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function traditional()
    {
        $title = "Traditional Ekegusii Songs & Cultural Music Lyrics";
        $metaDescription = "Immerse yourself in authentic Ekegusii traditional music, Obokano harp songs, cultural dance lyrics, and heritage folklore on GusiiLyrics.com.";
        $badge = "🪕 Traditional Cultural Heritage";
        $seoContent = "Traditional Ekegusii music forms the bedrock of Abagusii cultural identity, centered around traditional instruments like the eight-stringed Obokano harp, ceremonial drums, and communal call-and-response vocal chants. Traditional songs celebrate historical milestones, harvest festivals, elder wisdom, and community proverbs. GusiiLyrics.com is committed to preserving these priceless cultural compositions in digital format, offering exact lyric transcriptions, cultural notes, and streaming videos of traditional performers.";

        $genre = Genre::where('slug', 'traditional')->first();
        $songs = Song::with(['artist', 'genre', 'album'])
            ->where('genre_id', $genre ? $genre->id : 0)
            ->orWhere('lyrics_raw', 'like', '%obokano%')
            ->orWhere('lyrics_raw', 'like', '%emamba%')
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function weddingSongs()
    {
        $title = "Gusii Wedding Songs & Matrimonial Celebration Lyrics";
        $metaDescription = "Find popular Ekegusii wedding entrance songs, bridal dance lyrics, and traditional Gusii celebration tracks on GusiiLyrics.com.";
        $badge = "💍 Gusii Wedding Songs";
        $seoContent = "Weddings in Abagusii culture are vibrant, joyful events filled with traditional songs, dance, and festive celebrations. Ekegusii wedding music sets the tone for bridal processional entrances, parental blessings, dowry ceremonies, and reception dances. Discover popular wedding anthems, read word-for-word lyrics, and find streaming links to select the perfect soundtrack for your traditional or modern Gusii wedding.";

        $songs = Song::with(['artist', 'genre', 'album'])
            ->where('title', 'like', '%wedding%')
            ->orWhere('title', 'like', '%enyangi%')
            ->orWhere('lyrics_raw', 'like', '%enyangi%')
            ->orWhere('lyrics_raw', 'like', '%omonwa%')
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function mostViewed()
    {
        $title = "Most Viewed Gusii Song Lyrics & Popular Hits";
        $metaDescription = "Read the most viewed Ekegusii song lyrics on GusiiLyrics.com. See which Kisii tracks are trending highest among listeners worldwide.";
        $badge = "👁️ Most Viewed Lyrics";
        $seoContent = "Track the most popular and frequently viewed Ekegusii song lyrics on GusiiLyrics.com. Updated in real time based on search queries and visitor engagement, this leaderboard highlights the songs capturing the hearts of Ekegusii music fans across Kisii, Nyamira, Nairobi, and the global diaspora.";

        $songs = Song::with(['artist', 'genre', 'album'])
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs'));
    }

    public function trendingArtists()
    {
        $title = "Trending Gusii Artists & Top Vocalists Directory";
        $metaDescription = "Discover trending Ekegusii recording artists, vocalists, and musical bands. Read biographies, discographies, and top song lyrics on GusiiLyrics.com.";

        $artists = Artist::withCount('songs')
            ->orderBy('is_featured', 'desc')
            ->orderBy('songs_count', 'desc')
            ->paginate(16);

        return view('categories.trending_artists', compact('title', 'metaDescription', 'artists'));
    }

    public function genresIndex()
    {
        $genres = Genre::withCount('songs')->get();
        return view('genres.index', compact('genres'));
    }

    public function genreShow($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        $songs = Song::with(['artist', 'album'])
            ->where('genre_id', $genre->id)
            ->orderBy('views_count', 'desc')
            ->paginate(15);

        $title = "{$genre->name} Ekegusii Songs & Lyrics Archive";
        $metaDescription = "Browse all {$genre->name} songs in Ekegusii. Read official lyrics, translations, and stream on YouTube and Spotify via GusiiLyrics.com.";
        $badge = "🎵 {$genre->name} Genre";
        $seoContent = $genre->description ?: "Explore all official song lyrics and streaming links under the {$genre->name} genre on GusiiLyrics.com.";

        return view('categories.landing', compact('title', 'metaDescription', 'badge', 'seoContent', 'songs', 'genre'));
    }
}
