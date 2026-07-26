<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #090d16; color: #f3f4f6; margin: 0; padding: 40px 20px; }
        .card { max-width: 550px; margin: 0 auto; background-color: #111827; border: 1px solid #1f2937; border-radius: 20px; padding: 32px; text-align: center; }
        .logo { width: 50px; height: 50px; background-color: #10b981; border-radius: 14px; display: inline-block; line-height: 50px; font-weight: 900; color: #000; font-size: 24px; margin-bottom: 16px; }
        h2 { color: #ffffff; margin-top: 0; font-size: 22px; font-weight: 800; }
        p { color: #9ca3af; font-size: 14px; line-height: 1.6; }
        .btn { display: inline-block; background-color: #10b981; color: #022c22 !important; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 800; font-size: 14px; margin: 24px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #6b7280; border-top: 1px solid #1f2937; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">G</div>
        <h2>Reset Your Staff Password</h2>
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        <p>You are receiving this email because a password reset request was received for your Gusii Lyrics staff account.</p>
        
        <a href="{{ $resetUrl }}" class="btn">Reset Password &rarr;</a>
        
        <p>This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Gusii Lyrics. All rights reserved.
        </div>
    </div>
</body>
</html>
