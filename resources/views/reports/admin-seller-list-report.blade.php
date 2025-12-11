<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Daftar Akun Penjual</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.6; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 15px; }
        .header h1 { font-size: 18px; color: #0066cc; margin-bottom: 5px; font-weight: bold; }
        .header p { font-size: 10px; color: #666; }
        .info-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 10px; }
        .stats { display: flex; gap: 15px; margin: 15px 0; }
        .stat-box { flex: 1; border: 1px solid #ddd; padding: 10px; border-radius: 3px; background: #f9f9f9; text-align: center; }
        .stat-label { font-size: 9px; color: #666; }
        .stat-value { font-size: 16px; font-weight: bold; color: #0066cc; margin-top: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead { background: #0066cc; color: white; }
        th { text-align: left; padding: 10px; font-weight: bold; font-size: 10px; border: 1px solid #0066cc; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background: #f5f5f5; }
        .badge { padding: 3px 8px; border-radius: 3px; font-size: 9px; font-weight: bold; }
        .badge-aktif { background: #e6ffe6; color: #00cc00; }
        .badge-pending { background: #fff4e6; color: #ff9900; }
        .badge-ditolak { background: #ffe6e6; color: #cc0000; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .empty { text-align: center; padding: 30px; color: #999; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN DAFTAR AKUN PENJUAL</h1>
            <p>Campus Marketplace - Status Aktif dan Tidak Aktif</p>
        </div>

        <div class="info-row">
            <span><strong>Platform:</strong> Campus Marketplace</span>
            <span><strong>Tanggal:</strong> {{ $generatedAt }}</span>
        </div>

        <div class="stats">
            <div class="stat-box">
                <div class="stat-label">Total Penjual</div>
                <div class="stat-value">{{ $sellers->count() }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Penjual Aktif</div>
                <div class="stat-value">{{ $sellers->where('status', 'accepted')->count() }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pending Review</div>
                <div class="stat-value">{{ $sellers->where('status', 'pending')->count() }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Ditolak</div>
                <div class="stat-value">{{ $sellers->where('status', 'rejected')->count() }}</div>
            </div>
        </div>

        @if($sellers->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Nama Toko</th>
                        <th style="width: 15%;">Pemilik</th>
                        <th style="width: 12%;">Kecamatan</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 12%;">No. Telp</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 14%;">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellers as $i => $seller)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>{{ $seller->store_name }}</td>
                            <td>{{ $seller->pic_name }}</td>
                            <td>{{ $seller->pic_kecamatan ?? '-' }}</td>
                            <td>{{ $seller->pic_email }}</td>
                            <td>{{ $seller->pic_phone }}</td>
                            <td class="center">
                                @if($seller->status === 'accepted')
                                    <span class="badge badge-aktif">Aktif</span>
                                @elseif($seller->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @else
                                    <span class="badge badge-ditolak">Ditolak</span>
                                @endif
                            </td>
                            <td class="center">{{ $seller->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">Tidak ada data penjual ditemukan</div>
        @endif

        <div class="footer">
            <p>Laporan ini dibuat otomatis oleh sistem Campus Marketplace pada {{ $generatedAt }}</p>
        </div>
    </div>
</body>
</html>
