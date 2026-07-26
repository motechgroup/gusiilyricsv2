<?php

namespace App\Http\Controllers;

use App\Models\AdInquiry;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function showPublicAdvertise()
    {
        return view('advertise');
    }

    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'advertiser_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'placement_spot' => 'required|string|in:header_banner,in_lyrics,sidebar,footer',
            'budget_range' => 'nullable|string|max:100',
            'banner_file' => 'nullable|image|max:10240',
            'message' => 'nullable|string',
        ]);

        if ($request->hasFile('banner_file')) {
            $path = $request->file('banner_file')->store('uploads/ads', 'public');
            $validated['banner_image'] = '/storage/' . $path;
        }

        $validated['status'] = 'pending';

        AdInquiry::create($validated);

        return redirect()->back()->with('success', 'Ebaora Mno! Your advertisement inquiry has been received. Our team will contact you shortly to review your ad campaign.');
    }
}
