<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Dashboard Penjual</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .container { max-width: 210mm; margin: 0 auto; padding: 20mm; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #3b82f6; padding-bottom: 15px; }
        .header h1 { font-size: 24px; color: #3b82f6; margin-bottom: 5px; }
        .header p { font-size: 11px; color: #666; }
        .stats { display: flex; gap: 20px; margin: 25px 0; }
        .stat-box { flex: 1; border: 1px solid #e5e7eb; padding: 15px; border-radius: 5px; background: #f9fafb; }
        .stat-label { font-size: 11px; color: #666; font-weight: bold; }
        .stat-value { font-size: 28px; font-weight: bold; color: #3b82f6; margin-top: 5px; }
        .section { margin: 25px 0; }
        .section-title { font-size: 14px; font-weight: bold; color: #1f2937; margin-bottom: 12px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #f3f4f6; }
        th { text-align: left; padding: 8px; font-weight: bold; font-size: 11px; border: 1px solid #e5e7eb; }
        td { padding: 8px; border: 1px solid #e5e7eb; font-size: 11px; }
        tr:nth-child(even) { background: #f9fafb; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .rating-stars { color: #f59e0b; }
        .price { color: #10b981; font-weight: bold; }
        .empty { text-align: center; padding: 20px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 Laporan Dashboard Penjual</h1>
            <p>Campus Marketplace Seller Analytics</p>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-box">
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $totalProducts }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Rating</div>
                <div class="stat-value">{{ $totalRatings }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Rata-rata Rating</div>
                <div class="stat-value">{{ number_format($averageRating, 1) }} ⭐</div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="section">
            <h3 class="section-title">🔝 Produk Terlaris (Top 5)</h3>
            @if($topProducts->isEmpty())
                <p class="empty">Belum ada data produk dengan rating</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Jumlah Rating</th>
                            <th>Rating Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? '-' }}</td>
                                <td class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td style="text-align: center;">{{ $product->ratings->count() }}</td>
                                <td class="rating-stars" style="text-align: center;">{{ number_format($product->average_rating, 1) }} ⭐</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- All Products -->
        <div class="section">
            <h3 class="section-title">📦 Semua Produk ({{ $products->count() }})</h3>
            @if($products->isEmpty())
                <p class="empty">Belum ada produk</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? '-' }}</td>
                                <td class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td style="text-align: center;">{{ $product->stock }}</td>
                                <td class="rating-stars" style="text-align: center;">{{ number_format($product->average_rating, 1) }} ⭐ ({{ $product->ratings->count() }})</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan dihasilkan pada: {{ $generatedAt }}</p>
            <p>© Campus Marketplace</p>
        </div>
    </div>
</body>
</html>
