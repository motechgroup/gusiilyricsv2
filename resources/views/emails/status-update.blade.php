@extends('emails.layout')

@section('content')
    <h2 style="color: #10b981; font-size: 20px;">{{ $heading ?? 'Status Update on Your Submission' }}</h2>
    
    <p>Hello <strong>{{ $recipientName ?? 'Valued Partner' }}</strong>,</p>
    
    <p>{{ $introMessage }}</p>

    <div class="info-box" style="color: #e5e7eb; font-family: sans-serif;">
        <p style="margin: 0 0 8px 0;"><strong>Submission Reference:</strong> {{ $itemTitle }}</p>
        <p style="margin: 0 0 8px 0;"><strong>New Status:</strong> <span style="color: #34d399; font-weight: bold; text-transform: uppercase;">{{ $newStatus }}</span></p>
        @if(!empty($adminNotes))
            <hr style="border-color: #1f2937; margin: 12px 0;">
            <p style="margin: 0; color: #9ca3af;"><strong>Admin Notes:</strong><br>{{ $adminNotes }}</p>
        @endif
    </div>

    @if(!empty($actionUrl))
        <div style="text-align: center; margin: 28px 0;">
            <a href="{{ $actionUrl }}" class="btn">{{ $actionText ?? 'View On Gusii Lyrics' }} &rarr;</a>
        </div>
    @endif

    <p style="font-size: 13px; color: #9ca3af;">If you have any further questions, feel free to reply to this email.</p>
@endsection
