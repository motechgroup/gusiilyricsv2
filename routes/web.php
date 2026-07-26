<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\VisitorActionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoryController;

// SEO Crawlability Routes (Multi-file XML Sitemaps & Robots.txt)
Route::get('/sitemap.xml', [SeoController::class, 'indexSitemap'])->name('seo.sitemap');
Route::get('/sitemap-pages.xml', [SeoController::class, 'pagesSitemap'])->name('seo.sitemap.pages');
Route::get('/sitemap-categories.xml', [SeoController::class, 'categoriesSitemap'])->name('seo.sitemap.categories');
Route::get('/sitemap-artists.xml', [SeoController::class, 'artistsSitemap'])->name('seo.sitemap.artists');
Route::get('/sitemap-albums.xml', [SeoController::class, 'albumsSitemap'])->name('seo.sitemap.albums');
Route::get('/sitemap-songs.xml', [SeoController::class, 'songsSitemap'])->name('seo.sitemap.songs');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

// M-Pesa Callback Endpoint (Exempt from CSRF)
Route::post('/api/mpesa/callback', [MpesaController::class, 'callback'])->name('api.mpesa.callback');

// Public Pages (With TrackVisitor Analytics Middleware)
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Clean PRD SEO Route Architecture
    Route::get('/lyrics', [SongController::class, 'index'])->name('songs.index');
    Route::get('/songs', [SongController::class, 'index']);
    Route::get('/lyrics/{artistSlug}/{songSlug}', [SongController::class, 'showNested'])->name('songs.show-nested');
    Route::get('/songs/{slug}', [SongController::class, 'show'])->name('songs.show');

    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::get('/artists/{slug}', [ArtistController::class, 'show'])->name('artists.show');

    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');

    Route::get('/genres', [CategoryController::class, 'genresIndex'])->name('genres.index');
    Route::get('/genres/{slug}', [CategoryController::class, 'genreShow'])->name('categories.genre');

    // PRD SEO Landing Categories
    Route::get('/top-gusii-songs', [CategoryController::class, 'topGusiiSongs'])->name('categories.top-100');
    Route::get('/latest-songs', [CategoryController::class, 'latestSongs'])->name('categories.latest');
    Route::get('/gospel', [CategoryController::class, 'gospel'])->name('categories.gospel');
    Route::get('/love-songs', [CategoryController::class, 'loveSongs'])->name('categories.love-songs');
    Route::get('/traditional', [CategoryController::class, 'traditional'])->name('categories.traditional');
    Route::get('/wedding-songs', [CategoryController::class, 'weddingSongs'])->name('categories.wedding');
    Route::get('/most-viewed-songs', [CategoryController::class, 'mostViewed'])->name('categories.most-viewed');
    Route::get('/trending-artists', [CategoryController::class, 'trendingArtists'])->name('categories.trending-artists');
    Route::get('/new-releases', [CategoryController::class, 'latestSongs'])->name('categories.new-releases');

    // Dedicated Public Legal Pages
    Route::get('/terms', [LegalPageController::class, 'terms'])->name('pages.terms');
    Route::get('/privacy', [LegalPageController::class, 'privacy'])->name('pages.privacy');

    // Dedicated Public Advertise With Us Page
    Route::get('/advertise', [AdvertisementController::class, 'showPublicAdvertise'])->name('advertise');
    Route::post('/advertise', [AdvertisementController::class, 'submitInquiry'])->name('advertise.store');

    // Dedicated Promote Your Music Page
    Route::get('/promote-music', [AdvertisementController::class, 'showPromoteMusic'])->name('promote-music');
    Route::post('/promote-music', [AdvertisementController::class, 'submitMusicPromotion'])->name('promote-music.store');

    // Dedicated Public Donation / Support Page
    Route::get('/donate', [DonationController::class, 'showPublicDonate'])->name('donate');
    Route::post('/donate', [DonationController::class, 'storePublicDonation'])->name('donate.store');
    Route::post('/api/mpesa/stkpush', [MpesaController::class, 'stkPush'])->name('api.mpesa.stkpush');
    Route::post('/donate/stk-push', [MpesaController::class, 'stkPush'])->name('donate.stk-push');

    // Visitor Actions
    Route::post('/actions/request-lyric', [VisitorActionController::class, 'requestLyric'])->name('actions.request-lyric');
    Route::post('/actions/submit-correction', [VisitorActionController::class, 'submitCorrection'])->name('actions.submit-correction');
    Route::post('/api/songs/{id}/like', [SongController::class, 'like'])->name('songs.like');
    Route::post('/api/songs/{id}/track-click', [SongController::class, 'trackClick'])->name('songs.track-click');
    Route::get('/api/search', [SongController::class, 'searchApi'])->name('api.search');
});

// Staff Auth & Password Reset Routes (Custom Portal: /mkuu)
Route::get('/mkuu', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/mkuu', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/mkuu/forgot-password', [AdminController::class, 'showForgotPassword'])->name('admin.password.request');
Route::post('/mkuu/forgot-password', [AdminController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/mkuu/reset-password/{token}', [AdminController::class, 'showResetPassword'])->name('admin.password.reset');
Route::post('/mkuu/reset-password', [AdminController::class, 'resetPassword'])->name('admin.password.update');

// Legacy login redirect
Route::get('/admin/login', function() {
    return redirect()->route('admin.login');
});

// Staff Panel (Accessible by Super Admin and Editors)
Route::middleware(\App\Http\Middleware\AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Song Lyrics Management (Editors & Admin)
    Route::get('/songs', [AdminController::class, 'songsIndex'])->name('songs.index');
    Route::get('/songs/create', [AdminController::class, 'songsCreate'])->name('songs.create');
    Route::post('/songs', [AdminController::class, 'songsStore'])->name('songs.store');
    Route::get('/songs/{id}/edit', [AdminController::class, 'songsEdit'])->name('songs.edit');
    Route::put('/songs/{id}', [AdminController::class, 'songsUpdate'])->name('songs.update');
    Route::delete('/songs/{id}', [AdminController::class, 'songsDestroy'])->name('songs.destroy');

    // Artists Management (Editors & Admin)
    Route::get('/artists', [AdminController::class, 'artistsIndex'])->name('artists.index');
    Route::get('/artists/create', [AdminController::class, 'artistsCreate'])->name('artists.create');
    Route::post('/artists', [AdminController::class, 'artistsStore'])->name('artists.store');
    Route::get('/artists/{id}/edit', [AdminController::class, 'artistsEdit'])->name('artists.edit');
    Route::put('/artists/{id}', [AdminController::class, 'artistsUpdate'])->name('artists.update');
    Route::delete('/artists/{id}', [AdminController::class, 'artistsDestroy'])->name('artists.destroy');

    // Requests & Corrections (Editors & Admin)
    Route::get('/requests', [AdminController::class, 'requestsIndex'])->name('requests.index');
    Route::post('/requests/{id}/status', [AdminController::class, 'requestsUpdateStatus'])->name('requests.status');
    Route::get('/corrections', [AdminController::class, 'correctionsIndex'])->name('corrections.index');
    Route::post('/corrections/{id}/status', [AdminController::class, 'correctionsUpdateStatus'])->name('corrections.status');

    // Staff/Admin User Self Profile Management
    Route::get('/profile', [AdminController::class, 'profileIndex'])->name('profile.index');
    Route::put('/profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'passwordUpdate'])->name('profile.password');

    // Super Admin Exclusives (Site Settings, Ad Inquiries, Pages Manager, Analytics Page, Donations Manager & Staff Accounts)
    Route::middleware(\App\Http\Middleware\SuperAdminOnly::class)->group(function () {
        Route::get('/analytics', [AdminController::class, 'analyticsIndex'])->name('analytics.index');

        Route::get('/donations', [AdminController::class, 'donationsIndex'])->name('donations.index');
        Route::post('/donations', [AdminController::class, 'donationsStore'])->name('donations.store');
        Route::post('/donations/{id}/status', [AdminController::class, 'donationsUpdateStatus'])->name('donations.status');
        Route::delete('/donations/{id}', [AdminController::class, 'donationsDestroy'])->name('donations.destroy');

        Route::get('/ad-inquiries', [AdminController::class, 'adInquiriesIndex'])->name('ad-inquiries.index');
        Route::post('/ad-inquiries/{id}/status', [AdminController::class, 'adInquiriesUpdateStatus'])->name('ad-inquiries.status');
        Route::delete('/ad-inquiries/{id}', [AdminController::class, 'adInquiriesDestroy'])->name('ad-inquiries.destroy');

        Route::get('/ads', [AdminController::class, 'adsIndex'])->name('ads.index');
        Route::get('/ads/create', [AdminController::class, 'adsCreate'])->name('ads.create');
        Route::post('/ads', [AdminController::class, 'adsStore'])->name('ads.store');
        Route::get('/ads/{id}/edit', [AdminController::class, 'adsEdit'])->name('ads.edit');
        Route::put('/ads/{id}', [AdminController::class, 'adsUpdate'])->name('ads.update');
        Route::post('/ads/{id}/toggle', [AdminController::class, 'adsToggleActive'])->name('ads.toggle');
        Route::delete('/ads/{id}', [AdminController::class, 'adsDestroy'])->name('ads.destroy');

        // Music Promotions & Campaign Analytics Manager
        Route::get('/promotions', [AdminController::class, 'promotionsIndex'])->name('promotions.index');
        Route::post('/promotions', [AdminController::class, 'promotionsStore'])->name('promotions.store');
        Route::post('/promotions/{id}/status', [AdminController::class, 'promotionsUpdateStatus'])->name('promotions.status');
        Route::delete('/promotions/{id}', [AdminController::class, 'promotionsDestroy'])->name('promotions.destroy');

        // Manage Music Genres & Categories
        Route::get('/genres', [AdminController::class, 'genresIndex'])->name('genres.index');
        Route::post('/genres', [AdminController::class, 'genresStore'])->name('genres.store');
        Route::put('/genres/{id}', [AdminController::class, 'genresUpdate'])->name('genres.update');
        Route::delete('/genres/{id}', [AdminController::class, 'genresDestroy'])->name('genres.destroy');

        Route::get('/pages', [AdminController::class, 'pagesIndex'])->name('pages.index');
        Route::get('/pages/{slug}/edit', [AdminController::class, 'pagesEdit'])->name('pages.edit');
        Route::put('/pages/{slug}', [AdminController::class, 'pagesUpdate'])->name('pages.update');

        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

        Route::get('/settings', [AdminController::class, 'settingsIndex'])->name('settings.index');
        Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
        Route::post('/settings/test-email', [AdminController::class, 'testSmtp'])->name('settings.test-email');

        Route::get('/docs', [AdminController::class, 'docsIndex'])->name('docs.index');
    });
});

// Shared Hosting Web Migration & Cache Clearance Runner (Triggerable via Browser)
Route::get('/run-migrations', function (\Illuminate\Http\Request $request) {
    $secret = $request->query('key', '');
    if ($secret !== 'gusii2026' && !auth()->check()) {
        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:550px;margin:50px auto;text-align:center;"><h2>🔒 Access Restricted</h2><p style="color:#94a3b8;">Please append your secret key to the browser URL:</p><p><code style="color:#10b981;font-weight:bold;">https://gusiilyrics.com/run-migrations?key=gusii2026</code></p></div>', 403);
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:650px;margin:50px auto;border:1px solid #10b981;"><h2 style="color:#10b981;">✅ Migrations Executed Successfully!</h2><p style="color:#ccc;">All database tables have been created / updated on your shared hosting environment.</p><pre style="background:#111a2e;padding:15px;border-radius:10px;color:#a7f3d0;text-align:left;overflow-x:auto;">' . htmlspecialchars($output ?: 'No pending migrations to run. All tables up to date!') . '</pre><a href="/mkuu" style="display:inline-block;margin-top:15px;padding:12px 24px;background:#10b981;color:#090d16;font-weight:bold;text-decoration:none;border-radius:10px;">Return to Admin Panel &rarr;</a></div>');
    } catch (\Throwable $e) {
        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:650px;margin:50px auto;border:1px solid #f43f5e;"><h2 style="color:#f43f5e;">❌ Migration Error</h2><p style="color:#ccc;">Error details:</p><pre style="background:#111a2e;padding:15px;border-radius:10px;color:#fca5a5;text-align:left;overflow-x:auto;">' . htmlspecialchars($e->getMessage()) . '</pre></div>', 500);
    }
})->name('run-migrations');

// Shared Hosting Storage Symlink Runner (Triggerable via Browser)
Route::get('/storage-link', function (\Illuminate\Http\Request $request) {
    $secret = $request->query('key', '');
    if ($secret !== 'gusii2026' && !auth()->check()) {
        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:550px;margin:50px auto;text-align:center;"><h2>🔒 Access Restricted</h2><p style="color:#94a3b8;">Please append your secret key to the browser URL:</p><p><code style="color:#10b981;font-weight:bold;">https://gusiilyrics.com/storage-link?key=gusii2026</code></p></div>', 403);
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $output = \Illuminate\Support\Facades\Artisan::output();

        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:650px;margin:50px auto;border:1px solid #10b981;"><h2 style="color:#10b981;">🔗 Storage Link Created Successfully!</h2><p style="color:#ccc;">Public storage directory has been linked to app storage on your shared hosting server.</p><pre style="background:#111a2e;padding:15px;border-radius:10px;color:#a7f3d0;text-align:left;overflow-x:auto;">' . htmlspecialchars($output ?: 'The [public/storage] link has been created.') . '</pre><a href="/mkuu/settings" style="display:inline-block;margin-top:15px;padding:12px 24px;background:#10b981;color:#090d16;font-weight:bold;text-decoration:none;border-radius:10px;">Return to Admin Panel &rarr;</a></div>');
    } catch (\Throwable $e) {
        return response('<div style="font-family:sans-serif;padding:30px;background:#090d16;color:#fff;border-radius:16px;max-width:650px;margin:50px auto;border:1px solid #f43f5e;"><h2 style="color:#f43f5e;">❌ Storage Link Error</h2><p style="color:#ccc;">Error details:</p><pre style="background:#111a2e;padding:15px;border-radius:10px;color:#fca5a5;text-align:left;overflow-x:auto;">' . htmlspecialchars($e->getMessage()) . '</pre></div>', 500);
    }
})->name('storage-link');
