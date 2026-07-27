@extends('emails.layout')

@section('content')
    <h2 style="color: #10b981; font-size: 20px;">🚀 New Music Promotion Request</h2>
    <p>An artist or music entity has submitted a release promotion request on <strong>{{ \App\Models\Setting::get('site_name', 'Gusii Lyrics') }}</strong>.</p>

    <div class="info-box" style="color: #e5e7eb; font-family: sans-serif;">
        <p style="margin: 0 0 8px 0;"><strong>Artist/Entity Name:</strong> {{ $artistName ?? 'Chrisembar' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Category Type:</strong> {{ $artistType ?? 'Artist' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Song Title:</strong> {{ $songTitle ?? 'Tatamora' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Package Selected:</strong> <span style="color: #34d399; font-weight: bold;">{{ $packageType ?? 'Featured Banner + Social Blast' }}</span></p>
        <p style="margin: 0 0 8px 0;"><strong>Contact Email:</strong> {{ $senderEmail ?? 'artist@example.com' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Phone / WhatsApp:</strong> {{ $senderPhone ?? '+254712345678' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Song Link:</strong> <a href="{{ $songUrl ?? '#' }}" target="_blank" style="color: #34d399;">{{ $songUrl ?? 'https://youtube.com/watch?v=demo' }}</a></p>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('admin.promotions.index') }}" class="btn">Manage Promotions In Admin &rarr;</a>
    </div>
@endsection
