<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #090d16; color: #f3f4f6; margin: 0; padding: 40px 20px; }
        .card { max-width: 550px; margin: 0 auto; background-color: #111827; border: 1px solid #10b981; border-radius: 20px; padding: 32px; text-align: center; }
        h2 { color: #10b981; margin-top: 0; font-size: 22px; font-weight: 800; }
        p { color: #9ca3af; font-size: 14px; line-height: 1.6; }
        .footer { margin-top: 24px; font-size: 12px; color: #6b7280; border-top: 1px solid #1f2937; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>✅ SMTP Connection Successful!</h2>
        <p>This is a test email sent from <strong>Gusii Lyrics</strong>.</p>
        <p>If you are reading this email at <code>{{ $recipient }}</code>, your server's SMTP mail configurations are set up and functioning properly!</p>

        <div class="footer">
            &copy; {{ date('Y') }} Gusii Lyrics. All rights reserved.
        </div>
    </div>
</body>
</html>
