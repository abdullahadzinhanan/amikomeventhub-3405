<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi terbaru, eager load relasi event, 20 per halaman
        $transactions = Transaction::with('event')->latest()->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}