<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Produk dan Rating</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 10px; color: #333; line-height: 1.5; }
        .container { width: 100%; padding: 15px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #0066cc; padding-bottom: 10px; }
        .header h1 { font-size: 16px; color: #0066cc; margin-bottom: 3px; font-weight: bold; }
        .header p { font-size: 9px; color: #666; }
        .info-row { display: flex; justify-content: space-between; margin: 8px 0; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 9px; }
        thead { background: #0066cc; color: white; }
        th { text-align: left; padding: 8px; font-weight: bold; font-size: 9px; border: 1px solid #0066cc; }
        td { padding: 6px; border: 1px solid #ddd; }
        tr:nth-child(even) { background: #f5f5f5; }
        .footer { margin-top: 15px; text-align: right; font-size: 8px; color: #999; border-top: 1px solid #ddd; padding-top: 8px; }
        .empty { text-align: center; padding: 20px; color: #999; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN PRODUK DAN RATING</h1>
            <p>Campus Marketplace - Diurutkan Rating Menurun</p>
        </div>

        <div class="info-row">
            <span><strong>Platform:</strong> Campus Marketplace</span>
            <span><strong>Total Produk:</strong> {{ $products->count() }} | <strong>Tanggal:</strong> {{ $generatedAt }}</span>
        </div>

        @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 16%;">Nama Produk</th>
                        <th style="width: 12%;">Toko</th>
                        <th style="width: 11%;">Kategori</th>
                        <th class="right" style="width: 10%;">Harga</th>
                        <th style="width: 10%;">Provinsi</th>
                        <th class="center" style="width: 8%;">Rating</th>
                        <th class="center" style="width: 7%;">Reviews</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products->sortByDesc('average_rating') as $i => $product)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>{{ substr($product->name, 0, 20) }}{{ strlen($product->name) > 20 ? '...' : '' }}</td>
                            <td>{{ substr($product->seller->store_name ?? '-', 0, 12) }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td class="right">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->seller->pic_province ?? '-' }}</td>
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
