<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function sendReceipt($booking)
    {
        $fonnteToken = env('FONNTE_TOKEN'); // Masukkan token Fonnte di .env

        if (!$fonnteToken) {
            Log::warning('Fonnte token not set. WhatsApp receipt not sent for booking: ' . $booking->order_number);
            return false;
        }

        // Pastikan phone number dalam format E.164 atau kode negara tanpa +
        $customerPhone = $booking->customer_details['phone'] ?? null;
        if (!$customerPhone) return false;

        $customerName = $booking->customer_details['names'][0]['name'] ?? 'Pelanggan';
        $simpleBookingCode = str_replace('-', '', $booking->order_number);

        $message = "*🧾 E-RECEIPT | NUSA JAYA INDOFAST*\n\n"
                 . "Halo / *Hello " . $customerName . "*,\n"
                 . "Terima kasih atas pembayaran Anda! Pesanan Anda telah berhasil dikonfirmasi.\n"
                 . "_Thank you for your payment! Your booking has been successfully confirmed._\n\n"
                 . "✨ *Detail Pesanan / Booking Details:*\n"
                 . "🏷️ *Kode Booking / Booking Code:* " . $simpleBookingCode . "\n"
                 . "📅 *Tanggal / Date:* " . \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') . "\n"
                 . "⏰ *Jam Penjemputan / Pickup Time:* " . $booking->pickup_time . "\n"
                 . "📍 *Titik Jemput / Pickup Point:* " . ($booking->pickup_point ?? '-') . "\n"
                 . "📦 *Layanan / Service:* " . $booking->service_name . "\n";
                 
        if ($booking->type === 'tour') {
            $message .= "👥 *Jumlah Peserta / Total Pax:* " . $booking->guests . " pax\n";
        }

        $message .= "💳 *Total Bayar / Total Paid:* Rp " . number_format($booking->amount, 0, ',', '.') . "\n\n"
                 . "Mohon simpan pesan ini sebagai bukti pemesanan yang sah.\n"
                 . "_Please keep this message as a valid booking receipt._\n"
                 . "Jika ada pertanyaan, silakan hubungi tim kami. / _If you have any questions, please contact our team._\n\n"
                 . "Semoga perjalanan Anda menyenangkan bersama *Nusa Jaya Indofast*!\n"
                 . "_Wishing you a pleasant journey with Nusa Jaya Indofast!_";

        try {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken
            ])->post('https://api.fonnte.com/send', [
                'target' => $customerPhone,
                'message' => $message,
                'countryCode' => '62', // Default kode negara jika nomor tidak memilikinya
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp receipt sent successfully to ' . $customerPhone);
                return true;
            } else {
                Log::error('Fonnte API error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Fonnte API Exception: ' . $e->getMessage());
            return false;
        }
    }

    public static function sendRescheduleAlert($booking, $oldDate)
    {
        $fonnteToken = env('FONNTE_TOKEN');

        if (!$fonnteToken) {
            return false;
        }

        $customerPhone = $booking->customer_details['phone'] ?? null;
        if (!$customerPhone) return false;

        $customerName = $booking->customer_details['names'][0]['name'] ?? 'Pelanggan';
        $simpleBookingCode = str_replace('-', '', $booking->order_number);

        $message = "*🔄 NOTIFIKASI PERUBAHAN JADWAL | RESCHEDULE ALERT*\n\n"
                 . "Halo / *Hello " . $customerName . "*,\n"
                 . "Permintaan perubahan jadwal (Reschedule) untuk pesanan Anda telah *berhasil diproses*.\n"
                 . "_Your reschedule request has been successfully processed._\n\n"
                 . "✨ *Detail Perubahan / Reschedule Details:*\n"
                 . "🏷️ *Kode Booking / Booking Code:* " . $simpleBookingCode . "\n"
                 . "❌ *Tanggal Lama / Old Date:* " . \Carbon\Carbon::parse($oldDate)->format('d M Y') . "\n"
                 . "✅ *Tanggal Baru / New Date:* " . \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') . "\n"
                 . "📦 *Layanan / Service:* " . $booking->service_name . "\n\n"
                 . "Admin kami telah mencatat jadwal baru Anda.\n"
                 . "_Our admin has recorded your new schedule._\n"
                 . "Jika ada pertanyaan lebih lanjut, silakan hubungi tim kami.\n"
                 . "_If you have further questions, please contact our team._\n\n"
                 . "Terima kasih telah mempercayakan perjalanan Anda bersama *Nusa Jaya Indofast*!\n"
                 . "_Thank you for trusting your journey with Nusa Jaya Indofast!_";

        try {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken
            ])->post('https://api.fonnte.com/send', [
                'target' => $customerPhone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp reschedule alert sent successfully to ' . $customerPhone);
                return true;
            } else {
                Log::error('Fonnte API error (Reschedule): ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Fonnte API Exception (Reschedule): ' . $e->getMessage());
            return false;
        }
    }
}
