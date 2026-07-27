@extends('emails.layout')

@section('content')
    <h2 style="color: #ffffff; font-size: 20px;">{{ $subjectText ?? 'Message from Gusii Lyrics Team' }}</h2>
    
    @if(!empty($recipientName))
        <p>Hello <strong>{{ $recipientName }}</strong>,</p>
    @else
        <p>Hello,</p>
    @endif

    <div style="background-color: #111827; border: 1px solid #1f2937; border-radius: 16px; padding: 24px; margin: 20px 0; color: #e5e7eb; line-height: 1.7; white-space: pre-wrap;">{{ $messageBody }}</div>

    @if(!empty($actionUrl))
        <div style="text-align: center; margin: 28px 0;">
            <a href="{{ $actionUrl }}" class="btn">{{ $actionText ?? 'View Details' }} &rarr;</a>
        </div>
    @endif

    <p style="font-size: 13px; color: #9ca3af;">Thank you for being part of the Gusii Lyrics community.</p>
@endsection
