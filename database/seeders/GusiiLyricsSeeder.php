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
            ['email' => 'admin@gusiilyrics.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'editor@gusiilyrics.com'],
            ['name' => 'Gusii Lyrics Editor', 'password' => Hash::make('editor123'), 'role' => 'editor']
        );

        // 2. Settings
        Setting::set('site_name', 'Gusii Lyrics');
        Setting::set('site_logo', '/images/logo.png');
        Setting::set('favicon', '/images/favicon.png');
        Setting::set('seo_title', 'Gusii Lyrics - Ekegusii Song Lyrics & Translations');
        Setting::set('seo_description', 'Discover Ekegusii lyrics, English & Swahili translations, and official stream links on Spotify & YouTube.');
        Setting::set('seo_keywords', 'Ekegusii lyrics, Kisii songs, Gusii gospel, Omogusii music, Fenny Kerubo, Benga');
        Setting::set('mpesa_till', '5421908');
        Setting::set('mpesa_paybill', '400200');

        // 3. Genres
        $gospel = Genre::firstOrCreate(
            ['slug' => 'gospel'],
            ['name' => 'Ekegusii Gospel', 'icon' => '🙌', 'description' => 'Inspirational Ekegusii praise, worship anthems, and christian choir hymns.']
        );

        $benga = Genre::firstOrCreate(
            ['slug' => 'benga'],
            ['name' => 'Gusii Benga', 'icon' => '🎸', 'description' => 'Fast-paced guitar rhythms and classic Gusii Benga band dance music.']
        );

        $traditional = Genre::firstOrCreate(
            ['slug' => 'traditional'],
            ['name' => 'Traditional Obokano', 'icon' => '🪕', 'description' => 'Authentic Ekegusii cultural music featuring Obokano 8-stringed harp and folklore.']
        );

        $love = Genre::firstOrCreate(
            ['slug' => 'love-wedding'],
            ['name' => 'Love & Wedding', 'icon' => '💍', 'description' => 'Romantic Ekegusii courtship ballads and wedding ceremony celebration songs.']
        );

        // 4. Artists
        $fenny = Artist::firstOrCreate(
            ['slug' => 'fenny-kerubo'],
            [
                'name' => 'Fenny Kerubo',
                'type' => 'artist',
                'location' => 'Kisii County, Kenya',
                'origin' => 'Nyaribari Chache, Kisii County',
                'active_years' => '2012 - Present',
                'label' => 'Kerubo Music Ministries',
                'bio' => 'Renowned Gusii gospel vocalist known for soul-stirring hits like Makeba, Baba Mwenye Nyumba, and Ebiogo.',
                'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $douglas = Artist::firstOrCreate(
            ['slug' => 'douglas-otiso'],
            [
                'name' => 'Douglas Otiso',
                'type' => 'artist',
                'location' => 'Nyamira County, Kenya',
                'origin' => 'Borabu, Nyamira County',
                'active_years' => '2015 - Present',
                'label' => 'Otiso Gospel Records',
                'bio' => 'Celebrated Ekegusii praise singer whose energetic worship music resonates across East Africa.',
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $embarambamba = Artist::firstOrCreate(
            ['slug' => 'embarambamba'],
            [
                'name' => 'Embarambamba',
                'type' => 'artist',
                'location' => 'Kisii County, Kenya',
                'origin' => 'Kitutu Chache, Kisii County',
                'active_years' => '2018 - Present',
                'label' => 'Embara Gospel Studio',
                'bio' => 'Dynamic and famous Ekegusii gospel entertainer known for energetic praise dances and theatrical music videos.',
                'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $monyoncho = Artist::firstOrCreate(
            ['slug' => 'christopher-monyoncho'],
            [
                'name' => 'Christopher Monyoncho',
                'type' => 'artist',
                'location' => 'Kisii County, Kenya',
                'origin' => 'Bonchari, Kisii County',
                'active_years' => '1970 - 2013',
                'label' => 'Nyabite Boys Band',
                'bio' => 'The legendary king of Gusii Benga music and founder of Nyabite Boys Band whose timeless acoustic Benga songs anchored Gusii music history.',
                'image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $kebaso = Artist::firstOrCreate(
            ['slug' => 'kebaso-moriasi'],
            [
                'name' => 'Kebaso Moriasi',
                'type' => 'artist',
                'location' => 'Kisii County, Kenya',
                'origin' => 'South Mugirango, Kisii County',
                'active_years' => '1985 - 2018',
                'label' => 'Mugirango Traditional Records',
                'bio' => 'Master Obokano harpist and cultural storyteller who recorded landmark traditional Ekegusii folklore.',
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $mckudu = Artist::firstOrCreate(
            ['slug' => 'mc-kudu'],
            [
                'name' => 'MC Kudu',
                'type' => 'artist',
                'location' => 'Kisii, Kenya',
                'origin' => 'Manga, Nyamira County',
                'active_years' => '2016 - Present',
                'label' => 'Kudu Muzik',
                'bio' => 'Contemporary Ekegusii urban benga and rap fusion artist delivering social commentary.',
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $nyabiteBand = Artist::firstOrCreate(
            ['slug' => 'nyabite-boys-band'],
            [
                'name' => 'Nyabite Boys Band',
                'type' => 'band',
                'location' => 'Kisii County, Kenya',
                'active_years' => '1975 - Present',
                'label' => 'Gusii Benga Records',
                'bio' => 'Pioneer Gusii Benga music band famous across Kenya for timeless Benga guitar dance rhythms.',
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $sunekaBand = Artist::firstOrCreate(
            ['slug' => 'suneka-guitar-band'],
            [
                'name' => 'Suneka Guitar Band',
                'type' => 'band',
                'location' => 'Kisii County, Kenya',
                'active_years' => '2005 - Present',
                'label' => 'Suneka Sound Productions',
                'bio' => 'High-energy Gusii Benga guitar band performing classic and modern dance compositions.',
                'image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $nyanchwaChoir = Artist::firstOrCreate(
            ['slug' => 'sda-nyanchwa-main-choir'],
            [
                'name' => 'SDA Nyanchwa Main Choir',
                'type' => 'choir',
                'location' => 'Kisii County, Kenya',
                'active_years' => '1990 - Present',
                'label' => 'Nyanchwa Choir Ministries',
                'bio' => 'Acclaimed Seventh-day Adventist choir known for heavenly Ekegusii acapella and orchestral gospel hymns.',
                'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $cathedralChoir = Artist::firstOrCreate(
            ['slug' => 'catholics-nyamira-choir'],
            [
                'name' => 'Catholics Nyamira Choir',
                'type' => 'choir',
                'location' => 'Nyamira County, Kenya',
                'active_years' => '2000 - Present',
                'label' => 'Cathedral Music Ministry',
                'bio' => 'Renowned Catholic sanctuary choir delivering soul-enriching Ekegusii choral worship.',
                'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        $gusiiCultural = Artist::firstOrCreate(
            ['slug' => 'gusii-cultural-troupe'],
            [
                'name' => 'Gusii Cultural Troupe',
                'type' => 'group',
                'location' => 'Kisii County, Kenya',
                'active_years' => '2010 - Present',
                'label' => 'Abagusii Heritage Arts',
                'bio' => 'Traditional Obokano, flute, and percussion cultural ensemble preserving Abagusii folklore.',
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ]
        );

        // 5. Albums
        $album1 = Album::firstOrCreate(
            ['slug' => 'ebiogo-biange'],
            [
                'artist_id' => $fenny->id,
                'title' => 'Ebiogo Biang\'e (My Testimonies)',
                'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
                'release_year' => 2023,
                'description' => 'Inspirational Ekegusii gospel praise album by Fenny Kerubo.',
            ]
        );

        $album2 = Album::firstOrCreate(
            ['slug' => 'nyabite-boys-greatest-hits'],
            [
                'artist_id' => $monyoncho->id,
                'title' => 'Nyabite Boys Greatest Benga Hits',
                'cover_image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
                'release_year' => 1998,
                'description' => 'Classic Benga dance anthems from Christopher Monyoncho.',
            ]
        );

        // 6. Songs list with full lyrics
        $songsData = [
            [
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
                'lyrics_raw' => "[INTRO]\nNOMOISI OMOBE KORU NYABIOSI KUDU\nEbiogo biang'e ningo obimanyire\nNyasae wane Nyamahang'i omonene\nOnyosirie kwomogoso yomanyiri\n\n[CHORUS]\nNgasima Yeso, ngasima Tata\nNgasima Yeso obosire bweng'eno\nIng'o oyio okong'enia Nyamahang'i?\nMoni omonene ore ase ore!\n\n[VERSE 1]\nEkero nare ase emianya yebisagane\nYeso nakonya akamosoria iguru\nKwenchete asato namagana lelo\nEsarakani yaye neyia ebino nse\n\n[CHORUS]\nNgasima Yeso, ngasima Tata\nNgasima Yeso obosire bweng'eno\nIng'o oyio okong'enia Nyamahang'i?\nMoni omonene ore ase ore!\n\n[VERSE 2]\nBonsi abanto nigo bagoseka mbeki\nKware Nyamahang'i nakwa busi busi\nOmonwa omonene nigo akomanyia\nYeso wane nigo asireire obore\n\n[OUTRO]\nHaleluya Ngasima Yeso\nHaleluya Nyasae wane\nAmen Amen!",
                'english_translation' => "Who truly understands all my testimonies?\nMy God, the Almighty Creator\nYou lifted me up from dark tribulations\nBecause You love me beyond thousands",
            ],
            [
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
                'lyrics_raw' => "[INTRO]\nNyasae monyene obosire bwoka\nOrare namagogomba amang'ana\n\n[VERSE 1]\nYacha Tata oyio okomanya eng'ana\nOnyene omogoko otayo korwa\nBokera asato nigo obategetie\nNyasae monyene obosire obomanye\n\n[CHORUS]\nTata wane Nyamahang'i omonene\nOnyene magokoswa na amang'ana\nAbagusii bonsi ng'imaria amang'ana\nNyasae wane nakura amabera!\n\n[VERSE 2]\nEkero y'obosa nigo agosaanya\nAsato na magana agokura oboboso\nIng'o oyio ogoteeta ebito?\nNyasae monyene obosire busi!\n\n[OUTRO]\nHallelujah praise Him\nNyasae monyene obosire!",
                'english_translation' => "God who possesses all divine authority\nYou speak words of eternal promise",
            ],
            [
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
                'lyrics_raw' => "[INTRO]\nBendera ya Yesu nigo eyagetiwe iguru!\nNgasima Tata wane bwoka!\n\n[VERSE 1]\nEng'oto yonsi nigo ekeretiwe Yeso!\nBari bagokwana nigo bagotiga\nYeso wane nigo agotomora amagoko\nToroka iguru ng'anya na amabera!\n\n[CHORUS]\nBendera ya Yesu eyagete iguru!\nBendera ya Yesu eyagete iguru!\nIng'oto ya Yeso obomanyi obo!\nHaleluya Ngasima Yeso!\n\n[VERSE 2]\nNka Kisii na Nyamira ng'anya lelo\nBonsi abamura ng'enyera omosoro\nYeso omonene nakonyoire busi\nTogenda iguru na bendera ya Yeso!\n\n[OUTRO]\nJesus is Lord!\nBendera ya Yesu iguru!",
                'english_translation' => "The banner of Jesus is raised high above!\nI glorify my Father alone!",
            ],
            [
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
                'lyrics_raw' => "[INTRO]\nNyaboke yare omomura oyio omware\nNingwanetie Tata omogusii omochia\n\n[VERSE 1]\nOkong'ania amang'ana yomogoso\nNyabite Boys Band ng'enyera gitari\nOtuka mogoko kwanchete Nyaboke\nTate omomura otikome enka yaye\n\n[CHORUS]\nAi Nyaboke wane omonwa mobe!\nAmang'ana yaye nigo akogamba\nOtiga ebisagane omogusii omochia\nNyabite Boys bakoza gitari!\n\n[VERSE 2]\nGitari nigo ekogamba mbera mbera\nBenga ya Gusii ya Christopher Monyoncho\nBonsi abanto ng'imaria amang'ana\nTacha toboroke omogoko enka!\n\n[OUTRO]\nNyabite Boys Band original Benga!",
                'english_translation' => "Nyaboke was a respected daughter\nI praise the Gusii community with honor",
            ],
            [
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
                'lyrics_raw' => "[INTRO]\nEmamba yobokano nigo ekogamba\nOmogusii bonsi ng'imaria amang'ana\n\n[VERSE 1]\nNche korwa Mugirango tata monyene\nChinchera chia tata nigo chiatoreire\nObokano bweto obomanyi bwomogusii\nTotiga chinchera chia sokoro wetu\n\n[CHORUS]\nObokano bwa Gusii bochietiwe iguru!\nEmamba nane nigo ekogamba buya\nOmogusii bonsi imaria amang'ana\nTotiga obokano bwa Abagusii!\n\n[VERSE 2]\nSokoro nigo agokwana amang'ana\nOmogoro na emianya chia amabera\nNka Kisii na Nyamira emamba ya obokano\nEogosa ebisagane bionsi busi\n\n[OUTRO]\nObokano bwa Gusii classic!",
                'english_translation' => "The strings of Obokano resonate across the hills\nGather all Omogusii elders to hear wisdom",
            ],
            [
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
                'lyrics_raw' => "[INTRO]\nEnyangi ya tata yacha lelo!\nOmogoko omonee kwene nka!\n\n[VERSE 1]\nBonsi ng'enyera Tata monyene\nOmwari nigo asira enka ya taata\nOyio kwanchete naborete amang'ana\nEnyangi enyene ya omogoko omonee\n\n[CHORUS]\nEnyangi ya lelo eyomogoko!\nOmware na omomura ng'enyera enka!\nNyasae agotegetia enka yaino\nHaleluya ngasima Yeso!\n\n[VERSE 2]\nAmang'ana yomogoko ng'imaria lelo\nAbakorosoku nigo bagotera\nNyasae monyene otikome obosire\nEnyangi yaino etikomie omogoko\n\n[OUTRO]\nCongratulations wedding day!",
                'english_translation' => "The wedding day of joy has arrived today!\nGreat laughter fills our homestead!",
            ],
            [
                'artist_id' => $kebaso->id,
                'genre_id' => $traditional->id,
                'title' => 'Chinchera Chia Omogusii (Gusii Traditions)',
                'slug' => 'chinchera-chia-omogusii',
                'cover_image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 11200,
                'likes_count' => 780,
                'release_year' => 2012,
                'is_featured' => false,
                'lyrics_raw' => "[INTRO]\nChinchera chia tata nigo chiatoreire!\nOmogusii bonsi ng'imaria amang'ana!\n\n[VERSE 1]\nAbagusii nka Kisii na Nyamira\nSokoro nakwa amang'ana yobokano\nEkero torerire chinchera chia enka\nTometia obomanyi na oborore\n\n[CHORUS]\nChinchera chia Omogusii nchera ya mbera!\nTotiga emogoso ya sokoro wetu\nOmogusii omochia ng'anya amang'ana\nObokano nigo ekogamba lelo!\n\n[VERSE 2]\nAbamura na abang'ina ng'imaria lelo\nTotiga oborore bwa Gusii enka\nEmamba ya obokano nigo ekogamba\nKebaso Moriasi ng'enyera amang'ana\n\n[OUTRO]\nPreserving Gusii Heritage!",
                'english_translation' => "Our Gusii traditions guide us through generations!",
            ],
            [
                'artist_id' => $monyoncho->id,
                'genre_id' => $benga->id,
                'title' => 'Omogusii Omochia (Respected Gusii)',
                'slug' => 'omogusii-omochia',
                'cover_image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 16700,
                'likes_count' => 1250,
                'release_year' => 1998,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nOmogusii omochia nigo akogamba amang'ana yomogoso!\nChristopher Monyoncho na Nyabite Boys!\n\n[VERSE 1]\nNka Bonchari na Nyaribari lelo\nGitari ya Benga nigo ekotera\nAbamura nigo bagoseka mogoko\nOmogusii omochia okwania obomanyi\n\n[CHORUS]\nOmogusii omochia gitari ekogamba!\nBenga ya Monyoncho timeless classic!\nBonsi abanto bora enka ya Gusii\nTogenda mbera na gitari yaye!\n\n[VERSE 2]\nNyabite Boys Band original sound\nOkong'ania amang'ana agotikoma enka\nAmabera na omogoko bionsi enka\nChristopher Monyoncho benga king!\n\n[OUTRO]\nNyabite Boys Band legend!",
                'english_translation' => "The honorable Gusii elder speaks words of wisdom!",
            ],
            [
                'artist_id' => $fenny->id,
                'genre_id' => $gospel->id,
                'title' => 'Nyasae Wane (My Heavenly Father)',
                'slug' => 'nyasae-wane',
                'cover_image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 21300,
                'likes_count' => 1540,
                'release_year' => 2023,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nNyasae wane Nyamahang'i omonene ngasima oboboso bwango!\n\n[VERSE 1]\nEkero nare monyene ase amagoso\nNyasae nakonya akamosoria iguru\nEbiogo biang'e nigo abimanyire\nKwanchete Yeso wane Nyamahang'i\n\n[CHORUS]\nNyasae wane, Tata omonene!\nObosire bweng'eno nabwo ogokura!\nNgasima Yeso ase amabera yaye\nAmen, Haleluya praise God!\n\n[VERSE 2]\nOtayo obosire nka Yeso omonene\nAgokura ebito bionsi kwomogoso\nFenny Kerubo ng'enyera omosoro\nNyasae wane omonene oboboso!\n\n[OUTRO]\nThank you Lord Jesus!",
                'english_translation' => "My Heavenly Father, I give thanks for Your grace!",
            ],
            [
                'artist_id' => $embarambamba->id,
                'genre_id' => $gospel->id,
                'title' => 'Ing\'oto Ya Yesu (Victory of Jesus)',
                'slug' => 'ingoto-ya-yesu',
                'cover_image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 19800,
                'likes_count' => 1410,
                'release_year' => 2024,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nIng'oto ya Yesu nigo eyagetiwe iguru lelo!\nEmbarambamba gospel fire!\n\n[VERSE 1]\nYeso wane nakura ing'oto enene!\nBari bagokwana nigo bagotiga\nNg'anya mud and jump for Jesus!\nIng'oto ya Tata eyagete iguru\n\n[CHORUS]\nIng'oto ya Yesu! Ing'oto ya Yeso!\nHaleluya praise the Almighty God!\nBonsi abanto ng'imaria amang'ana\nBendera ya Yeso eyo iguru!\n\n[VERSE 2]\nEbisagane bionsi nigo biakorire\nYeso omonene nare ase ore\nNgasima Tata wane busi busi\nTogenda iguru na ing'oto ya Yeso!\n\n[OUTRO]\nVictory belongs to Jesus!",
                'english_translation' => "The victory of Jesus is proclaimed today!",
            ],
            [
                'artist_id' => $nyabiteBand->id,
                'genre_id' => $benga->id,
                'title' => 'Benga Special (Nyabite Dance)',
                'slug' => 'benga-special-nyabite-dance',
                'cover_image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'views_count' => 16400,
                'likes_count' => 1320,
                'release_year' => 2022,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nGusii Benga Nyabite Boys!\nNgasima abamura na abang'ina\n\n[VERSE 1]\nNchera y'omogusii nchera ya mwebetoria!\nGitari ya Nyabite Boys nigo ekotera\nBonsi abanto bora Kisii town\nTaboroke omogoko gitari ya benga\n\n[CHORUS]\nBenga Special Nyabite dance!\nNyabite Boys Band classic guitar!\nOmogusii omochia ng'anya amang'ana\nDance Benga dance Nyabite!\n\n[VERSE 2]\nAmang'ana yomogoso gitari ekotera\nAbang'ina na abamura ng'enyera enka\nGusii Benga original rhythm\nMonyoncho style Nyabite sound!\n\n[OUTRO]\nNyabite Boys Band forever!",
                'english_translation' => "Gusii Benga Nyabite Boys!\nGreetings to young men and women!",
            ],
            [
                'artist_id' => $sunekaBand->id,
                'genre_id' => $benga->id,
                'title' => 'Suneka Guitar Rhythms',
                'slug' => 'suneka-guitar-rhythms',
                'cover_image' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&auto=format&fit=crop&q=80',
                'views_count' => 12900,
                'likes_count' => 980,
                'release_year' => 2023,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nSuneka Band omogusii omochia!\nNyaboke nigo akogamba amang'ana!\n\n[VERSE 1]\nGitari ya Suneka nigo ekotera buya\nNka Suneka market na Bonchari\nAbamura nigo bagoseka mogoko\nOmogusii omochia ng'anya benga\n\n[CHORUS]\nSuneka Guitar Rhythms dance!\nBenga ya Gusii Suneka style!\nBonsi abanto ng'imaria amang'ana\nDance to the acoustic guitar!\n\n[VERSE 2]\nAmabera ya gitari nigo agoseka\nOmoware na omomura taboroke enka\nSuneka Guitar Band high energy\nBenga music Gusii pride!\n\n[OUTRO]\nSuneka Guitar Band 2026!",
                'english_translation' => "Suneka Band praises Gusii community!",
            ],
            [
                'artist_id' => $nyanchwaChoir->id,
                'genre_id' => $gospel->id,
                'title' => 'Enyasae Omoene (God Almighty)',
                'slug' => 'enyasae-omoene',
                'cover_image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
                'views_count' => 22100,
                'likes_count' => 1950,
                'release_year' => 2023,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nEnyasae omoene oyio magokoswa iguru\nNgasima oboboso bwango monyene\n\n[VERSE 1]\nAmen, Haleluya Nyasae wane\nSDA Nyanchwa Main Choir gospel praise\nOnyene obosire nka Nyamahang'i\nOnyosirie kwomogoso yomanyiri\n\n[CHORUS]\nEnyasae Omoene ngasima obosire!\nSDA Nyanchwa Choir heavenly voice!\nMagokoswa na amang'ana yaye iguru\nHaleluya Amen Praise Him!\n\n[VERSE 2]\nEkero togenda enka ya iguru\nYeso wane nakura emianya yaye\nBonsi abanto ng'imaria amang'ana\nEnyasae Omoene obomanyi obo!\n\n[OUTRO]\nNyanchwa Choir Adventist Hymnal!",
                'english_translation' => "Almighty God praised in heaven above\nI glorify your Holy Grace!",
            ],
            [
                'artist_id' => $cathedralChoir->id,
                'genre_id' => $gospel->id,
                'title' => 'Amani Na Upendo (Cathedral Choral)',
                'slug' => 'amani-na-upendo-cathedral',
                'cover_image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&auto=format&fit=crop&q=80',
                'views_count' => 18700,
                'likes_count' => 1420,
                'release_year' => 2024,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nAmani na upendo kwanchete Tata monyene!\nNyasae wane Nyamahang'i!\n\n[VERSE 1]\nCatholics Nyamira Choir choral worship\nObomanyi na amani nka Gusii enka\nYeso omonene nakura amabera\nNgasima Tata wane bwoka\n\n[CHORUS]\nAmani na Upendo Cathedral Choral!\nNyasae monyene agotegetia amani!\nAbagusii bonsi ng'imaria amang'ana\nAmen Amen Praise God!\n\n[VERSE 2]\nEkero togenda kanisa ya Nyamira\nSauti ya amani nigo ekotera\nTata wane Nyamahang'i omonene\nOtikome amani enka yaye!\n\n[OUTRO]\nCathedral Choir Nyamira!",
                'english_translation' => "Peace and love from our Lord Almighty!",
            ],
            [
                'artist_id' => $gusiiCultural->id,
                'genre_id' => $traditional->id,
                'title' => 'Ribina Riorugano (Gusii Cultural Dance)',
                'slug' => 'ribina-riorugano',
                'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
                'views_count' => 14300,
                'likes_count' => 1050,
                'release_year' => 2021,
                'is_featured' => true,
                'lyrics_raw' => "[INTRO]\nRibina riorugano rwachoreire Abagusii!\nEmamba yobokano nigo ekogamba!\n\n[VERSE 1]\nGusii Cultural Troupe folklore dance\nSokoro na omogoro nka Kisii\nObokano na omocheke nigo agosanya\nOmogusii omochia ng'anya amang'ana\n\n[CHORUS]\nRibina Riorugano cultural dance!\nAbagusii heritage arts preservation!\nObokano traditional 8-string harp\nDance Gusii cultural dance!\n\n[VERSE 2]\nChinchera chia sokoro wetu\nTotiga oborore bwa Abagusii enka\nEmamba yobokano nigo ekogamba\nRibina riorugano Gusii culture!\n\n[OUTRO]\nAbagusii Cultural Troupe!",
                'english_translation' => "The heritage dance belongs to Abagusii!\nThe Obokano harp echoes loud!",
            ],
            [
                'artist_id' => $mckudu->id,
                'genre_id' => $benga->id,
                'title' => 'Omwanone Nkagosomia Buya (Educating My Child)',
                'slug' => 'omwanone-nkagosomia-buya',
                'cover_image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'spotify_url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 28900,
                'likes_count' => 2100,
                'release_year' => 2025,
                'is_featured' => true,
                'is_trending' => true,
                'lyrics_raw' => "[INTRO]\nNOMOISI OMOBE KORU NYABIOSI KUDU\nMC Kudu ccti omwanone\n\n[CHORUS]\nOmwanone nkagosomia buya ,gwasireire etown\nAye omwanone nkagokinia buya ,gwasireire etown\n(NKAA) Nechikonda ngokora\n(IGAA) Timbwati abasani\n(IGWA) Namaremo okogora\nInka bansakoire amadeni\n(NKAA) Nechikonda ngokora\n(IGAA) Timbwati abasani\n(IGWA) Namaremo okogora\nInka bansakoire amadeni\n\n[VERSE 1]\nOmwanone nkasomia shule buya\nNkasoya ego ekero oragete etown\nOtiga amang'ana ya abasani\nSoma vitabu otikome enka yaye\n\n[CHORUS]\nOmwanone nkagosomia buya ,gwasireire etown\nAye omwanone nkagokinia buya ,gwasireire etown\n(NKAA) Nechikonda ngokora\n(IGAA) Timbwati abasani\n(IGWA) Namaremo okogora\nInka bansakoire amadeni\n\n[VERSE 2]\nAbabari nigo bagokora amadeni\nKwomonyene enka yaye otiga ebisagane\nMC Kudu ccti Ekegusii benga fusion\nEducate our kids for a brighter future!\n\n[OUTRO]\nMC Kudu CCTI Omwanone!",
                'english_translation' => "I educated my child well, but they got lost in town\nI raised my child with love, but town took them away",
            ],
            [
                'artist_id' => $fenny->id,
                'genre_id' => $gospel->id,
                'title' => 'Baba Mwenye Nyumba (Father of the House)',
                'slug' => 'baba-mwenye-nyumba',
                'cover_image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 31200,
                'likes_count' => 2400,
                'release_year' => 2022,
                'is_featured' => true,
                'is_trending' => true,
                'lyrics_raw' => "[INTRO]\nBaba mwenye nyumba oyio Yeso omonene!\nFenny Kerubo gospel worship!\n\n[VERSE 1]\nEnka yane nigo eyomire lelo\nYeso wane nakura amabera yaye\nOtayo omoene enka nka Tata Yeso\nAgokura oboboso nka Kisii na Nyamira\n\n[CHORUS]\nBaba mwenye nyumba Yeso omonene!\nEnka yeto etikomie oboboso!\nNgasima Yeso ase amabera yaye\nAmen Haleluya Praise God!\n\n[VERSE 2]\nEbisagane bionsi nigo biagwiire\nYeso omonene nakedire enka yane\nFenny Kerubo gospel vocal praise\nBaba mwenye nyumba Lord of Lords!\n\n[OUTRO]\nJesus is the head of our house!",
                'english_translation' => "Jesus is the master and Father of our house!",
            ],
            [
                'artist_id' => $douglas->id,
                'genre_id' => $love->id,
                'title' => 'Kerubo Ong\'ina Buya (Good Mother Kerubo)',
                'slug' => 'kerubo-ongina-buya',
                'cover_image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 15600,
                'likes_count' => 1180,
                'release_year' => 2023,
                'is_featured' => false,
                'lyrics_raw' => "[INTRO]\nKerubo ong'ina buya kwanchete lelo!\nDouglas Otiso love song!\n\n[VERSE 1]\nKerubo ong'ina buya nigo asireire enka\nOmoware oyio obire amang'ana yomogoso\nNg'anya amabera ya Kerubo wetu\nDouglas Otiso ng'enyera gitari\n\n[CHORUS]\nKerubo ong'ina buya enka ya mbera!\nAmabera yaye agotikoma enka!\nBonsi abanto ng'imaria amang'ana\nKerubo my beloved wife!\n\n[VERSE 2]\nEnyangi enyene ya omogoko omonee\nKerubo wane nka Borabu Nyamira\nNyasae agotegetia enka yaino\nLove and peace in our family!\n\n[OUTRO]\nKerubo ong'ina buya forever!",
                'english_translation' => "Good mother Kerubo, loved wife and mother of our house!",
            ],
            [
                'artist_id' => $nyanchwaChoir->id,
                'genre_id' => $gospel->id,
                'title' => 'Nchera Ya Iguru (Way to Heaven)',
                'slug' => 'nchera-ya-iguru',
                'cover_image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&auto=format&fit=crop&q=80',
                'views_count' => 26400,
                'likes_count' => 2050,
                'release_year' => 2024,
                'is_featured' => true,
                'is_trending' => true,
                'lyrics_raw' => "[INTRO]\nNchera ya iguru Yeso omonene!\nSDA Nyanchwa Main Choir acapella!\n\n[VERSE 1]\nEkero togenda nchera ya iguru\nYeso wane nakura amang'ana yaye\nOtiga ebisagane ya nse eno\nTogenda mbera na Yeso omonene\n\n[CHORUS]\nNchera ya iguru Yeso omoene!\nSDA Nyanchwa Choir choral melody!\nHaleluya praise the Heavenly Father\nAmen Amen Praise God!\n\n[VERSE 2]\nAbakristu bonsi ng'imaria amang'ana\nToberete eng'ana ya iguru lelo\nYeso omonene agotomora amabera\nWay to heaven through Christ alone!\n\n[OUTRO]\nNyanchwa Choir Adventist Hymnal!",
                'english_translation' => "The narrow road to heaven through Jesus Christ!",
            ],
            [
                'artist_id' => $kebaso->id,
                'genre_id' => $traditional->id,
                'title' => 'Obomanyi Bwa Gusii (Gusii Wisdom)',
                'slug' => 'obomanyi-bwa-gusii',
                'cover_image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=80',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'views_count' => 13800,
                'likes_count' => 970,
                'release_year' => 2015,
                'is_featured' => false,
                'lyrics_raw' => "[INTRO]\nObomanyi bwa Gusii obokano harp folklore!\nKebaso Moriasi traditional legend!\n\n[VERSE 1]\nSokoro wetu nigo agokwana amang'ana\nObomanyi bwomogusii bwa kare kare\nObokano nigo ekogamba amabera\nAbamura ng'imaria amang'ana yobokano\n\n[CHORUS]\nObomanyi Bwa Gusii wisdom of our ancestors!\nEmamba yobokano nigo ekogamba!\nAbagusii heritage preservation\nKebaso Moriasi Obokano master!\n\n[VERSE 2]\nChinchera chia sokoro wetu enka\nTotiga oborore bwa Abagusii\nObokano bwa Mugirango na South Mugirango\nPreserve Gusii culture and history!\n\n[OUTRO]\nObomanyi bwa Gusii traditional archive!",
                'english_translation' => "Wisdom of our Gusii ancestors handed down through generations!",
            ]
        ];

        foreach ($songsData as $songData) {
            Song::updateOrCreate(
                ['slug' => $songData['slug']],
                $songData
            );
        }
    }
}
