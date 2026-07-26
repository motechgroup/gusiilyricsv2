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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Users (Super Admin & Editor)
        User::updateOrCreate(
            ['email' => 'admin@gusiilylrics.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@gusiilylrics.com'],
            [
                'name' => 'Gusii Lyrics Editor',
                'password' => Hash::make('editor123'),
                'role' => 'editor',
            ]
        );

        // 2. Initial Settings (Site Details, SEO, Tracking, Ads, Donations)
        Setting::set('site_name', 'Gusii Lyrics');
        Setting::set('site_logo', '');
        Setting::set('favicon', '');
        Setting::set('seo_title', 'Gusii Lyrics - Ekegusii Song Lyrics Vault & Translations');
        Setting::set('seo_description', 'Discover Ekegusii lyrics, English & Swahili translations, and official stream links on Spotify & YouTube.');
        Setting::set('seo_keywords', 'Ekegusii lyrics, Kisii songs, Gusii gospel, Abagusii music, Fenny Kerubo, Benga');
        
        Setting::set('google_analytics_id', ''); // e.g. G-XXXXXXXXXX
        Setting::set('google_adsense_code', ''); // e.g. <script async src="https://pagead2.googlesyndication.com/..."></script>
        Setting::set('meta_pixel_id', ''); // Facebook Pixel ID

        Setting::set('mpesa_till', '5421908');
        Setting::set('mpesa_paybill', '400200');
        Setting::set('mpesa_account', 'GUSIILYRICS');
        Setting::set('stripe_url', 'https://buy.stripe.com/donate_gusiilylrics');

        // 3. Genres
        $gospel = Genre::create([
            'name' => 'Ekegusii Gospel',
            'slug' => 'gospel',
            'icon' => 'sparkles',
            'description' => 'Inspirational Ekegusii praise and worship songs.',
        ]);

        $benga = Genre::create([
            'name' => 'Gusii Benga',
            'slug' => 'benga',
            'icon' => 'guitar',
            'description' => 'Traditional and modern Ekegusii Benga melodies.',
        ]);

        // 4. Artists
        $fenny = Artist::create([
            'name' => 'Fenny Kerubo',
            'slug' => 'fenny-kerubo',
            'location' => 'Kisii, Kenya',
            'bio' => 'Renowned Gusii gospel artist known for soul-stirring hits like Makeba, Baba Mwenye Nyumba, and Ebiogo.',
            'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        $douglas = Artist::create([
            'name' => 'Douglas Otiso',
            'slug' => 'douglas-otiso',
            'location' => 'Nyamira, Kenya',
            'bio' => 'Celebrated Ekegusii praise singer whose energetic worship music resonates across East Africa.',
            'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
            'is_featured' => true,
        ]);

        // 5. Albums
        $album1 = Album::create([
            'artist_id' => $fenny->id,
            'title' => 'Ebiogo Biang\'e (My Testimonies)',
            'slug' => 'ebiogo-biange',
            'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
            'release_year' => 2023,
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
            'views_count' => 14200,
            'likes_count' => 980,
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Ebiogo biang'e ningo obimanyire\nNyasae wane Nyamahang'i omonene\nOnyosirie kwomogoso yomanyiri\nKwanchete asato namagana\n\n(Chorus)\nNgasima Yeso, ngasima Tata\nNgasima Yeso obosire bweng'eno\nIng'o oyio okong'enia Nyamahang'i?\nMoni omonene ore ase ore!",
            'english_translation' => "Who truly understands all my testimonies?\nMy God, the Almighty Creator\nYou lifted me up from dark tribulations\nBecause You love me beyond thousands",
            'swahili_translation' => "Ni nani anayeyafahamu ushuhuda wangu wote?\nMungu wangu Muumba Mkuu\nUlininyanyua kutoka kwenye dhiki na giza\nKwa sababu unanipenda kuliko maelfu",
        ]);

        Song::create([
            'artist_id' => $douglas->id,
            'genre_id' => $gospel->id,
            'title' => 'Nyasae Monyene Obosire (God of All Power)',
            'slug' => 'nyasae-monyene-obosire',
            'cover_image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&auto=format&fit=crop&q=80',
            'spotify_url' => 'https://open.spotify.com',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views_count' => 9100,
            'likes_count' => 740,
            'is_featured' => true,
            'is_trending' => true,
            'lyrics_raw' => "Nyasae monyene obosire bwoka\nOrare namagogomba amang'ana\nYacha Tata oyio okomanya eng'ana\nOnyene omogoko otayo korwa!",
            'english_translation' => "God who possesses all divine authority\nYou speak words of eternal promise\nCome Father, You who knows our every heart",
        ]);
    }
}
