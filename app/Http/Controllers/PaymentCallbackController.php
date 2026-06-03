<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Dapatkan notifikasi dari Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 2. Verifikasi keamanan (Signature Key)
        // sha512(order_id + status_code + gross_amount + server_key)
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));

        if ($notification->signature_key !== $validSignatureKey) {
            Log::warning('Midtrans Invalid Signature Key', ['payload' => $notification]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 3. Cari pesanan di database
        $booking = Booking::where('order_number', $notification->order_id)->first();

        if (!$booking) {
            Log::warning('Midtrans Booking Not Found', ['order_id' => $notification->order_id]);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // 4. Update status berdasarkan respon Midtrans
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;
        $paymentType = $notification->payment_type ?? 'midtrans';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $booking->update(['status' => 'pending']);
            } else if ($fraudStatus == 'accept') {
                $booking->update(['status' => 'paid', 'payment_method' => $paymentType]);
            }
        } else if ($transactionStatus == 'settlement') {
            $booking->update(['status' => 'paid', 'payment_method' => $paymentType]);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $booking->update(['status' => 'cancelled']);
        } else if ($transactionStatus == 'pending') {
            $booking->update(['status' => 'pending', 'payment_method' => $paymentType]);
        }

        // Midtrans membutuhkan HTTP 200 OK untuk mengetahui bahwa webhook telah diterima dengan baik
        return response()->json(['message' => 'OK'], 200);
    }
}
