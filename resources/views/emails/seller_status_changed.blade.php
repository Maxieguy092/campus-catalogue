<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Status Pendaftaran</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6;">
  <h2>Halo {{ $seller->pic_name }},</h2>

  @if($status === 'accepted')
    <p>Selamat — pendaftaran toko <strong>{{ $seller->store_name }}</strong> telah <strong>Diterima</strong>. Anda sekarang dapat login dan mulai mengelola toko Anda.</p>
  @elseif($status === 'rejected')
    <p>Mohon maaf — pendaftaran toko <strong>{{ $seller->store_name }}</strong> dinyatakan <strong>Ditolak</strong>.</p>
    @if($reason)
      <p>Alasan: {{ $reason }}</p>
    @endif
  @else
    <p>Status akun Anda: {{ $status }}</p>
  @endif

  <p>Jika butuh bantuan, silakan balas email ini atau hubungi tim support.</p>

  <p>Salam,<br>Tim Marketplace</p>
</body>
</html>
