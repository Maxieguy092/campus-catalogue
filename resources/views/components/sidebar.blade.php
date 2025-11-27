<head>
    <meta charset="UTF-8">
    <title>Dashboard Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="w-60 h-screen bg-slate-900 text-white flex flex-col p-4 space-y-4">
    <a href="{{ route('catalogue') }}" class="flex items-center gap-3">
      <div class="rounded-lg p-2" style="background:linear-gradient(135deg,var(--amber),var(--accent)); color:white; font-weight:700;">CM</div>
      <div>
        <div class="text-lg font-semibold" style="font-family:'Merriweather Sans',Inter;">CampusMarket</div>
        <div class="text-xs text-gray-500">Campus marketplace</div>
      </div>
    </a>

    <a href="{{ route('seller.products') }}" class="block px-3 py-2 rounded hover:bg-slate-700">
        Produk Saya
    </a>

    <a href="{{ route('seller.products.create') }}" class="block px-3 py-2 rounded hover:bg-slate-700">
        Tambah Produk
    </a>

    {{-- <a href="{{ route('seller.register') }}" class="block px-3 py-2 rounded hover:bg-slate-700">
        Register Penjual
    </a> --}}

    <a href="{{ url()->previous() }}" class="block px-3 py-2 rounded hover:bg-slate-700">
        ← Kembali
    </a>

</div>
