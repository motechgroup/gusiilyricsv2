<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class LegalPageController extends Controller
{
    public function about()
    {
        $stats = [
            'total_songs' => \App\Models\Song::count(),
            'total_artists' => \App\Models\Artist::count(),
            'total_genres' => \App\Models\Genre::count(),
            'total_views' => \App\Models\Song::sum('views_count'),
        ];

        return view('pages.about', compact('stats'));
    }

    public function terms()
    {
        $defaultTerms = <<<'EOD'
### 1. Acceptance of Terms
By accessing or using Gusii Lyrics ("the Platform"), you agree to be bound by these Terms of Service. If you do not agree to all terms, please do not use the Platform.

### 2. Purpose & Educational Use
Gusii Lyrics is a free cultural preservation platform dedicated to archiving, indexing, and celebrating Ekegusii music heritage and song lyrics. All lyrics, translations, and artist profiles are provided solely for non-commercial educational research, cultural study, and personal entertainment.

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

        $content = Setting::get('terms_content', $defaultTerms);

        return view('pages.terms', compact('content'));
    }

    public function privacy()
    {
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

        $content = Setting::get('privacy_content', $defaultPrivacy);

        return view('pages.privacy', compact('content'));
    }
}
