<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailer = \App\Models\Setting::get('mail_mailer', env('MAIL_MAILER', 'smtp'));
                $host = \App\Models\Setting::get('mail_host', env('MAIL_HOST', '127.0.0.1'));
                $port = \App\Models\Setting::get('mail_port', env('MAIL_PORT', 587));
                $username = \App\Models\Setting::get('mail_username', env('MAIL_USERNAME'));
                $password = \App\Models\Setting::get('mail_password', env('MAIL_PASSWORD'));
                $encryption = \App\Models\Setting::get('mail_encryption', env('MAIL_ENCRYPTION', 'tls'));
                $fromAddress = \App\Models\Setting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'info@gusiilyrics.com'));
                $fromName = \App\Models\Setting::get('mail_from_name', env('MAIL_FROM_NAME', 'Gusii Lyrics'));

                $encLower = strtolower(trim((string)$encryption));
                $scheme = null;
                if (in_array($encLower, ['ssl', 'smtps']) || (int)$port === 465) {
                    $scheme = 'smtps';
                } elseif (in_array($encLower, ['tls', 'smtp']) || (int)$port === 587) {
                    $scheme = 'smtp';
                }

                config([
                    'mail.default' => $mailer,
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $host,
                    'mail.mailers.smtp.port' => (int)$port,
                    'mail.mailers.smtp.username' => $username,
                    'mail.mailers.smtp.password' => $password,
                    'mail.mailers.smtp.scheme' => $scheme,
                    'mail.from.address' => $fromAddress,
                    'mail.from.name' => $fromName,
                ]);
            }
        } catch (\Throwable $e) {}
    }
}
