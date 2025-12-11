<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Dashboard Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .container { max-width: 297mm; margin: 0 auto; padding: 15mm; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #3b82f6; padding-bottom: 15px; }
        .header h1 { font-size: 22px; color: #3b82f6; margin-bottom: 5px; }
        .header p { font-size: 10px; color: #666; }
        .stats { display: flex; gap: 15px; margin: 20px 0; }
        .stat-box { flex: 1; border: 1px solid #e5e7eb; padding: 12px; border-radius: 5px; background: #f9fafb; text-align: center; }
        .stat-label { font-size: 10px; color: #666; font-weight: bold; }
        .stat-value { font-size: 24px; font-weight: bold; color: #3b82f6; margin-top: 3px; }
        .section { margin: 20px 0; }
        .section-title { font-size: 13px; font-weight: bold; color: #1f2937; margin-bottom: 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead { background: #f3f4f6; }
        th { text-align: left; padding: 6px; font-weight: bold; font-size: 10px; border: 1px solid #e5e7eb; }
        td { padding: 6px; border: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 8px; }
        .status-badge { padding: 2px 6px; border-radius: 3px; font-weight: bold; font-size: 9px; text-align: center; }
        .accepted { background: #d1fae5; color: #065f46; }
        .pending { background: #fef3c7; color: #92400e; }
        .rejected { background: #fee2e2; color: #991b1b; }
        .empty { text-align: center; padding: 15px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 Laporan Dashboard Admin</h1>
            <p>Campus Marketplace Platform Analytics</p>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-box">
                <div class="stat-label">Total Penjual</div>
                <div class="stat-value">{{ $totalSellers }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Penjual Aktif</div>
                <div class="stat-value" style="color: #10b981;">{{ $activeSellers }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pending Review</div>
                <div class="stat-value" style="color: #f59e0b;">{{ $pendingSellers }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Ditolak</div>
                <div class="stat-value" style="color: #ef4444;">{{ $rejectedSellers }}</div>
            </div>
        </div>

        <!-- Latest Sellers -->
        <div class="section">
            <h3 class="section-title">👥 Daftar Penjual Terbaru (Top 10)</h3>
            @if($latestSellers->isEmpty())
                <p class="empty">Belum ada data penjual</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Toko</th>
                            <th>PIC Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestSellers as $seller)
                            <tr>
                                <td>{{ $seller->store_name }}</td>
                                <td>{{ $seller->pic_name }}</td>
                                <td>{{ $seller->pic_email }}</td>
                                <td>{{ $seller->pic_phone }}</td>
                                <td>{{ $seller->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="status-badge {{ $seller->status }}">
                                        {{ ucfirst($seller->status) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan dihasilkan pada: {{ $generatedAt }}</p>
            <p>© Campus Marketplace Admin Panel</p>
        </div>
    </div>
</body>
</html>
