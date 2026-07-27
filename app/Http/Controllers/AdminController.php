<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Correction;
use App\Models\Donation;
use App\Models\Genre;
use App\Models\LyricRequest;
use App\Models\MusicPromotion;
use App\Models\Setting;
use App\Models\Song;
use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // --- Auth ---
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = strtolower(trim($request->email));
        $password = $request->password;

        // Auto-seed admin user if missing from database
        if (User::where('role', 'admin')->count() === 0) {
            User::updateOrCreate(
                ['email' => 'admin@gusiilyrics.com'],
                ['name' => 'Super Admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
            );
            User::updateOrCreate(
                ['email' => 'editor@gusiilyrics.com'],
                ['name' => 'Gusii Lyrics Editor', 'password' => Hash::make('editor123'), 'role' => 'editor']
            );
        }

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            session(['admin_user_id' => $user->id]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->has('remember'))) {
            $request->session()->regenerate();
            session(['admin_user_id' => Auth::id()]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return redirect()->back()->withInput(['email' => $email])->with('error', 'Invalid email address or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('admin_user_id');
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    // --- Password Reset ---
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'We could not find an account registered with that email address.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetUrl = route('admin.password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::send('emails.password-reset', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)->subject('Gusii Lyrics Staff Password Reset Request');
            });

            return redirect()->back()->with('success', 'A password reset link has been sent to your email address!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'SMTP Error sending email: ' . $e->getMessage() . '. Please verify your SMTP settings.');
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return redirect()->back()->with('error', 'Invalid or expired password reset token.');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Staff user account not found.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been reset successfully! You may now sign in.');
    }

    // --- Dashboard ---
    public function dashboard()
    {
        $user = Auth::user();

        if ($user && $user->isEditor()) {
            return redirect()->route('admin.songs.index');
        }

        $stats = [
            'total_songs' => Song::count(),
            'total_artists' => Artist::count(),
            'pending_requests' => LyricRequest::where('status', 'pending')->count(),
            'pending_corrections' => Correction::where('status', 'pending')->count(),
        ];

        $today = Carbon::today();
        $totalLogs = max(1, VisitorLog::count());
        $mobileCount = VisitorLog::where('device_type', 'mobile')->count();
        $desktopCount = VisitorLog::where('device_type', 'desktop')->count();

        $analytics = [
            'today_pageviews' => VisitorLog::whereDate('created_at', $today)->count(),
            'today_unique_ips' => VisitorLog::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address'),
            'total_pageviews' => VisitorLog::count(),
            'total_unique_ips' => VisitorLog::distinct('ip_address')->count('ip_address'),
            'mobile_pct' => round(($mobileCount / $totalLogs) * 100),
            'desktop_pct' => round(($desktopCount / $totalLogs) * 100),
            'top_referrers' => VisitorLog::select('referrer', DB::raw('count(*) as total'))
                ->whereNotNull('referrer')
                ->where('referrer', '!=', '')
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
        ];

        $mostViewedSongs = Song::with('artist')->orderByDesc('views_count')->take(5)->get();
        $recentRequests = LyricRequest::latest()->take(5)->get();
        $recentCorrections = Correction::with('song')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'analytics', 'mostViewedSongs', 'recentRequests', 'recentCorrections'));
    }

    // --- Dedicated Site Analytics Dashboard Page ---
    public function analyticsIndex()
    {
        $today = Carbon::today();
        
        $metrics = [
            'today_pageviews' => VisitorLog::whereDate('created_at', $today)->count(),
            'today_unique_ips' => VisitorLog::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address'),
            'total_pageviews' => VisitorLog::count(),
            'total_unique_ips' => VisitorLog::distinct('ip_address')->count('ip_address'),
        ];

        $totalLogs = max(1, $metrics['total_pageviews']);
        $mobileCount = VisitorLog::where('device_type', 'mobile')->count();
        $desktopCount = VisitorLog::where('device_type', 'desktop')->count();
        $tabletCount = VisitorLog::where('device_type', 'tablet')->count();

        $metrics['mobile_pct'] = round(($mobileCount / $totalLogs) * 100);
        $metrics['desktop_pct'] = round(($desktopCount / $totalLogs) * 100);
        $metrics['tablet_pct'] = round(($tabletCount / $totalLogs) * 100);

        $topReferrers = VisitorLog::select('referrer', DB::raw('count(*) as total'))
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $popularSongs = Song::with('artist')->orderByDesc('views_count')->take(10)->get();
        $recentLogs = VisitorLog::latest()->paginate(20);

        return view('admin.analytics.index', compact('metrics', 'topReferrers', 'popularSongs', 'recentLogs'));
    }

    // --- Donations Management Portal ---
    public function donationsIndex(Request $request)
    {
        $query = Donation::latest();

        if ($request->gateway) {
            $query->where('gateway', $request->gateway);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(15)->withQueryString();

        $totals = [
            'total_kes' => Donation::where('status', 'completed')->where('currency', 'KES')->sum('amount'),
            'total_usd' => Donation::where('status', 'completed')->where('currency', 'USD')->sum('amount'),
            'count_completed' => Donation::where('status', 'completed')->count(),
            'count_pending' => Donation::where('status', 'pending')->count(),
        ];

        return view('admin.donations.index', compact('donations', 'totals'));
    }

    public function donationsStore(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:KES,USD',
            'gateway' => 'required|string|in:mpesa,stripe,manual',
            'transaction_reference' => 'nullable|string|max:255',
            'status' => 'required|string|in:completed,pending,refunded',
            'notes' => 'nullable|string',
        ]);

        Donation::create($validated);

        return redirect()->back()->with('success', 'Donation record added successfully!');
    }

    public function donationsUpdateStatus(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Donation status updated.');
    }

    public function donationsDestroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->back()->with('success', 'Donation record removed.');
    }

    // --- Staff Management ---
    public function usersIndex()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,editor',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Staff account created successfully!');
    }

    public function usersDestroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account.');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Staff account deleted.');
    }

    // --- Profile Management ---
    public function profileIndex()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile information updated successfully!');
    }

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Account password updated successfully!');
    }

    // --- Song CRUD ---
    public function songsIndex(Request $request)
    {
        $query = Song::with(['artist', 'genre']);

        if ($request->filled('q')) {
            $term = '%' . trim($request->q) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('lyrics_raw', 'like', $term)
                  ->orWhereHas('artist', function ($artQ) use ($term) {
                      $artQ->where('name', 'like', $term);
                  });
            });
        }

        if ($request->filled('artist_id')) {
            $query->where('artist_id', $request->artist_id);
        }

        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->filter === 'trending') {
                $query->where('is_trending', true);
            } elseif ($request->filter === 'promoted') {
                $query->where('is_promoted', true);
            }
        }

        $songs = $query->latest()->paginate(15)->withQueryString();
        $artists = Artist::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('admin.songs.index', compact('songs', 'artists', 'genres'));
    }

    public function songsCreate()
    {
        $artists = Artist::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        return view('admin.songs.create', compact('artists', 'genres'));
    }

    public function songsStore(Request $request)
    {
        $validated = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'collaborator_ids' => 'nullable|array',
            'collaborator_ids.*' => 'exists:artists,id',
            'title' => 'required|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'lyrics_raw' => 'required|string',
            'spotify_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'apple_music_url' => 'nullable|url',
            'cover_file' => 'nullable|image|max:5120',
            'cover_image' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('uploads/covers', 'public');
            $validated['cover_image'] = '/storage/' . $path;
        }

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_trending'] = $request->has('is_trending');

        $song = Song::create($validated);

        if ($request->has('collaborator_ids')) {
            $song->artists()->sync($request->collaborator_ids);
        }

        return redirect()->route('admin.songs.index')->with('success', 'Song lyrics created successfully!');
    }

    public function songsEdit($id)
    {
        $song = Song::with('artists')->findOrFail($id);
        $artists = Artist::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        return view('admin.songs.edit', compact('song', 'artists', 'genres'));
    }

    public function songsUpdate(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        $validated = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'collaborator_ids' => 'nullable|array',
            'collaborator_ids.*' => 'exists:artists,id',
            'title' => 'required|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'lyrics_raw' => 'required|string',
            'spotify_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'apple_music_url' => 'nullable|url',
            'cover_file' => 'nullable|image|max:5120',
            'cover_image' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('uploads/covers', 'public');
            $validated['cover_image'] = '/storage/' . $path;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_trending'] = $request->has('is_trending');

        $song->update($validated);

        $collaboratorIds = $request->input('collaborator_ids', []);
        $song->artists()->sync($collaboratorIds);

        return redirect()->route('admin.songs.index')->with('success', 'Song lyrics updated successfully!');
    }

    public function songsDestroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return redirect()->route('admin.songs.index')->with('success', 'Song deleted.');
    }

    // --- Artist CRUD ---
    public function artistsIndex()
    {
        $artists = Artist::withCount('songs')->with('genre')->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.artists.index', compact('artists'));
    }

    public function artistsCreate()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.artists.create', compact('genres'));
    }

    public function artistsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:artist,band,choir,group',
            'genre_id' => 'nullable|exists:genres,id',
            'location' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'active_years' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:500',
            'facebook' => 'nullable|url|max:500',
            'instagram' => 'nullable|url|max:500',
            'spotify' => 'nullable|url|max:500',
            'tiktok' => 'nullable|url|max:500',
            'twitter' => 'nullable|url|max:500',
            'bio' => 'nullable|string',
            'image_file' => 'nullable|image|max:5120',
            'image' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['type'])) {
            $validated['type'] = 'artist';
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artists'), $filename);
            @mkdir(storage_path('app/public/uploads/artists'), 0777, true);
            @copy(public_path('uploads/artists/' . $filename), storage_path('app/public/uploads/artists/' . $filename));
            $validated['image'] = '/uploads/artists/' . $filename;
        } elseif ($request->filled('image')) {
            $validated['image'] = trim($request->image);
        }

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        $validated['is_featured'] = $request->has('is_featured');

        Artist::create($validated);

        return redirect()->route('admin.artists.index')->with('success', 'Artist profile created!');
    }

    public function artistsEdit($id)
    {
        $artist = Artist::findOrFail($id);
        $genres = Genre::orderBy('name')->get();
        return view('admin.artists.edit', compact('artist', 'genres'));
    }

    public function artistsUpdate(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:artist,band,choir,group',
            'genre_id' => 'nullable|exists:genres,id',
            'location' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'active_years' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:500',
            'facebook' => 'nullable|url|max:500',
            'instagram' => 'nullable|url|max:500',
            'spotify' => 'nullable|url|max:500',
            'tiktok' => 'nullable|url|max:500',
            'twitter' => 'nullable|url|max:500',
            'bio' => 'nullable|string',
            'image_file' => 'nullable|image|max:5120',
            'image' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['type'])) {
            $validated['type'] = 'artist';
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artists'), $filename);
            @mkdir(storage_path('app/public/uploads/artists'), 0777, true);
            @copy(public_path('uploads/artists/' . $filename), storage_path('app/public/uploads/artists/' . $filename));
            $validated['image'] = '/uploads/artists/' . $filename;
        } elseif ($request->filled('image')) {
            $validated['image'] = trim($request->image);
        }

        $validated['is_featured'] = $request->has('is_featured');

        $artist->update($validated);

        return redirect()->route('admin.artists.index')->with('success', 'Artist profile updated!');
    }

    public function artistsDestroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Artist deleted.');
    }

    // --- Genre CRUD ---
    public function genresIndex()
    {
        $genres = Genre::withCount('songs')->orderBy('name')->get();
        return view('admin.genres.index', compact('genres'));
    }

    public function genresStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['icon'] = $validated['icon'] ?: '🎵';

        Genre::create($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Music Genre created successfully!');
    }

    public function genresUpdate(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        if ($request->filled('icon')) {
            $validated['icon'] = $request->icon;
        }

        $genre->update($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Music Genre updated successfully!');
    }

    public function genresDestroy($id)
    {
        $genre = Genre::findOrFail($id);
        Song::where('genre_id', $id)->update(['genre_id' => null]);
        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Music Genre deleted successfully!');
    }

    // --- Requests ---
    public function requestsIndex()
    {
        $requests = LyricRequest::latest()->paginate(15)->withQueryString();
        return view('admin.requests.index', compact('requests'));
    }

    public function requestsUpdateStatus(Request $request, $id)
    {
        $req = LyricRequest::findOrFail($id);
        $oldStatus = $req->status;
        $req->update(['status' => $request->status]);

        if (!empty($req->visitor_email)) {
            try {
                $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
                $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');
                
                $heading = $request->status === 'fulfilled' ? '🎵 Requested Song Lyric Is Now Published!' : 'Update on Your Lyric Request';
                $intro = $request->status === 'fulfilled' 
                    ? "Mbuya mono! The Ekegusii song lyric '{$req->song_title}' by '{$req->artist_name}' you requested has been transcribed and published on Gusii Lyrics Vault." 
                    : "Regarding your lyric request for '{$req->song_title}' by '{$req->artist_name}', its status has been updated to {$request->status}.";

                Mail::send('emails.status-update', [
                    'recipientName' => 'Music Lover',
                    'heading' => $heading,
                    'introMessage' => $intro,
                    'itemTitle' => "{$req->song_title} - {$req->artist_name}",
                    'newStatus' => strtoupper($request->status),
                    'actionUrl' => route('songs.index', ['q' => $req->song_title]),
                    'actionText' => 'Search Lyrics Vault',
                ], function ($message) use ($req, $fromAddress, $fromName, $heading) {
                    $message->to($req->visitor_email)
                        ->from($fromAddress, $fromName)
                        ->subject($heading . ' - Gusii Lyrics');
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed sending request status email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Lyric request status updated & notification email sent!');
    }

    // --- Corrections ---
    public function correctionsIndex()
    {
        $corrections = Correction::with('song')->latest()->paginate(15)->withQueryString();
        return view('admin.corrections.index', compact('corrections'));
    }

    public function correctionsUpdateStatus(Request $request, $id)
    {
        $cor = Correction::findOrFail($id);
        $cor->update(['status' => $request->status]);

        if (!empty($cor->visitor_email)) {
            try {
                $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
                $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');
                $songTitle = $cor->song->title ?? 'Ekegusii Song';

                Mail::send('emails.status-update', [
                    'recipientName' => $cor->visitor_name ?? 'Contributor',
                    'heading' => '🙌 Thank You For Your Lyric Correction!',
                    'introMessage' => "Mbuya mono! Our editorial team has reviewed your correction report for '{$songTitle}'. Thank you for helping keep Omogusii lyrics accurate!",
                    'itemTitle' => "Correction Report: {$songTitle}",
                    'newStatus' => strtoupper($request->status),
                    'actionUrl' => $cor->song ? route('songs.show', $cor->song->slug) : route('home'),
                    'actionText' => 'View Updated Song Lyrics',
                ], function ($message) use ($cor, $fromAddress, $fromName) {
                    $message->to($cor->visitor_email)
                        ->from($fromAddress, $fromName)
                        ->subject('Lyric Correction Reviewed - Gusii Lyrics');
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed sending correction status email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Correction status updated & notification email sent!');
    }

    // --- Site Settings ---
    public function settingsIndex()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Gusii Lyrics'),
            'site_logo' => Setting::get('site_logo', '/images/logo.png'),
            'favicon' => Setting::get('favicon', '/images/favicon.png'),
            'seo_title' => Setting::get('seo_title', 'Gusii Lyrics - Ekegusii Song Lyrics'),
            'seo_description' => Setting::get('seo_description', 'Discover Ekegusii lyrics and stream links.'),
            'seo_keywords' => Setting::get('seo_keywords', 'Ekegusii lyrics, Kisii songs'),
            'preset_donation_amounts' => Setting::get('preset_donation_amounts', '100, 250, 500, 1000, 2500, 5000'),
            'google_analytics_id' => Setting::get('google_analytics_id', ''),
            'google_adsense_code' => Setting::get('google_adsense_code', ''),
            'meta_pixel_id' => Setting::get('meta_pixel_id', ''),
            'mpesa_env' => Setting::get('mpesa_env', 'sandbox'),
            'enable_mpesa' => Setting::get('enable_mpesa', '1'),
            'mpesa_consumer_key' => Setting::get('mpesa_consumer_key', ''),
            'mpesa_consumer_secret' => Setting::get('mpesa_consumer_secret', ''),
            'mpesa_passkey' => Setting::get('mpesa_passkey', ''),
            'mpesa_shortcode' => Setting::get('mpesa_shortcode', ''),
            'mpesa_till' => Setting::get('mpesa_till', ''),
            'mpesa_paybill' => Setting::get('mpesa_paybill', ''),
            'enable_stripe' => Setting::get('enable_stripe', '1'),
            'stripe_publishable_key' => Setting::get('stripe_publishable_key', ''),
            'stripe_secret_key' => Setting::get('stripe_secret_key', ''),
            'stripe_webhook_secret' => Setting::get('stripe_webhook_secret', ''),
            'stripe_url' => Setting::get('stripe_url', ''),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_x' => Setting::get('social_x', ''),
            'social_youtube' => Setting::get('social_youtube', ''),
            'social_tiktok' => Setting::get('social_tiktok', ''),
            'mail_mailer' => Setting::get('mail_mailer', 'smtp'),
            'mail_host' => Setting::get('mail_host', '127.0.0.1'),
            'mail_port' => Setting::get('mail_port', '587'),
            'mail_username' => Setting::get('mail_username', ''),
            'mail_password' => Setting::get('mail_password', ''),
            'mail_encryption' => Setting::get('mail_encryption', 'tls'),
            'mail_from_address' => Setting::get('mail_from_address', 'info@gusiilyrics.com'),
            'mail_from_name' => Setting::get('mail_from_name', 'Gusii Lyrics'),
            'footer_description' => Setting::get('footer_description', 'Preserving Gusii music heritage, song lyrics, translations, and official streaming links for Omogusii worldwide.'),
            'app_download_enabled' => Setting::get('app_download_enabled', '1'),
            'app_banner_title' => Setting::get('app_banner_title', 'Take Gusii Lyrics Everywhere! Download Our Mobile App'),
            'app_banner_subtitle' => Setting::get('app_banner_subtitle', 'Stream Ekegusii song lyrics, translations, audio previews, and artist profiles offline on Android & iOS.'),
            'app_play_store_url' => Setting::get('app_play_store_url', '#'),
            'app_app_store_url' => Setting::get('app_app_store_url', '#'),
            'app_direct_apk_url' => Setting::get('app_direct_apk_url', '#'),
            'social_stat_web_traffic' => Setting::get('social_stat_web_traffic', '150,000+'),
            'social_stat_web_label' => Setting::get('social_stat_web_label', 'Monthly Web Traffic'),
            'social_stat_youtube_subscribers' => Setting::get('social_stat_youtube_subscribers', '25,000+'),
            'social_stat_youtube_label' => Setting::get('social_stat_youtube_label', 'YouTube Subscribers'),
            'social_stat_instagram_followers' => Setting::get('social_stat_instagram_followers', '18,500+'),
            'social_stat_instagram_label' => Setting::get('social_stat_instagram_label', 'Instagram Followers'),
            'social_stat_tiktok_community' => Setting::get('social_stat_tiktok_community', '32,000+'),
            'social_stat_tiktok_label' => Setting::get('social_stat_tiktok_label', 'TikTok Community'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $section = $request->input('section_type', 'all');

        // 8. Promote Music Page Social Reach Cards Section
        if ($section === 'social_stats') {
            if ($request->has('social_stat_web_traffic')) Setting::set('social_stat_web_traffic', $request->social_stat_web_traffic);
            if ($request->has('social_stat_web_label')) Setting::set('social_stat_web_label', $request->social_stat_web_label);
            if ($request->has('social_stat_youtube_subscribers')) Setting::set('social_stat_youtube_subscribers', $request->social_stat_youtube_subscribers);
            if ($request->has('social_stat_youtube_label')) Setting::set('social_stat_youtube_label', $request->social_stat_youtube_label);
            if ($request->has('social_stat_instagram_followers')) Setting::set('social_stat_instagram_followers', $request->social_stat_instagram_followers);
            if ($request->has('social_stat_instagram_label')) Setting::set('social_stat_instagram_label', $request->social_stat_instagram_label);
            if ($request->has('social_stat_tiktok_community')) Setting::set('social_stat_tiktok_community', $request->social_stat_tiktok_community);
            if ($request->has('social_stat_tiktok_label')) Setting::set('social_stat_tiktok_label', $request->social_stat_tiktok_label);

            return redirect()->back()->with('success', 'Social reach cards statistics updated successfully!');
        }

        // 1. Site Branding & Donation Presets Section
        if ($section === 'branding' || $request->hasFile('site_logo_file') || $request->hasFile('favicon_file')) {
            $request->validate([
                'site_logo_file' => 'nullable|image|max:5120',
                'favicon_file' => 'nullable|file|mimes:ico,png,jpg,svg|max:2048',
            ]);

            if ($request->hasFile('site_logo_file')) {
                $path = $request->file('site_logo_file')->store('uploads/branding', 'public');
                Setting::set('site_logo', '/storage/' . $path);
            }

            if ($request->hasFile('favicon_file')) {
                $path = $request->file('favicon_file')->store('uploads/branding', 'public');
                Setting::set('favicon', '/storage/' . $path);
            }

            if ($request->has('site_name')) Setting::set('site_name', $request->site_name);
            if ($request->has('footer_description')) Setting::set('footer_description', $request->footer_description);
            if ($request->has('preset_donation_amounts')) Setting::set('preset_donation_amounts', $request->preset_donation_amounts ?? '100, 250, 500, 1000, 2500, 5000');

            return redirect()->back()->with('success', 'Site Branding & Presets saved successfully!');
        }

        // 2. M-Pesa STK Push Section
        if ($section === 'mpesa') {
            Setting::set('enable_mpesa', $request->has('enable_mpesa') ? '1' : '0');
            if ($request->has('mpesa_env')) Setting::set('mpesa_env', $request->mpesa_env);
            if ($request->has('mpesa_consumer_key')) Setting::set('mpesa_consumer_key', $request->mpesa_consumer_key);
            if ($request->has('mpesa_consumer_secret')) Setting::set('mpesa_consumer_secret', $request->mpesa_consumer_secret);
            if ($request->has('mpesa_passkey')) Setting::set('mpesa_passkey', $request->mpesa_passkey);
            if ($request->has('mpesa_shortcode')) Setting::set('mpesa_shortcode', $request->mpesa_shortcode);
            if ($request->has('mpesa_till')) Setting::set('mpesa_till', $request->mpesa_till);
            if ($request->has('mpesa_paybill')) Setting::set('mpesa_paybill', $request->mpesa_paybill);

            return redirect()->back()->with('success', 'M-Pesa STK Push API credentials saved successfully!');
        }

        // 3. Stripe API Credentials Section
        if ($section === 'stripe') {
            Setting::set('enable_stripe', $request->has('enable_stripe') ? '1' : '0');
            if ($request->has('stripe_publishable_key')) Setting::set('stripe_publishable_key', $request->stripe_publishable_key);
            if ($request->has('stripe_secret_key')) Setting::set('stripe_secret_key', $request->stripe_secret_key);
            if ($request->has('stripe_webhook_secret')) Setting::set('stripe_webhook_secret', $request->stripe_webhook_secret);
            if ($request->has('stripe_url')) Setting::set('stripe_url', $request->stripe_url);

            return redirect()->back()->with('success', 'Stripe API credentials saved successfully!');
        }

        // 4. Social Media Links Section
        if ($section === 'social') {
            if ($request->has('social_facebook')) Setting::set('social_facebook', $request->social_facebook);
            if ($request->has('social_instagram')) Setting::set('social_instagram', $request->social_instagram);
            if ($request->has('social_x')) Setting::set('social_x', $request->social_x);
            if ($request->has('social_youtube')) Setting::set('social_youtube', $request->social_youtube);
            if ($request->has('social_tiktok')) Setting::set('social_tiktok', $request->social_tiktok);

            return redirect()->back()->with('success', 'Social Media profiles saved successfully!');
        }

        // 5. SMTP Server Configuration Section
        if ($section === 'smtp') {
            if ($request->has('mail_mailer')) Setting::set('mail_mailer', $request->mail_mailer);
            if ($request->has('mail_host')) Setting::set('mail_host', $request->mail_host);
            if ($request->has('mail_port')) Setting::set('mail_port', $request->mail_port);
            if ($request->has('mail_username')) Setting::set('mail_username', $request->mail_username);
            if ($request->has('mail_password')) Setting::set('mail_password', $request->mail_password);
            if ($request->has('mail_encryption')) Setting::set('mail_encryption', $request->mail_encryption);
            if ($request->has('mail_from_address')) Setting::set('mail_from_address', $request->mail_from_address);
            if ($request->has('mail_from_name')) Setting::set('mail_from_name', $request->mail_from_name);
            if ($request->has('email_footer_text')) Setting::set('email_footer_text', $request->email_footer_text);

            return redirect()->back()->with('success', 'SMTP Mail Server configuration saved successfully!');
        }

        // 6. SEO & Analytics Section
        if ($section === 'seo') {
            if ($request->has('seo_title')) Setting::set('seo_title', $request->seo_title);
            if ($request->has('seo_description')) Setting::set('seo_description', $request->seo_description);
            if ($request->has('seo_keywords')) Setting::set('seo_keywords', $request->seo_keywords);
            if ($request->has('google_analytics_id')) Setting::set('google_analytics_id', $request->google_analytics_id);
            if ($request->has('google_adsense_code')) Setting::set('google_adsense_code', $request->google_adsense_code);
            if ($request->has('meta_pixel_id')) Setting::set('meta_pixel_id', $request->meta_pixel_id);

            return redirect()->back()->with('success', 'SEO & Analytics tracking saved successfully!');
        }

        // 7. Mobile App Downloads Section
        if ($section === 'mobile_app') {
            Setting::set('app_download_enabled', $request->has('app_download_enabled') ? '1' : '0');
            Setting::set('app_banner_title', $request->input('app_banner_title', 'Take Gusii Lyrics Everywhere! Download Our Mobile App'));
            Setting::set('app_banner_subtitle', $request->input('app_banner_subtitle', 'Stream Ekegusii song lyrics, translations, audio previews, and artist profiles offline on Android & iOS.'));
            Setting::set('app_play_store_url', $request->input('app_play_store_url', '#'));
            Setting::set('app_app_store_url', $request->input('app_app_store_url', '#'));
            Setting::set('app_direct_apk_url', $request->input('app_direct_apk_url', '#'));

            return redirect()->back()->with('success', 'Mobile App Download settings saved successfully!');
        }

        // Fallback for full save
        Setting::set('site_name', $request->site_name);
        Setting::set('seo_title', $request->seo_title);
        Setting::set('seo_description', $request->seo_description);
        Setting::set('seo_keywords', $request->seo_keywords);
        Setting::set('footer_description', $request->footer_description);
        Setting::set('preset_donation_amounts', $request->preset_donation_amounts ?? '100, 250, 500, 1000, 2500, 5000');
        Setting::set('google_analytics_id', $request->google_analytics_id);
        Setting::set('google_adsense_code', $request->google_adsense_code);
        Setting::set('meta_pixel_id', $request->meta_pixel_id);

        Setting::set('social_facebook', $request->social_facebook);
        Setting::set('social_instagram', $request->social_instagram);
        Setting::set('social_x', $request->social_x);
        Setting::set('social_youtube', $request->social_youtube);
        Setting::set('social_tiktok', $request->social_tiktok);

        Setting::set('mpesa_env', $request->mpesa_env ?? 'sandbox');
        Setting::set('mpesa_consumer_key', $request->mpesa_consumer_key);
        Setting::set('mpesa_consumer_secret', $request->mpesa_consumer_secret);
        Setting::set('mpesa_passkey', $request->mpesa_passkey);
        Setting::set('mpesa_shortcode', $request->mpesa_shortcode);
        Setting::set('mpesa_till', $request->mpesa_till);
        Setting::set('mpesa_paybill', $request->mpesa_paybill);

        Setting::set('stripe_publishable_key', $request->stripe_publishable_key);
        Setting::set('stripe_secret_key', $request->stripe_secret_key);
        Setting::set('stripe_webhook_secret', $request->stripe_webhook_secret);
        Setting::set('stripe_url', $request->stripe_url);

        Setting::set('mail_mailer', $request->mail_mailer ?? 'smtp');
        Setting::set('mail_host', $request->mail_host);
        Setting::set('mail_port', $request->mail_port ?? 587);
        Setting::set('mail_username', $request->mail_username);
        Setting::set('mail_password', $request->mail_password);
        Setting::set('mail_encryption', $request->mail_encryption ?? 'tls');
        Setting::set('mail_from_address', $request->mail_from_address);
        Setting::set('mail_from_name', $request->mail_from_name);

        return redirect()->back()->with('success', 'All settings saved successfully!');
    }

    public function testSmtp(Request $request)
    {
        $request->validate(['recipient' => 'required|email']);
        $recipient = trim($request->recipient);

        // Dynamically set mailer configurations from stored database settings
        $mailer = Setting::get('mail_mailer', 'smtp');
        $host = Setting::get('mail_host', '127.0.0.1');
        $port = Setting::get('mail_port', '587');
        $username = Setting::get('mail_username', '');
        $password = Setting::get('mail_password', '');
        $encryption = Setting::get('mail_encryption', 'tls');
        $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
        $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');

        $encLower = strtolower(trim((string)$encryption));
        $scheme = null;
        if (in_array($encLower, ['ssl', 'smtps']) || (int)$port === 465) {
            $scheme = 'smtps';
        } elseif (in_array($encLower, ['tls', 'smtp']) || (int)$port === 587) {
            $scheme = 'smtp';
        }

        config([
            'mail.default' => $mailer,
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $host,
            'mail.mailers.smtp.port' => (int)$port,
            'mail.mailers.smtp.username' => $username,
            'mail.mailers.smtp.password' => $password,
            'mail.mailers.smtp.scheme' => $scheme,
            'mail.from.address' => $fromAddress,
            'mail.from.name' => $fromName,
        ]);

        try {
            Mail::send('emails.test-smtp', [
                'recipient' => $recipient,
                'host' => $host,
                'port' => $port,
                'subject' => 'Gusii Lyrics - SMTP Connection Verification'
            ], function ($message) use ($recipient, $fromAddress, $fromName) {
                $message->to($recipient)
                    ->from($fromAddress, $fromName)
                    ->subject('Gusii Lyrics - SMTP Connection Verification');
            });

            return redirect()->back()->with('success', "SMTP Test Successful! Branded test email dispatched to {$recipient}.");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', "SMTP Connection Failed: " . $e->getMessage());
        }
    }

    // --- Mail Templates Management ---
    public function mailTemplatesIndex()
    {
        $templates = [
            [
                'id' => 'test-smtp',
                'name' => 'SMTP Connection Test Email',
                'description' => 'Dispatched when validating SMTP server connectivity and mail settings.',
                'subject' => 'Gusii Lyrics - SMTP Connection Verification',
                'view' => 'emails.test-smtp',
            ],
            [
                'id' => 'password-reset',
                'name' => 'Staff Password Reset Email',
                'description' => 'Sent to staff members requesting password reset links for the admin portal.',
                'subject' => 'Gusii Lyrics Staff Password Reset Request',
                'view' => 'emails.password-reset',
            ],
            [
                'id' => 'contact-notification',
                'name' => 'Visitor Contact Inquiry Notification',
                'description' => 'Alert email sent to site administration when a visitor submits a contact message.',
                'subject' => '✉️ New Visitor Contact Inquiry',
                'view' => 'emails.contact-notification',
            ],
            [
                'id' => 'music-promotion-notification',
                'name' => 'Music Promotion Submission Notification',
                'description' => 'Alert email sent to administration when an artist submits a song for promotion.',
                'subject' => '🚀 New Music Promotion Request',
                'view' => 'emails.music-promotion-notification',
            ],
        ];

        $settings = [
            'mail_from_name' => Setting::get('mail_from_name', 'Gusii Lyrics'),
            'mail_from_address' => Setting::get('mail_from_address', 'info@gusiilyrics.com'),
            'email_footer_text' => Setting::get('email_footer_text', 'Preserving Gusii music heritage, song lyrics, translations, and official streaming links for Omogusii worldwide.'),
        ];

        return view('admin.mail_templates.index', compact('templates', 'settings'));
    }

    public function mailTemplatesPreview($template)
    {
        $mockUser = (object)[
            'name' => 'Super Admin',
            'email' => 'admin@gusiilyrics.com',
        ];

        $data = match ($template) {
            'password-reset' => [
                'user' => $mockUser,
                'resetUrl' => route('admin.password.reset', ['token' => 'sample-token-12345', 'email' => 'admin@gusiilyrics.com']),
                'subject' => 'Gusii Lyrics Staff Password Reset Request',
            ],
            'contact-notification' => [
                'senderName' => 'Kwamboka Mokaya',
                'senderEmail' => 'kwamboka@example.com',
                'senderPhone' => '+254 712 345 678',
                'subject' => 'Inquiry regarding song lyrics submission',
                'messageText' => "Mbuya mono! I would like to know how I can submit new traditional Ekegusii lyrics to your platform.",
            ],
            'music-promotion-notification' => [
                'artistName' => 'Embarambamba',
                'artistType' => 'Gospel Choir / Solo Artist',
                'songTitle' => 'Bendera ya Yesu',
                'packageType' => 'Featured Homepage Banner + Social Blast',
                'senderEmail' => 'artist@gusiilyrics.com',
                'senderPhone' => '+254 700 112 233',
                'songUrl' => 'https://youtube.com/watch?v=demo123',
            ],
            default => [
                'recipient' => 'admin@gusiilyrics.com',
                'host' => Setting::get('mail_host', 'smtp.gusiilyrics.com'),
                'port' => Setting::get('mail_port', '587'),
                'subject' => 'Gusii Lyrics - SMTP Connection Verification',
            ],
        };

        $viewName = match ($template) {
            'password-reset' => 'emails.password-reset',
            'contact-notification' => 'emails.contact-notification',
            'music-promotion-notification' => 'emails.music-promotion-notification',
            default => 'emails.test-smtp',
        };

        return view($viewName, $data);
    }

    public function mailTemplatesSendTest(Request $request)
    {
        $request->validate([
            'template' => 'required|string',
            'recipient' => 'required|email',
        ]);

        $recipient = trim($request->recipient);
        $template = $request->template;

        $mailer = Setting::get('mail_mailer', 'smtp');
        $host = Setting::get('mail_host', '127.0.0.1');
        $port = Setting::get('mail_port', '587');
        $username = Setting::get('mail_username', '');
        $password = Setting::get('mail_password', '');
        $encryption = Setting::get('mail_encryption', 'tls');
        $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
        $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');

        $encLower = strtolower(trim((string)$encryption));
        $scheme = null;
        if (in_array($encLower, ['ssl', 'smtps']) || (int)$port === 465) {
            $scheme = 'smtps';
        } elseif (in_array($encLower, ['tls', 'smtp']) || (int)$port === 587) {
            $scheme = 'smtp';
        }

        config([
            'mail.default' => $mailer,
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $host,
            'mail.mailers.smtp.port' => (int)$port,
            'mail.mailers.smtp.username' => $username,
            'mail.mailers.smtp.password' => $password,
            'mail.mailers.smtp.scheme' => $scheme,
            'mail.from.address' => $fromAddress,
            'mail.from.name' => $fromName,
        ]);

        $mockUser = (object)['name' => 'Staff Member', 'email' => $recipient];

        $data = match ($template) {
            'password-reset' => [
                'user' => $mockUser,
                'resetUrl' => route('admin.password.reset', ['token' => 'test-token', 'email' => $recipient]),
                'subject' => '[Test] Staff Password Reset Request',
            ],
            'contact-notification' => [
                'senderName' => 'Test Visitor',
                'senderEmail' => 'testvisitor@example.com',
                'senderPhone' => '+254 700 000 000',
                'subject' => '[Test] General Visitor Inquiry',
                'messageText' => 'This is a sample test notification demonstrating the branded contact email layout.',
            ],
            'music-promotion-notification' => [
                'artistName' => 'Sample Gusii Artist',
                'artistType' => 'Music Band',
                'songTitle' => 'Ekerubo Ekemia',
                'packageType' => 'Standard Package',
                'senderEmail' => $recipient,
                'senderPhone' => '+254 700 000 000',
                'songUrl' => 'https://gusiilyrics.com',
            ],
            default => [
                'recipient' => $recipient,
                'host' => $host,
                'port' => $port,
                'subject' => '[Test] Gusii Lyrics SMTP Verification',
            ],
        };

        $viewName = match ($template) {
            'password-reset' => 'emails.password-reset',
            'contact-notification' => 'emails.contact-notification',
            'music-promotion-notification' => 'emails.music-promotion-notification',
            default => 'emails.test-smtp',
        };

        try {
            Mail::send($viewName, $data, function ($message) use ($recipient, $fromAddress, $fromName, $data) {
                $message->to($recipient)
                    ->from($fromAddress, $fromName)
                    ->subject($data['subject'] ?? 'Gusii Lyrics Mail Notification Test');
            });

            return redirect()->back()->with('success', "Test email for template '{$template}' dispatched successfully to {$recipient}!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', "Failed to dispatch test email: " . $e->getMessage());
        }
    }

    // --- System Version & Documentation Hub ---
    public function docsIndex()
    {
        $systemInfo = [
            'app_version' => 'v2.4.0-STABLE',
            'release_name' => 'Gusii Lyrics Vault Shared-Hosting Edition',
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled (Development)' : 'Disabled (Production)',
            'timezone' => config('app.timezone', 'UTC'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'PHP CLI / Shared Web Server',
            'database_driver' => config('database.default'),
            'database_name' => config('database.connections.' . config('database.default') . '.database'),
        ];

        return view('admin.docs.index', compact('systemInfo'));
    }

    // --- Legal Pages Content Manager ---
    public function pagesIndex()
    {
        $pages = [
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'url' => route('pages.terms'),
                'description' => 'User agreement, educational scope, copyright protection, and payment policies.',
                'updated_at' => Setting::get('terms_updated_at', 'Jul 26, 2026'),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'url' => route('pages.privacy'),
                'description' => 'Visitor analytics collection, cookies policy, and M-Pesa transaction privacy.',
                'updated_at' => Setting::get('privacy_updated_at', 'Jul 26, 2026'),
            ],
        ];

        return view('admin.pages.index', compact('pages'));
    }

    public function pagesEdit($slug)
    {
        if (!in_array($slug, ['terms', 'privacy'])) {
            abort(404);
        }

        $defaultTerms = <<<'EOD'
### 1. Acceptance of Terms
By accessing or using Gusii Lyrics Vault ("the Platform"), you agree to be bound by these Terms of Service. If you do not agree to all terms, please do not use the Platform.

### 2. Purpose & Educational Use
Gusii Lyrics Vault is a free cultural preservation platform dedicated to archiving, indexing, and celebrating Ekegusii music heritage and song lyrics. All lyrics, translations, and artist profiles are provided solely for non-commercial educational research, cultural study, and personal entertainment.

### 3. Intellectual Property & Copy Protection
- All song lyrics, musical compositions, and artist branding remain the intellectual property of their respective songwriters, copyright holders, and recording artists.
- To protect original creators and prevent unauthorized commercial web scraping or mass reproduction, public text selection and copying on song pages is restricted.

### 4. Visitor Submissions & Lyric Requests
- When you submit song lyric transcriptions, correction requests, or lyric requests, you warrant that the content provided is accurate and does not violate third-party rights.
- You grant Gusii Lyrics Vault a non-exclusive, royalty-free, perpetual license to format, publish, and edit submitted text for cultural preservation on the Platform.

### 5. Voluntary Donations & M-Pesa / Stripe Payments
- Gusii Lyrics Vault is a free public resource. Donations initiated via M-Pesa STK Push or Stripe are purely voluntary gifts intended to support hosting, server costs, domain maintenance, and transcription labor.
- All voluntary contributions and financial donations are final and non-refundable.

### 6. External Links & Streaming Badges
Our Platform contains links to external music streaming services including Spotify, YouTube, and Apple Music. We are not responsible for the content, privacy practices, or availability of third-party platforms.

### 7. Limitation of Liability
Gusii Lyrics Vault is provided on an "as is" and "as available" basis. While we strive for accuracy in transcription, we make no representations or warranties of any kind regarding completeness or precision.
EOD;

        $defaultPrivacy = <<<'EOD'
### 1. Information We Collect
Gusii Lyrics Vault values your privacy. We collect minimal data necessary to maintain site security and deliver optimal user experiences:
- **Visitor Analytics Logs**: We log standard web server visitor metadata including IP address, user-agent string, referring URL, page views, and device type (mobile vs desktop).
- **Contact & Submission Data**: When you submit a lyric request, lyric correction, or advertiser booking inquiry, we collect the email address, phone number, and details you voluntarily provide.

### 2. Public Access & Registration
Public visitors are NOT required to create an account or sign up to access song lyrics or artist profiles. All public pages are open and read-only.

### 3. M-Pesa & Payment Security
- When you perform an M-Pesa STK Push donation, your phone number and payment amount are transmitted securely to Safaricom's official Daraja API solely to issue the instant payment prompt on your phone screen.
- We do NOT store M-Pesa PIN numbers or financial account credentials on our servers.

### 4. Cookies & Tracking Technologies
We use standard browser cookies and analytics integration (such as Google Analytics GA4 and Meta Pixel) to analyze site performance, traffic patterns, and page popularity. You can manage or disable cookies via your browser settings at any time.

### 5. Data Protection & Sharing
We do NOT sell, rent, or trade visitor personal information to third-party advertisers or marketers. Information is disclosed only when required by law or to process your requested action (e.g. M-Pesa payment processing).

### 6. Updates to Privacy Policy
We may update this Privacy Policy periodically to reflect site improvements or regulatory changes. Continued use of the Platform after changes constitutes acceptance.
EOD;

        $defaultContent = ($slug === 'terms') ? $defaultTerms : $defaultPrivacy;
        $content = Setting::get($slug . '_content', $defaultContent);

        $page = [
            'slug' => $slug,
            'title' => $slug === 'terms' ? 'Terms of Service' : 'Privacy Policy',
            'url' => $slug === 'terms' ? route('pages.terms') : route('pages.privacy'),
            'content' => $content,
        ];

        return view('admin.pages.edit', compact('page'));
    }

    public function pagesUpdate(Request $request, $slug)
    {
        if (!in_array($slug, ['terms', 'privacy'])) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        Setting::set($slug . '_content', $request->content);
        Setting::set($slug . '_updated_at', now()->format('M d, Y H:i'));

        return redirect()->route('admin.pages.index')->with('success', ($slug === 'terms' ? 'Terms of Service' : 'Privacy Policy') . ' page content updated successfully!');
    }

    // --- Ad Inquiries Management Portal ---
    public function adInquiriesIndex(Request $request)
    {
        $query = \App\Models\AdInquiry::latest();

        if ($request->spot) {
            if ($request->spot === 'contact_us') {
                $query->whereIn('placement_spot', ['contact_us', 'contact_form']);
            } else {
                $query->where('placement_spot', $request->spot);
            }
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $inquiries = $query->paginate(15);
        $pendingCount = \App\Models\AdInquiry::where('status', 'pending')->count();
        $contactMessagesCount = \App\Models\AdInquiry::whereIn('placement_spot', ['contact_us', 'contact_form'])->count();

        return view('admin.ad_inquiries.index', compact('inquiries', 'pendingCount', 'contactMessagesCount'));
    }

    public function adInquiriesUpdateStatus(Request $request, $id)
    {
        $inquiry = \App\Models\AdInquiry::findOrFail($id);
        $newStatus = $request->input('status', 'contacted');
        $adminNotes = $request->input('admin_notes');

        $inquiry->update(['status' => $newStatus]);

        if (!empty($inquiry->email)) {
            try {
                $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
                $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');
                
                $heading = match($newStatus) {
                    'approved' => '✅ Your Inquiry Has Been Approved',
                    'declined' => 'Update Regarding Your Inquiry',
                    'contacted' => '💬 Response to Your Inquiry',
                    default => 'Status Update on Your Inquiry',
                };

                $introMessage = match($newStatus) {
                    'approved' => "Mbuya mono! We are pleased to inform you that your advertisement / inquiry '{$inquiry->company_name}' has been APPROVED by the Gusii Lyrics team.",
                    'declined' => "Thank you for reaching out to Gusii Lyrics. Regarding your inquiry '{$inquiry->company_name}', we are unable to approve or process this request at this time.",
                    'contacted' => "Mbuya mono! Our team has reviewed your inquiry '{$inquiry->company_name}' and updated its status.",
                    default => "The status of your inquiry '{$inquiry->company_name}' has been updated to {$newStatus}.",
                };

                Mail::send('emails.status-update', [
                    'recipientName' => $inquiry->advertiser_name,
                    'heading' => $heading,
                    'introMessage' => $introMessage,
                    'itemTitle' => $inquiry->company_name ?: $inquiry->placement_spot,
                    'newStatus' => strtoupper($newStatus),
                    'adminNotes' => $adminNotes,
                    'actionUrl' => route('home'),
                    'actionText' => 'Visit Gusii Lyrics',
                ], function ($message) use ($inquiry, $fromAddress, $fromName, $heading) {
                    $message->to($inquiry->email)
                        ->from($fromAddress, $fromName)
                        ->subject($heading . ' - Gusii Lyrics');
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed sending inquiry email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Inquiry status updated & notification email dispatched to ' . $inquiry->email);
    }

    public function adInquiriesDestroy($id)
    {
        $inquiry = \App\Models\AdInquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->back()->with('success', 'Ad inquiry deleted.');
    }

    // --- Site Ad Placement & Campaign Management ---
    public function adsIndex()
    {
        $ads = \App\Models\SiteAd::latest()->paginate(10);
        return view('admin.ads.index', compact('ads'));
    }

    public function adsCreate()
    {
        $ad = new \App\Models\SiteAd();
        return view('admin.ads.form', compact('ad'));
    }

    public function adsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'placement_spot' => 'required|string|in:header_top,lyrics_above,lyrics_below,sidebar,footer',
            'type' => 'required|string|in:image,script',
            'image_file' => 'nullable|image|max:10240',
            'target_url' => 'nullable|url|max:500',
            'code_script' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/ads', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');

        \App\Models\SiteAd::create($validated);

        return redirect()->route('admin.ads.index')->with('success', 'Ad campaign created successfully!');
    }

    public function adsEdit($id)
    {
        $ad = \App\Models\SiteAd::findOrFail($id);
        return view('admin.ads.form', compact('ad'));
    }

    public function adsUpdate(Request $request, $id)
    {
        $ad = \App\Models\SiteAd::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'placement_spot' => 'required|string|in:header_top,lyrics_above,lyrics_below,sidebar,footer',
            'type' => 'required|string|in:image,script',
            'image_file' => 'nullable|image|max:10240',
            'target_url' => 'nullable|url|max:500',
            'code_script' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/ads', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $ad->update($validated);

        return redirect()->route('admin.ads.index')->with('success', 'Ad campaign updated successfully!');
    }

    public function adsToggleActive($id)
    {
        $ad = \App\Models\SiteAd::findOrFail($id);
        $ad->update(['is_active' => !$ad->is_active]);

        return redirect()->back()->with('success', 'Ad status updated.');
    }

    public function adsDestroy($id)
    {
        $ad = \App\Models\SiteAd::findOrFail($id);
        $ad->delete();

        return redirect()->back()->with('success', 'Ad campaign deleted.');
    }

    // --- Music Promotions Management & Campaign Analytics ---
    public function promotionsIndex(Request $request)
    {
        $query = MusicPromotion::with('song.artist')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $promotions = $query->paginate(10);
        $songs = Song::orderBy('title')->get();

        $stats = [
            'total_campaigns' => MusicPromotion::count(),
            'active_campaigns' => MusicPromotion::where('status', 'active')->count(),
            'total_views' => MusicPromotion::sum('campaign_views'),
            'total_clicks' => MusicPromotion::sum('campaign_clicks'),
            'total_budget' => MusicPromotion::sum('budget_amount'),
        ];

        return view('admin.promotions.index', compact('promotions', 'songs', 'stats'));
    }

    public function promotionsStore(Request $request)
    {
        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'song_title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'song_url' => 'nullable|url|max:500',
            'song_id' => 'nullable|exists:songs,id',
            'package_type' => 'required|string|max:100',
            'status' => 'required|string|in:pending,active,completed,paused,rejected',
            'budget_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $promo = MusicPromotion::create($validated);

        if ($promo->song_id && $promo->status === 'active') {
            Song::where('id', $promo->song_id)->update([
                'is_promoted' => true,
                'promoted_badge_text' => 'FEATURED PROMO',
            ]);
        }

        return redirect()->back()->with('success', 'Music Promotion Campaign created successfully!');
    }

    public function promotionsUpdateStatus(Request $request, $id)
    {
        $promo = MusicPromotion::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|string|in:pending,active,completed,paused,rejected',
            'song_id' => 'nullable|exists:songs,id',
            'budget_amount' => 'nullable|numeric|min:0',
            'campaign_views' => 'nullable|integer|min:0',
            'campaign_clicks' => 'nullable|integer|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $newStatus = $validated['status'];
        $adminNotes = $request->input('admin_notes');

        $promo->update($validated);

        if ($promo->song_id) {
            if ($promo->status === 'active') {
                Song::where('id', $promo->song_id)->update([
                    'is_promoted' => true,
                    'promoted_badge_text' => 'FEATURED PROMO',
                ]);
            } else {
                $otherActive = MusicPromotion::where('song_id', $promo->song_id)
                    ->where('id', '!=', $promo->id)
                    ->where('status', 'active')
                    ->exists();
                if (!$otherActive) {
                    Song::where('id', $promo->song_id)->update(['is_promoted' => false]);
                }
            }
        }

        // Send automatic status email notification to artist
        if (!empty($promo->email)) {
            try {
                $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
                $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');
                
                $heading = match($newStatus) {
                    'active' => '🚀 Your Music Promotion Is Now LIVE!',
                    'completed' => '🎉 Music Promotion Campaign Completed',
                    'rejected' => 'Update Regarding Your Music Promotion Request',
                    default => 'Status Update on Your Music Promotion',
                };

                $introMessage = match($newStatus) {
                    'active' => "Mbuya mono! Great news! Your music promotion campaign for '{$promo->song_title}' by '{$promo->artist_name}' is now ACTIVE and featured across Gusii Lyrics Vault!",
                    'completed' => "Your music promotion campaign for '{$promo->song_title}' has successfully concluded. Thank you for promoting your release with Gusii Lyrics!",
                    'rejected' => "Thank you for submitting your release. Regrettably, your promotion request for '{$promo->song_title}' could not be activated at this time.",
                    default => "The status of your music promotion campaign for '{$promo->song_title}' has been updated to {$newStatus}.",
                };

                $actionUrl = $promo->song_id ? route('songs.show', Song::find($promo->song_id)->slug ?? '') : route('home');

                Mail::send('emails.status-update', [
                    'recipientName' => $promo->artist_name,
                    'heading' => $heading,
                    'introMessage' => $introMessage,
                    'itemTitle' => "{$promo->song_title} ({$promo->package_type})",
                    'newStatus' => strtoupper($newStatus),
                    'adminNotes' => $adminNotes,
                    'actionUrl' => $actionUrl,
                    'actionText' => 'View Release On Gusii Lyrics',
                ], function ($message) use ($promo, $fromAddress, $fromName, $heading) {
                    $message->to($promo->email)
                        ->from($fromAddress, $fromName)
                        ->subject($heading . ' - Gusii Lyrics');
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed sending music promotion status email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Music promotion campaign updated & notification email dispatched!');
    }

    public function promotionsDestroy($id)
    {
        $promo = MusicPromotion::findOrFail($id);
        $songId = $promo->song_id;
        $promo->delete();

        if ($songId) {
            $otherActive = MusicPromotion::where('song_id', $songId)->where('status', 'active')->exists();
            if (!$otherActive) {
                Song::where('id', $songId)->update(['is_promoted' => false]);
            }
        }

        return redirect()->back()->with('success', 'Music promotion campaign deleted.');
    }

    // --- Direct Email Composer ---
    public function sendCustomEmail(Request $request)
    {
        $validated = $request->validate([
            'recipient_email' => 'required|email',
            'recipient_name' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message_body' => 'required|string|min:5',
            'action_url' => 'nullable|url|max:500',
            'action_text' => 'nullable|string|max:100',
        ]);

        $fromAddress = Setting::get('mail_from_address', 'info@gusiilyrics.com');
        $fromName = Setting::get('mail_from_name', 'Gusii Lyrics');

        try {
            Mail::send('emails.custom-message', [
                'recipientName' => $validated['recipient_name'] ?? '',
                'subjectText' => $validated['subject'],
                'messageBody' => $validated['message_body'],
                'actionUrl' => $validated['action_url'] ?? null,
                'actionText' => $validated['action_text'] ?? 'View On Gusii Lyrics',
            ], function ($message) use ($validated, $fromAddress, $fromName) {
                $message->to($validated['recipient_email'])
                    ->from($fromAddress, $fromName)
                    ->subject($validated['subject']);
            });

            return redirect()->back()->with('success', "Direct email successfully dispatched to {$validated['recipient_email']}!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', "Failed sending custom email: " . $e->getMessage());
        }
    }
}
