@extends('layouts.app')
@section('title', 'Pembayaran - ' . $transaction->event->title)
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong>{{ $transaction->event->title }}</strong>.</p>

        {{-- Pesan saat pending (misal user sudah pilih VA tapi belum transfer) --}}
        @if(request('status') === 'pending')
        <div class="mb-6 p-4 bg-orange-50 border border-orange-200 text-orange-700 rounded-2xl text-sm font-bold">
            ⏳ Pembayaran Anda sedang menunggu konfirmasi. Selesaikan transfer sesuai instruksi yang dikirim Midtrans, lalu klik tombol di bawah.
        </div>
        @endif

        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
            <h3 class="text-4xl font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2">Order ID: {{ $transaction->order_id }}</p>
        </div>

        <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition animate-bounce-in">
            Bayar Sekarang
        </button>

        {{-- Tombol cek status manual untuk kasus VA sudah ditransfer tapi belum redirect --}}
        <a href="{{ route('checkout.success', $transaction->order_id) }}"
           class="block mt-4 text-sm text-slate-400 hover:text-indigo-600 font-bold transition">
            Sudah transfer? Klik di sini untuk cek status pembayaran →
        </a>
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    var paymentUrl = "{{ route('checkout.payment', $transaction->order_id) }}";
    var successUrl = "{{ route('checkout.success', $transaction->order_id) }}";

    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $transaction->snap_token }}', {

            // ✅ Sukses / settlement → ke halaman sukses untuk proses tiket & email
            onSuccess: function(result) {
                window.location.href = successUrl;
            },

            // ✅ FIX: Pending (VA sudah dipilih, belum dibayar) → TETAP di halaman payment
            // Jangan redirect ke /success karena pembayaran BELUM lunas
            onPending: function(result) {
                window.location.href = paymentUrl + '?status=pending';
            },

            // ✅ Error dari Midtrans → tampilkan pesan
            onError: function(result) {
                alert('Pembayaran gagal! Silakan coba lagi.');
                window.location.href = paymentUrl;
            },

            // ✅ FIX: User silang/tutup popup → TETAP di halaman payment, bukan ke success
            onClose: function() {
                // Tidak redirect ke mana-mana, user tetap di halaman payment
                // bisa klik tombol Bayar Sekarang lagi
            }
        });
    };

    // Auto trigger buka popup Midtrans saat halaman payment dibuka
    // Hanya auto trigger jika status bukan pending (sudah ada VA tapi belum bayar)
    @if(request('status') !== 'pending')
    window.onload = function() {
        document.getElementById('pay-button').click();
    }
    @endif
</script>

<style>
    @keyframes bounce-in {
        0% { transform: scale(0.9); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-bounce-in { animation: bounce-in 0.4s ease-out forwards; }
</style>
@endsection