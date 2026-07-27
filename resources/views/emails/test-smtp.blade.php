@extends('emails.layout')

@section('content')
    <h2 style="color: #10b981; font-size: 22px;">✅ SMTP Connection Test Successful!</h2>
    <p>Mbuya mono!</p>
    <p>This is an official test email dispatched from <strong>{{ \App\Models\Setting::get('site_name', 'Gusii Lyrics') }}</strong> to confirm that your outbound mail dispatch system is working perfectly.</p>

    <div class="info-box">
        <strong>Dispatch Details:</strong><br>
        • Recipient: {{ $recipient ?? 'admin@gusiilyrics.com' }}<br>
        • SMTP Host: {{ $host ?? '127.0.0.1' }}<br>
        • Port: {{ $port ?? '587' }}<br>
        • Timestamp: {{ now()->toDayDateTimeString() }}
    </div>

    <p style="color: #9ca3af; font-size: 13px;">If you received this message, all outgoing email services (password resets, visitor inquiry notifications, and music promotions) are ready to deliver notifications seamlessly.</p>
@endsection
