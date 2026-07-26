<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Setting;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function showPublicDonate()
    {
        $settings = [
            'mpesa_till' => Setting::get('mpesa_till', '5421908'),
            'mpesa_paybill' => Setting::get('mpesa_paybill', ''),
            'stripe_url' => Setting::get('stripe_url', ''),
        ];

        $rawPresets = Setting::get('preset_donation_amounts', '100, 250, 500, 1000, 2500, 5000');
        $presetAmounts = array_filter(array_map('trim', explode(',', $rawPresets)));

        $recentDonations = Donation::where('status', 'completed')
            ->latest()
            ->take(6)
            ->get();

        return view('donate', compact('settings', 'presetAmounts', 'recentDonations'));
    }

    public function storePublicDonation(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:KES,USD',
            'gateway' => 'required|string|in:mpesa,stripe',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'completed';

        Donation::create($validated);

        return redirect()->back()->with('success', 'Ebaora Mno! Thank you for your generous support of Gusii Lyrics Vault.');
    }
}
