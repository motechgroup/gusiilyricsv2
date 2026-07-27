<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Gusii Lyrics Notification' }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #030712; color: #f3f4f6; margin: 0; padding: 40px 15px; -webkit-font-smoothing: antialiased; }
        .wrapper { max-width: 600px; margin: 0 auto; background-color: #0b0f19; border: 1px solid #1f2937; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); }
        .header { background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%); padding: 32px 24px; text-align: center; border-bottom: 1px solid rgba(16, 185, 129, 0.2); }
        .logo-text { font-size: 24px; font-weight: 900; color: #ffffff; letter-spacing: -0.5px; text-decoration: none; display: inline-block; }
        .logo-text span { color: #10b981; }
        .badge { display: inline-block; background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 4px 14px; border-radius: 9999px; margin-top: 8px; tracking-wider: 1px; }
        .content { padding: 32px 28px; color: #d1d5db; font-size: 15px; line-height: 1.6; }
        .content h1, .content h2, .content h3 { color: #ffffff; font-weight: 800; margin-top: 0; }
        .content a.btn { display: inline-block; background-color: #10b981; color: #022c22 !important; text-decoration: none; padding: 14px 32px; border-radius: 14px; font-weight: 800; font-size: 14px; margin: 20px 0; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4); text-align: center; }
        .info-box { background-color: #111827; border: 1px solid #1f2937; border-radius: 16px; padding: 20px; margin: 20px 0; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 13px; color: #34d399; word-break: break-all; }
        .footer { background-color: #030712; padding: 28px 24px; text-align: center; border-top: 1px solid #1f2937; color: #6b7280; font-size: 12px; line-height: 1.6; }
        .footer-links { margin-bottom: 14px; }
        .footer-links a { color: #10b981; text-decoration: none; font-weight: 600; margin: 0 8px; font-size: 12px; }
        .footer-links a:hover { text-decoration: underline; }
        .footer-brand { font-weight: 700; color: #9ca3af; margin-bottom: 6px; }
        .footer-disclaimer { color: #4b5563; font-size: 11px; margin-top: 10px; border-top: 1px border-gray-900; pt-2; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            @php
                $siteLogo = \App\Models\Setting::get('site_logo');
                $siteName = \App\Models\Setting::get('site_name', 'Gusii Lyrics');
            @endphp
            @if($siteLogo)
                <img src="{{ url($siteLogo) }}" alt="{{ $siteName }}" style="max-height: 48px; width: auto; margin-bottom: 8px;">
            @else
                <a href="{{ url('/') }}" class="logo-text">{{ $siteName }}<span>.com</span></a>
            @endif
            <br>
            <span class="badge">Official Notification</span>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <div class="footer-links">
                <a href="{{ url('/') }}">Home</a> &bull;
                <a href="{{ url('/songs') }}">Lyrics Vault</a> &bull;
                <a href="{{ url('/promote-music') }}">Promote Music</a> &bull;
                <a href="{{ url('/about') }}">About Us</a>
            </div>

            <div class="footer-brand">
                {{ $siteName }} &bull; Ekegusii Music Heritage & Lyrics
            </div>

            <div>
                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
            </div>

            @php
                $customFooterText = \App\Models\Setting::get('email_footer_text', 'Preserving Gusii music heritage, song lyrics, translations, and official streaming links for Omogusii worldwide.');
            @endphp
            @if($customFooterText)
                <div class="footer-disclaimer">
                    {{ $customFooterText }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
