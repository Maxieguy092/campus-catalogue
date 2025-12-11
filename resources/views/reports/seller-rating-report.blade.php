<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Produk Berdasarkan Rating</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.6; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 15px; }
        .header h1 { font-size: 18px; color: #0066cc; margin-bottom: 5px; font-weight: bold; }
        .header p { font-size: 10px; color: #666; }
        .info-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead { background: #0066cc; color: white; }
        th { text-align: left; padding: 10px; font-weight: bold; font-size: 10px; border: 1px solid #0066cc; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background: #f5f5f5; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .empty { text-align: center; padding: 30px; color: #999; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN PRODUK BERDASARKAN RATING</h1>
            <p>Campus Marketplace - Diurutkan Rating Menurun</p>
        </div>

        <div class="info-row">
            <span><strong>Toko:</strong> Toko Saya</span>
            <span><strong>Tanggal:</strong> {{ $generatedAt }}</span>
        </div>

        @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Produk</th>
                        <th style="width: 12%;">Kategori</th>
                        <th class="right" style="width: 10%;">Harga</th>
                        <th class="center" style="width: 10%;">Stok</th>
                        <th class="center" style="width: 10%;">Rating</th>
                        <th class="center" style="width: 8%;">Reviews</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products->sortByDesc('average_rating') as $i => $product)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td class="right">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="center">{{ $product->stock }}</td>
                            <td class="center">{{ number_format($product->average_rating, 1) }}</td>
                            <td class="center">{{ $product->rating_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">Tidak ada produk ditemukan</div>
        @endif

        <div class="footer">
            <p>Laporan ini dibuat otomatis oleh sistem Campus Marketplace pada {{ $generatedAt }}</p>
        </div>
    </div>
</body>
</html>
