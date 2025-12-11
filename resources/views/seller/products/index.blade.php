<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Produk Saya — CampusMarket</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather+Sans:wght@400;700&display=swap" rel="stylesheet">

<!-- Icons -->
<script src="https://unpkg.com/lucide@0.252.0/dist/lucide.min.js"></script>

<!-- Tailwind -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Custom Theme -->
<style>
:root{
  --amber:#f59e0b;
  --accent:#ffb347;
  --navy:#0f172a;
  --soft:#f9fafb;
}
body{
  font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;
  background:var(--soft);
  color:var(--navy);
}
.card-hover{transition:transform .18s ease, box-shadow .18s ease;}
.card-hover:hover{transform:translateY(-6px); box-shadow:0 12px 30px rgba(15,23,42,0.08);}
.table-header{
  background:linear-gradient(90deg, rgba(255,179,71,0.12), rgba(245,158,11,0.08));
}
.button-amber{
  background:var(--amber);
  color:white;
}
.button-amber:hover{
  background:#d97706;
}
</style>
</head>

<body>

<div class="min-h-screen">

    {{-- Sidebar (unchanged, just styled container) --}}
    @include('components.sidebar')

    <div class="ml-60 p-8">

        <h1 class="text-3xl font-semibold mb-6" style="font-family:'Merriweather Sans',Inter;">
            Produk Saya
        </h1>

        <a href="{{ route('seller.products.create') }}"
           class="px-4 py-2 rounded-lg font-semibold shadow-sm button-amber">
            Tambah Produk
        </a>

        <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="table-header text-left text-sm font-semibold text-gray-700">
                    <tr>
                        <th class="p-4 border-b border-gray-200">Nama</th>
                        <th class="p-4 border-b border-gray-200">Harga</th>
                        <th class="p-4 border-b border-gray-200">Kategori</th>
                        <th class="p-4 border-b border-gray-200">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white text-sm">

                    @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 border-b border-gray-200">
                            <span class="font-medium text-gray-800">{{ $product['name'] }}</span>
                        </td>

                        <td class="p-4 border-b border-gray-200">
                            <span class="font-semibold text-gray-900">
                                {{ $product['harga'] }}
                            </span>
                        </td>

                        <td class="p-4 border-b border-gray-200 text-gray-700">
                            {{ $product['category']['name'] ?? '-' }}
                        </td>

                        <td class="p-4 border-b border-gray-200">
                            <div class="flex gap-4 items-center">

                                <a href="{{ route('seller.products.edit', $product['id']) }}"
                                   class="text-blue-600 hover:underline font-medium">
                                    Edit
                                </a>

                                <form action="{{ route('seller.products.delete', $product['id']) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline font-medium">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
window.addEventListener('load',()=>{ if(window.lucide) lucide.replace() })
</script>

</body>
</html>
