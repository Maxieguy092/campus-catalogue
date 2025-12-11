<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Toko Berdasarkan Lokasi Provinsi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.6; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 15px; }
        .header h1 { font-size: 18px; color: #0066cc; margin-bottom: 5px; font-weight: bold; }
        .header p { font-size: 10px; color: #666; }
        .info-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 10px; }
        .province-section { margin-top: 25px; }
        .province-title { background: #0066cc; color: white; padding: 10px; font-weight: bold; font-size: 11px; border-radius: 3px 3px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 0; }
        thead { background: #e6f0ff; }
        th { text-align: left; padding: 10px; font-weight: bold; font-size: 10px; border: 1px solid #0066cc; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background: #f5f5f5; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .empty { text-align: center; padding: 20px; color: #999; font-size: 10px; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN TOKO BERDASARKAN LOKASI PROVINSI</h1>
            <p>Campus Marketplace - Distribusi Toko per Provinsi</p>
        </div>

        <div class="info-row">
            <span><strong>Platform:</strong> Campus Marketplace</span>
            <span><strong>Tanggal:</strong> {{ $generatedAt }}</span>
        </div>

        @if($sellersByProvince->count() > 0)
            @foreach($sellersByProvince as $province => $provinceSellers)
                <div class="province-section">
                    <div class="province-title">
                        Provinsi: {{ $province }} ({{ $provinceSellers->count() }} Toko)
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 18%;">Nama Toko</th>
                                <th style="width: 14%;">Pemilik</th>
                                <th style="width: 12%;">Kecamatan</th>
                                <th style="width: 14%;">Email</th>
                                <th style="width: 12%;">No. Telp</th>
                                <th style="width: 12%;">Produk</th>
                                <th style="width: 13%;">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($provinceSellers as $i => $seller)
                                <tr>
                                    <td class="center">{{ $i + 1 }}</td>
                                    <td>{{ $seller->store_name }}</td>
                                    <td>{{ $seller->pic_name }}</td>
                                    <td>{{ $seller->pic_kecamatan ?? '-' }}</td>
                                    <td>{{ $seller->pic_email }}</td>
                                    <td>{{ $seller->pic_phone }}</td>
                                    <td class="center">{{ $seller->products->count() }}</td>
                                    <td class="center">{{ $seller->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="empty">Tidak ada data toko ditemukan</div>
        @endif

        <div class="footer">
            <p>Laporan ini dibuat otomatis oleh sistem Campus Marketplace pada {{ $generatedAt }}</p>
        </div>
    </div>
</body>
</html>
