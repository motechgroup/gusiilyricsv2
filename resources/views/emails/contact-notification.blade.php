@extends('emails.layout')

@section('content')
    <h2 style="color: #10b981; font-size: 20px;">✉️ New Visitor Contact Inquiry</h2>
    <p>A new visitor contact form message has been received on <strong>{{ \App\Models\Setting::get('site_name', 'Gusii Lyrics') }}</strong>.</p>

    <div class="info-box" style="color: #e5e7eb; font-family: sans-serif;">
        <p style="margin: 0 0 8px 0;"><strong>Sender Name:</strong> {{ $senderName ?? 'John Doe' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Email Address:</strong> <a href="mailto:{{ $senderEmail ?? 'visitor@example.com' }}" style="color: #34d399;">{{ $senderEmail ?? 'visitor@example.com' }}</a></p>
        <p style="margin: 0 0 8px 0;"><strong>Phone Number:</strong> {{ $senderPhone ?? 'N/A' }}</p>
        <p style="margin: 0 0 8px 0;"><strong>Subject:</strong> {{ $subject ?? 'General Inquiry' }}</p>
        <hr style="border-color: #1f2937; margin: 12px 0;">
        <p style="margin: 0; white-space: pre-wrap; color: #9ca3af;">{{ $messageText ?? 'Hello Team, I am reaching out to inquire about your platform services.' }}</p>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('admin.ad-inquiries.index') }}" class="btn">View Messages In Admin Portal &rarr;</a>
    </div>
@endsection
