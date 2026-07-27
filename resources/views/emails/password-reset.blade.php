@extends('emails.layout')

@section('content')
    <h2 style="color: #ffffff; font-size: 20px;">Reset Your Staff Account Password</h2>
    <p>Hello <strong>{{ $user->name ?? 'Staff User' }}</strong>,</p>
    <p>You are receiving this email because a password reset request was submitted for your <strong>{{ \App\Models\Setting::get('site_name', 'Gusii Lyrics') }}</strong> staff portal account.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $resetUrl ?? '#' }}" class="btn">Reset Staff Password &rarr;</a>
    </div>

    <p style="font-size: 13px; color: #9ca3af;">This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required and your account remains completely secure.</p>
@endsection
