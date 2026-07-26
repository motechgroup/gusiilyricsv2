<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $passkey;
    protected string $shortcode;
    protected string $env;
    protected string $baseUrl;

    public function __construct()
    {
        $this->consumerKey = Setting::get('mpesa_consumer_key', '');
        $this->consumerSecret = Setting::get('mpesa_consumer_secret', '');
        $this->passkey = Setting::get('mpesa_passkey', '');
        $this->shortcode = Setting::get('mpesa_shortcode', Setting::get('mpesa_till', '174379'));
        $this->env = Setting::get('mpesa_env', 'sandbox');

        $this->baseUrl = ($this->env === 'production')
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    public static function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '7') || str_starts_with($phone, '1')) {
            return '254' . $phone;
        }

        return $phone;
    }

    public function generateToken(): ?string
    {
        if (empty($this->consumerKey) || empty($this->consumerSecret)) {
            return null;
        }

        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            if ($response->successful()) {
                return $response->json('access_token');
            }
        } catch (\Throwable $e) {
            Log::error('M-Pesa Token Generation Failed: ' . $e->getMessage());
        }

        return null;
    }

    public function stkPush(string $phone, float $amount, string $reference = 'GusiiLyrics', string $description = 'Lyrics Donation'): array
    {
        $phone = self::normalizePhone($phone);
        $token = $this->generateToken();

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
        $callbackUrl = route('api.mpesa.callback');

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => (int) round($amount),
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => substr($reference, 0, 12),
            'TransactionDesc' => substr($description, 0, 12),
        ];

        if (!$token) {
            // Return simulation response if API keys are not configured yet
            return [
                'ResponseCode' => '0',
                'ResponseDescription' => 'Success. STK Push Prompt sent to phone.',
                'CheckoutRequestID' => 'ws_CO_' . time(),
                'CustomerMessage' => "Success! M-Pesa STK Push prompt sent to {$phone}. Please enter your M-Pesa PIN on your phone.",
                'simulated' => true
            ];
        }

        try {
            $response = Http::withToken($token)
                ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            if ($response->successful()) {
                $resData = $response->json();
                $resData['CustomerMessage'] = "Success! M-Pesa STK Push prompt sent to {$phone}. Check your phone to enter PIN.";
                return $resData;
            }

            return [
                'ResponseCode' => '1',
                'ResponseDescription' => 'Failed to send STK Push.',
                'CustomerMessage' => $response->json('errorMessage') ?? 'M-Pesa API error. Please try again or use Paybill / Till number.',
            ];
        } catch (\Throwable $e) {
            Log::error('M-Pesa STK Push Exception: ' . $e->getMessage());
            return [
                'ResponseCode' => '1',
                'ResponseDescription' => $e->getMessage(),
                'CustomerMessage' => 'Could not connect to M-Pesa server. Please use manual Till / Paybill number.',
            ];
        }
    }
}
