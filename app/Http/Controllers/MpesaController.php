<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function stkPush(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|min:9',
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email',
        ]);

        $mpesaService = new MpesaService();
        $res = $mpesaService->stkPush($validated['phone'], $validated['amount']);

        if (isset($res['ResponseCode']) && $res['ResponseCode'] == '0') {
            // Log pending donation entry
            Donation::create([
                'donor_name' => $validated['donor_name'] ?? 'M-Pesa Visitor',
                'donor_email' => $validated['donor_email'] ?? null,
                'amount' => $validated['amount'],
                'currency' => 'KES',
                'gateway' => 'mpesa',
                'transaction_reference' => $res['CheckoutRequestID'] ?? ('MPESA-' . time()),
                'status' => isset($res['simulated']) ? 'completed' : 'pending',
                'notes' => 'M-Pesa STK Push to ' . MpesaService::normalizePhone($validated['phone']),
            ]);

            return response()->json([
                'success' => true,
                'message' => $res['CustomerMessage'],
                'data' => $res
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $res['CustomerMessage'] ?? 'STK Push failed. Please try again.',
            'data' => $res
        ], 400);
    }

    public function callback(Request $request)
    {
        Log::info('M-Pesa Callback Received:', $request->all());

        try {
            $stkCallback = $request->json('Body.stkCallback');
            if ($stkCallback) {
                $checkoutRequestId = $stkCallback['CheckoutRequestID'] ?? null;
                $resultCode = $stkCallback['ResultCode'] ?? 1;

                if ($checkoutRequestId && $resultCode == 0) {
                    $receiptNumber = null;
                    $metaItems = $stkCallback['CallbackMetadata']['Item'] ?? [];
                    foreach ($metaItems as $item) {
                        if ($item['Name'] === 'MpesaReceiptNumber') {
                            $receiptNumber = $item['Value'];
                        }
                    }

                    $donation = Donation::where('transaction_reference', $checkoutRequestId)->first();
                    if ($donation) {
                        $donation->update([
                            'status' => 'completed',
                            'transaction_reference' => $receiptNumber ?? $checkoutRequestId,
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error processing M-Pesa callback: ' . $e->getMessage());
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}
