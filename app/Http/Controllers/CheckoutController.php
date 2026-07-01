<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventTicketMail;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId    = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000;

        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'Pending',
        ]);

        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
            // ✅ FIX: Beritahu Midtrans kemana harus redirect setelah pembayaran selesai
            // Midtrans akan menambahkan ?order_id=...&status_code=...&transaction_status=...
            // ke URL ini secara otomatis
            'callbacks' => [
                'finish' => url('/payment-finish'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        $categories  = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    // ✅ FIX: Route baru untuk menangkap redirect dari Midtrans finish button
    // Midtrans kirim: /payment-finish?order_id=TRX-xxx&status_code=200&transaction_status=settlement
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('home')->with('error', 'Order ID tidak ditemukan.');
        }

        // Teruskan ke halaman success yang sudah ada logika fallback check-nya
        return redirect()->route('checkout.success', $orderId);
    }

    public function success($order_id)
    {
        $categories  = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Jika transaksi sudah Success sebelumnya, langsung tampilkan halaman sukses
        if ($transaction->status === 'Success') {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        try {
            // Fallback Check: cek status langsung ke API Midtrans
            $status     = \Midtrans\Transaction::status($order_id);
            $trx_status = is_array($status)
                ? ($status['transaction_status'] ?? '')
                : ($status->transaction_status ?? '');

            if (in_array($trx_status, ['settlement', 'capture'])) {
                // Pembayaran lunas: proses hanya jika status lokal masih Pending
                if ($transaction->status === 'Pending') {
                    $transaction->update(['status' => 'Success']);

                    if ($transaction->event && $transaction->event->stock > 0) {
                        $transaction->event->stock -= 1;
                        $transaction->event->save();

                        try {
                            Mail::to($transaction->customer_email)
                                ->send(new EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            Log::error('Gagal kirim E-Ticket (Fallback): ' . $e->getMessage());
                        }
                    } else {
                        Log::warning('Stok habis saat fallback. Order: ' . $order_id);
                    }
                }

            } elseif ($trx_status === 'pending') {
                // Pembayaran belum dilunasi → kembalikan ke halaman payment
                return redirect()->route('checkout.payment', $order_id)
                    ->with('info', 'Pembayaran Anda masih menunggu konfirmasi transfer.');

            } else {
                // Status lain (cancel, expire, deny)
                return redirect()->route('home')
                    ->with('error', 'Transaksi dibatalkan atau kadaluarsa.');
            }

        } catch (\Exception $e) {
            Log::error('Midtrans API error di success(): ' . $e->getMessage());
        }

        // Refresh transaksi dari DB setelah kemungkinan update di atas
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        return view('checkout.success', compact('transaction', 'categories'));
    }
}