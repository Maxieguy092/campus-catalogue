<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather+Sans:wght@400;700&display=swap" rel="stylesheet">
    
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
        .stats-card{
          background:white;
          border-radius:12px;
          padding:24px;
          box-shadow:0 1px 3px rgba(0,0,0,0.1);
        }
        .button-primary{
          background:var(--amber);
          color:white;
          padding:10px 16px;
          border-radius:8px;
          transition:all .18s ease;
          text-decoration:none;
          display:inline-flex;
          align-items:center;
          gap:8px;
        }
        .button-primary:hover{
          background:#d97706;
          transform:translateY(-2px);
        }
        .button-secondary{
          background:#3b82f6;
          color:white;
          padding:10px 16px;
          border-radius:8px;
          transition:all .18s ease;
          text-decoration:none;
          display:inline-flex;
          align-items:center;
          gap:8px;
        }
        .button-secondary:hover{
          background:#2563eb;
          transform:translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-50">

    @include('components.sidebar')

    <div style="margin-left: 240px; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">Dashboard Penjual</h1>
                <p style="color: #6b7280; margin-bottom: 0;">Ringkasan produk dan rating Anda</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <!-- Dropdown Laporan -->
                <div style="position: relative; display: inline-block;">
                    <button onclick="toggleDropdown()" class="button-primary">
                        📋 Laporan
                        <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div id="dropdownMenu" style="display: none; position: absolute; right: 0; margin-top: 8px; width: 240px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 10;">
                        <a href="{{ route('seller.reports.stock') }}" style="display: block; padding: 12px 16px; color: #374151; transition: background .18s ease; border-bottom: 1px solid #e5e7eb; text-decoration: none;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                            📊 Laporan Stok Produk
                        </a>
                        <a href="{{ route('seller.reports.rating') }}" style="display: block; padding: 12px 16px; color: #374151; transition: background .18s ease; border-bottom: 1px solid #e5e7eb; text-decoration: none;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                            ⭐ Laporan Produk by Rating
                        </a>
                        <a href="{{ route('seller.reports.low-stock') }}" style="display: block; padding: 12px 16px; color: #374151; transition: background .18s ease; text-decoration: none;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                            ⚠️ Laporan Stok Perlu Pemesanan
                        </a>
                    </div>
                </div>
                
                <!-- Dashboard PDF -->
                <a href="{{ route('seller.dashboard.export-pdf') }}" class="button-secondary">
                    📄 Dashboard PDF
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px;">
            <div class="stats-card card-hover">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">Total Produk</p>
                <h2 style="font-size: 36px; font-weight: 700; color: #0f172a; margin: 0;">{{ $totalProducts }}</h2>
            </div>

            <div class="stats-card card-hover">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">Total Rating</p>
                <h2 style="font-size: 36px; font-weight: 700; color: #10b981; margin: 0;">{{ $totalRatings }}</h2>
            </div>

            <div class="stats-card card-hover">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">Rata-rata Rating</p>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h2 style="font-size: 36px; font-weight: 700; color: #f59e0b; margin: 0;">{{ number_format($averageRating, 1) }}</h2>
                    <span style="color: #fbbf24; font-size: 24px;">⭐</span>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="stats-card" style="margin-bottom: 32px;">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Produk Terlaris (berdasarkan rating)</h2>
            
            @if($topProducts->isEmpty())
                <p style="color: #6b7280; text-align: center; padding: 32px 0; margin: 0;">Belum ada produk dengan rating</p>
            @else
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($topProducts as $product)
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; display: flex; justify-content: space-between; align-items: flex-start; transition: background .18s ease;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                            <div style="flex: 1;">
                                <h3 style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">{{ $product->name }}</h3>
                                <p style="color: #6b7280; font-size: 14px;">{{ $product->category?->name ?? 'N/A' }}</p>
                                <p style="color: #9ca3af; font-size: 14px; margin-top: 8px;">Harga: <span style="font-weight: 700; color: #f59e0b;">Rp {{ number_format($product->harga, 0, ',', '.') }}</span></p>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 24px; font-weight: 700; color: #0f172a;">{{ $product->ratings->count() }}</div>
                                <p style="color: #6b7280; font-size: 12px;">rating</p>
                                <div style="color: #fbbf24; font-size: 16px; margin-top: 8px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($product->average_rating))
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <p style="font-size: 14px; color: #6b7280;">{{ number_format($product->average_rating, 1) }}/5</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- All Products Summary -->
        <div class="stats-card" style="margin-top: 32px;">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Semua Produk ({{ $products->count() }})</h2>
            
            @if($products->isEmpty())
                <p style="color: #6b7280; text-align: center; padding: 32px 0; margin: 0;">Anda belum menambahkan produk</p>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                        <thead style="background: linear-gradient(90deg, rgba(255,179,71,0.12), rgba(245,158,11,0.08)); border-bottom: 2px solid #e5e7eb;">
                            <tr>
                                <th style="text-align: left; padding: 12px; font-weight: 600; color: #0f172a;">Produk</th>
                                <th style="text-align: left; padding: 12px; font-weight: 600; color: #0f172a;">Kategori</th>
                                <th style="text-align: right; padding: 12px; font-weight: 600; color: #0f172a;">Harga</th>
                                <th style="text-align: center; padding: 12px; font-weight: 600; color: #0f172a;">Stok</th>
                                <th style="text-align: center; padding: 12px; font-weight: 600; color: #0f172a;">Rating</th>
                                <th style="text-align: center; padding: 12px; font-weight: 600; color: #0f172a;">Jumlah Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background .18s ease;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px; font-weight: 600;">{{ $product->name }}</td>
                                    <td style="padding: 12px; color: #6b7280;">{{ $product->category?->name ?? '-' }}</td>
                                    <td style="padding: 12px; text-align: right; color: #f59e0b; font-weight: 600;">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; {{ $product->stock > 0 ? 'background: #d1fae5; color: #065f46;' : 'background: #fee2e2; color: #991b1b;' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px; text-align: center; color: #fbbf24;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->average_rating))
                                                ⭐
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </td>
                                    <td style="padding: 12px; text-align: center; color: #0f172a; font-weight: 700;">{{ $product->ratings->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            if (menu.style.display === 'none') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('[style*="position: relative"]');
            const menu = document.getElementById('dropdownMenu');
            if (dropdown && !dropdown.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    </script>

</body>
</html>
