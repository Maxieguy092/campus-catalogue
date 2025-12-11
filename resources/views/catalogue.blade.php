<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Produk — CampusMarket</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather+Sans:wght@400;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@0.252.0/dist/lucide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
:root{
  --amber:#f59e0b;
  --accent:#ffb347;
  --navy:#0f172a;
  --soft:#f9fafb;
}
body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial; background:var(--soft); color:var(--navy);}
.header-search{background:linear-gradient(90deg, rgba(255,179,71,0.06), rgba(245,158,11,0.03)); border:1px solid rgba(0,0,0,0.03);}
.card-hover{transition:transform .18s ease, box-shadow .18s ease;}
.card-hover:hover{transform:translateY(-6px); box-shadow:0 12px 30px rgba(15,23,42,0.08);}
.badge{background:linear-gradient(90deg,var(--amber),var(--accent)); color:white; padding:4px 8px; border-radius:999px; font-weight:600; font-size:12px;}
.footer{background:white; border-top:1px solid #eee;}
.input{border:1px solid #e6e9ef; background:white;}
</style>
</head>
<body>

<header class="bg-white shadow-sm">
  <div class="max-w-6xl mx-auto px-6 py-4 flex items-center gap-6">
    <a href="{{ route('catalogue') }}" class="flex items-center gap-3">
      <div class="rounded-lg p-2" style="background:linear-gradient(135deg,var(--amber),var(--accent)); color:white; font-weight:700;">CM</div>
      <div>
        <div class="text-lg font-semibold" style="font-family:'Merriweather Sans',Inter;">CampusMarket</div>
        <div class="text-xs text-gray-500">Campus marketplace</div>
      </div>
    </a>
    <form action="{{ route('catalogue') }}" method="GET" class="flex flex-col gap-2">
      <!-- Container matching header search -->
      <div class="flex items-center gap-2 bg-gradient-to-r from-amber-100/20 to-amber-50/20 border border-amber-200 rounded-lg px-3 py-2">
          <!-- Search icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-search w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="7"/>
              <path d="M21 21l-4.35-4.35"/>
          </svg>

          <!-- Search input -->
          <input type="text" name="name"
              value="{{ $search['name'] ?? '' }}"
              placeholder="Cari produk..."
              class="flex-1 bg-transparent outline-none text-sm" />

          <!-- Category select -->
          <select name="category_id" class="bg-transparent text-sm outline-none">
              <option value="">Semua Kategori</option>
              @foreach ($categories as $c)
                  <option value="{{ $c->id }}" {{ (isset($search['category_id']) && $search['category_id'] == $c->id) ? 'selected' : '' }}>
                      {{ $c->name }}
                  </option>
              @endforeach
          </select>

          <!-- Condition select -->
          <select name="kondisi" class="bg-transparent text-sm outline-none">
              <option value="">Kondisi</option>
              <option value="Baru" {{ (isset($search['kondisi']) && $search['kondisi'] == 'Baru') ? 'selected' : '' }}>Baru</option>
              <option value="Bekas" {{ (isset($search['kondisi']) && $search['kondisi'] == 'Bekas') ? 'selected' : '' }}>Bekas</option>
          </select>

          <!-- Submit button -->
          <button type="submit"
            class="w-full text-black font-semibold py-2 rounded transition"
            style="background-color:#f59e0b; hover:background-color:#d97706;">
            Cari
        </button>
      </div>
  </form>
    <nav class="flex items-center gap-6">
      <a href="products.html" class="text-sm text-gray-700 hover:text-var(--amber)">Produk</a>
      {{-- <a href="orders.html" class="text-sm text-gray-700">Pesanan</a> --}}
      <a href="{{ route('seller.products') }}" class="text-sm text-gray-700">Profil</a>
      <a href="{{ route('seller.login') }}" class="px-3 py-2 bg-white border rounded-md text-sm" style="border-color:rgba(15,23,42,0.06);">Masuk</a>
      <a href="{{ route('seller.register') }}" class="px-3 py-2 bg-var(--amber) text-white rounded-md text-sm" style="background:var(--amber);">Register</a>
    </nav>
  </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex gap-6">
    <aside class="w-64">
      <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="font-semibold mb-3">Filter</h5>
          <form action="{{ route('catalogue') }}" method="GET" class="space-y-3">
              <input type="text" name="name"
                  value="{{ $search['name'] ?? '' }}"
                  placeholder="Cari produk..."
                  class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-400" />

              <select name="category_id"
                  class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-400">
                  <option value="">Semua Kategori</option>
                  @foreach ($categories as $c)
                      <option value="{{ $c->id }}" {{ (isset($search['category_id']) && $search['category_id'] == $c->id) ? 'selected' : '' }}>
                          {{ $c->name }}
                      </option>
                  @endforeach
              </select>

              <select name="kondisi"
                  class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-400">
                  <option value="">Kondisi</option>
                  <option value="Baru" {{ (isset($search['kondisi']) && $search['kondisi'] == 'Baru') ? 'selected' : '' }}>Baru</option>
                  <option value="Bekas" {{ (isset($search['kondisi']) && $search['kondisi'] == 'Bekas') ? 'selected' : '' }}>Bekas</option>
              </select>
               
              <button type="submit"
                  class="w-full text-black font-semibold py-2 rounded transition"
                  style="background-color:#f59e0b; hover:background-color:#d97706;">
                  Cari
              </button>
          </form>
        <!-- <select class="w-full p-2 rounded input mb-2"><option>Universitas</option></select> -->
        <div class="mt-3 text-sm text-gray-500">Harga</div>
      </div>
    </aside>
    <section class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($products as $p)
    <article class="bg-white p-4 rounded shadow-sm card-hover">

        <div class="h-44 bg-gray-100 rounded mb-3">
            <img src="{{ asset($p['image_link']) }}"
                 alt="{{ $p['name'] }}"
                 class="w-full h-full object-cover">
        </div>

        <h3 class="font-semibold">{{ $p['name'] }}</h3>

        <div class="text-sm text-gray-500">
            {{ $p['category']['name'] }} • Kondisi: {{ $p['kondisi'] }}
        </div>

        <div class="mt-3 flex items-center justify-between">
            <div class="font-semibold">{{ $p['harga'] }}</div>
            <a href="{{ $p['link'] }}" class="text-sm" style="color:var(--amber);">Detail</a>
        </div>

    </article>
    @endforeach


    </section>
  </div>
</main>

<footer class="footer mt-12">
  <div class="max-w-6xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
    <div class="mb-2 md:mb-0">© CampusMarket 2025</div>
    <div class="text-gray-500">Made with ❤️ — original design inspired by marketplace patterns</div>
  </div>
</footer>
<script>window.addEventListener('load',()=>{if(window.lucide)lucide.replace()});</script>
</body>
</html>
