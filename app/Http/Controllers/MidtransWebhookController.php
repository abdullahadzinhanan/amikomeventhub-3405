<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Mencari transaksi tersebut di database lokal
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses berulang jika status sudah Success
        if ($transaction->status === 'Success') {
            return response()->json(['message' => 'Already processed']);
        }

        // Logika penerjemahan status Midtrans -> status lokal (mengikuti konvensi capitalized project ini)
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'Challenge';
            } elseif ($fraudStatus == 'accept') {
                $transaction->status = 'Success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'Success';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'Failed';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'Pending';
        }

        $transaction->save();

        return response()->json(['message' => 'OK']);
    }

    private function processSuccess(Transaction $transaction)
    {
        // Instruksi lanjutan saat transaksi lunas (pemotongan tiket) akan dibahas pada Modul 13
    }
}