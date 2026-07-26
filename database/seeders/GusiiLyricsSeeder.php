<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Setting;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GusiiLyricsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::updateOrCreate(
            ['email' => 'admin@gusiilylrics.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'editor@gusiilylrics.com'],
            ['name' => 'Gusii Lyrics Editor', 'password' => Hash::make('editor123'), 'role' => 'editor']
        );

        // 2. Settings
        Setting::set('site_name', 'Gusii Lyrics');
        Setting::set('seo_title', 'Gusii Lyrics - Ekegusii Song Lyrics Vault & Translations');
        Setting::set('seo_description', 'Discover Ekegusii lyrics, English & Swahili translations, and official stream links on Spotify & YouTube.');
        Setting::set('seo_keywords', 'Ekegusii lyrics, Kisii songs, Gusii gospel, Abagusii music, Fenny Kerubo, Benga');
        Setting::set('mpesa_till', '5421908');
        Setting::set('mpesa_paybill', '400200');

        // 3. Genres
        $gospel = Genre::create([
            'name' => 'Ekegusii Gospel',
            'slug' => 'gospel',
            'icon' => '🙌',
            'description' => 'Inspirational Ekegusii praise, worship anthems, and christian choir hymns.',
        ]);

        $benga = Genre::create([
            'name' => 'Gusii Benga',
            'slug' => 'benga',
            'icon' => '🎸',
            'description' => 'Fast-paced guitar rhythms and classic Gusii Benga band dance music.',
        ]);

        $traditional = Genre::create([
            'name' => 'Traditional Obokano',
            'slug' => 'traditional',
            'icon' => '🪕',
            'description' => 'Authentic Ekegusii cultural music featuring Obokano 8-stringed harp and folklore.',
        ]);

        $love = Genre::create([
            'name' => 'Love & Wedding',
            'slug' => 'love-wedding',
            'icon' => '💍',
            'description' => 'Romantic Ekegusii courtship ballads and wedding ceremony celebration songs.',
        ]);

        // 4. Artists
        $fenny = Artist::create([
            'name' => 'Fenny Kerubo',
            'slug' => 'fenny-kerubo',
            'location' => 'Kisii, Kenya',
            'origin' => 'Nyaribari Chache, Kisii County',
            'active_years' => '2012 - Present',
            'label' => 'Kerubo Music Ministries',
            'bio' => 'Renowned Gusii gospel vocalist known for soul-stirring hits like Makeba, Baba Mwenye Nyumba, and Ebiogo.',
            'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        $douglas = Artist::create([
            'name' => 'Douglas Otiso',
            'slug' => 'douglas-otiso',
            'location' => 'Nyamira, Kenya',
            'origin' => 'Borabu, Nyamira County',
            'active_years' => '2015 - Present',
            'label' => 'Otiso Gospel Records',
            'bio' => 'Celebrated Ekegusii praise singer whose energetic worship music resonates across East Africa.',
            'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        $embarambamba = Artist::create([
            'name' => 'Embarambamba',
            'slug' => 'embarambamba',
            'location' => 'Kisii, Kenya',
            'origin' => 'Kitutu Chache, Kisii County',
            'active_years' => '2018 - Present',
            'label' => 'Embara Gospel Studio',
            'bio' => 'Dynamic and famous Ekegusii gospel entertainer known for energetic praise dances and theatrical music videos.',
            'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        $monyoncho = Artist::create([
            'name' => 'Christopher Monyoncho',
            'slug' => 'christopher-monyoncho',
            'location' => 'Kisii, Kenya',
            'origin' => 'Bonchari, Kisii County',
            'active_years' => '1970 - 2013',
            'label' => 'Nyabite Boys Band',
            'bio' => 'The legendary king of Gusii Benga music and founder of Nyabite Boys Band whose timeless acoustic Benga songs anchored Gusii music history.',
            'image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        $kebaso = Artist::create([
            'name' => 'Kebaso Moriasi',
            'slug' => 'kebaso-moriasi',
            'location' => 'Kisii, Kenya',
            'origin' => 'South Mugirango, Kisii County',
            'active_years' => '1985 - 2018',
            'label' => 'Mugirango Traditional Records',
            'bio' => 'Master Obokano harpist and cultural storyteller who recorded landmark traditional Ekegusii folklore.',
            'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        // 5. Albums
        $album1 = Album::create([
            'artist_id' => $fenny->id,
            'title' => 'Ebiogo Biang\'e (My Testimonies)',
            'slug' => 'ebiogo-biange',
            'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
            'release_year' => 2023,
            'description' => 'Inspirational Ekegusii gospel praise album by Fenny Kerubo.',
        ]);

        $album2 = Album::create([
            'artist_id' => $monyoncho->id,
            'title' => 'Nyabite Boys Greatest Benga Hits',
            'slug' => 'nyabite-boys-greatest-hits',
            'cover_image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
            'release_year' => 1998,
            'description' => 'Classic Benga dance anthems from Christopher Monyoncho.',
        ]);

        // 6. Songs
        Song::create([
            'artist_id' => $fenny->id,
            'album_id' => $album1->id,
            'genre_id' => $gospel->id,
            'title' => 'Ebiogo Biang\'e (My Testimonies)',
            'slug' => 'ebiogo-biange',
            'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
            'spotify_url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 18450,
            'likes_count' => 1200,
            'release_year' => 2023,
            'song_meaning' => 'A testimony of God\'s unmerited favor lifting a believer out of hardship.',
            'song_credits' => 'Written & Performed by Fenny Kerubo | Audio: Still Alive Studios',
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Ebiogo biang'e ningo obimanyire\nNyasae wane Nyamahang'i omonene\nOnyosirie kwomogoso yomanyiri\nKwanchete asato namagana\n\n(Chorus)\nNgasima Yeso, ngasima Tata\nNgasima Yeso obosire bweng'eno\nIng'o oyio okong'enia Nyamahang'i?\nMoni omonene ore ase ore!",
            'english_translation' => "Who truly understands all my testimonies?\nMy God, the Almighty Creator\nYou lifted me up from dark tribulations\nBecause You love me beyond thousands",
        ]);

        Song::create([
            'artist_id' => $douglas->id,
            'genre_id' => $gospel->id,
            'title' => 'Nyasae Monyene Obosire (God of All Power)',
            'slug' => 'nyasae-monyene-obosire',
            'cover_image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&auto=format&fit=crop&q=80',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 12100,
            'likes_count' => 890,
            'release_year' => 2024,
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Nyasae monyene obosire bwoka\nOrare namagogomba amang'ana\nYacha Tata oyio okomanya eng'ana\nOnyene omogoko otayo korwa!",
            'english_translation' => "God who possesses all divine authority\nYou speak words of eternal promise",
        ]);

        Song::create([
            'artist_id' => $embarambamba->id,
            'genre_id' => $gospel->id,
            'title' => 'Bendera Ya Yesu (Jesus Flag)',
            'slug' => 'bendera-ya-yesu',
            'cover_image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 24500,
            'likes_count' => 1850,
            'release_year' => 2024,
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Bendera ya Yesu nigo eyagetiwe iguru!\nNgasima Tata wane bwoka!\nEng'oto yonsi nigo ekeretiwe Yeso!",
            'english_translation' => "The banner of Jesus is raised high above!\nI glorify my Father alone!",
        ]);

        Song::create([
            'artist_id' => $monyoncho->id,
            'album_id' => $album2->id,
            'genre_id' => $benga->id,
            'title' => 'Nyaboke Omonwa Mobe',
            'slug' => 'nyaboke-omonwa-mobe',
            'cover_image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 15200,
            'likes_count' => 1100,
            'release_year' => 1995,
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Nyaboke yare omomura oyio omware\nNingwanetie Tata omogusii omochia\nOkong'ania amang'ana yomogoso!",
            'english_translation' => "Nyaboke was a respected daughter\nI praise the Gusii community with honor",
        ]);

        Song::create([
            'artist_id' => $kebaso->id,
            'genre_id' => $traditional->id,
            'title' => 'Obokano Bwa Gusii (Cultural Strings)',
            'slug' => 'obokano-bwa-gusii',
            'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 9800,
            'likes_count' => 640,
            'release_year' => 2010,
            'is_featured' => true,
            'lyrics_raw' => "Emamba yobokano nigo ekogamba\nAbagusii bonsi ng\'imaria amang\'ana\nNche korwa Mugirango tata monyene!",
            'english_translation' => "The strings of Obokano resonate across the hills\nGather all Abagusii elders to hear wisdom",
        ]);

        Song::create([
            'artist_id' => $fenny->id,
            'genre_id' => $love->id,
            'title' => 'Enyangi Ekero Enyene (Wedding Joy)',
            'slug' => 'enyangi-ekero-enyene',
            'cover_image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 13400,
            'likes_count' => 990,
            'release_year' => 2024,
            'is_featured' => true,
            'lyrics_raw' => "Enyangi ya tata yacha lelo!\nOmogoko omonee kwene nka!\nBonsi ng\'enyera Tata monyene!",
            'english_translation' => "The wedding day of joy has arrived today!\nGreat laughter fills our homestead!",
        ]);
    }
}
