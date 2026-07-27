<?php

namespace App\Http\Controllers;

use App\Models\AdInquiry;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function showPublicAdvertise()
    {
        return view('advertise');
    }

    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'advertiser_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'placement_spot' => 'required|string|in:header_banner,in_lyrics,sidebar,footer',
            'budget_range' => 'nullable|string|max:100',
            'banner_file' => 'nullable|image|max:10240',
            'message' => 'nullable|string',
        ]);

        if ($request->hasFile('banner_file')) {
            $path = $request->file('banner_file')->store('uploads/ads', 'public');
            $validated['banner_image'] = '/storage/' . $path;
        }

        $validated['status'] = 'pending';

        AdInquiry::create($validated);

        return redirect()->back()->with('success', 'Mbuya Mono! Your advertisement inquiry has been received. Our team will contact you shortly to review your ad campaign.');
    }

    public function showPromoteMusic()
    {
        $stats = [
            'total_songs' => \App\Models\Song::count(),
            'total_artists' => \App\Models\Artist::count(),
            'monthly_visitors' => '150,000+',
            'youtube_subscribers' => '25,000+',
            'instagram_followers' => '18,500+',
            'tiktok_followers' => '32,000+',
        ];

        return view('promote_music', compact('stats'));
    }

    public function submitMusicPromotion(Request $request)
    {
        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'artist_type' => 'nullable|string|in:artist,band,choir,group',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'song_title' => 'required|string|max:255',
            'song_url' => 'required|url|max:500',
            'package_type' => 'required|string|max:100',
            'lyrics_text' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $typeLabel = match($request->input('artist_type')) {
            'band' => 'Music Band',
            'choir' => 'Gospel Choir',
            'group' => 'Music Group',
            default => 'Artist',
        };

        $message = "MUSIC PROMOTION SUBMISSION:\n";
        $message .= "Artist/Entity Name: {$validated['artist_name']}\n";
        $message .= "Category Type: {$typeLabel}\n";
        $message .= "Song Title: {$validated['song_title']}\n";
        $message .= "Song Link: {$validated['song_url']}\n";
        $message .= "Package: {$validated['package_type']}\n";
        if (!empty($validated['lyrics_text'])) {
            $message .= "\nLYRICS PROVIDED:\n{$validated['lyrics_text']}\n";
        }
        if (!empty($validated['message'])) {
            $message .= "\nADDITIONAL NOTES:\n{$validated['message']}\n";
        }

        $inquiry = AdInquiry::create([
            'advertiser_name' => $validated['artist_name'],
            'company_name' => $validated['contact_person'] ?? 'Music Promotion',
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'placement_spot' => 'music_promotion',
            'budget_range' => $validated['package_type'],
            'message' => $message,
            'status' => 'pending',
        ]);

        \App\Models\MusicPromotion::create([
            'ad_inquiry_id' => $inquiry->id,
            'artist_name' => $validated['artist_name'],
            'song_title' => $validated['song_title'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'song_url' => $validated['song_url'],
            'package_type' => $validated['package_type'],
            'lyrics_text' => $validated['lyrics_text'] ?? null,
            'notes' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Mbuya Mono! Your music promotion request has been received. Our team will review your release and contact you via Email / WhatsApp shortly!');
    }
}
