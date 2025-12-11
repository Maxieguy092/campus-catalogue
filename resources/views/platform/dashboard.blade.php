<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< HEAD
=======
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
>>>>>>> master
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- ========== Sidebar ========== -->
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-blue-700 tracking-wide">SellerHub</h1>
            </div>

            <nav class="mt-4 flex flex-col gap-1">

                <!-- Dashboard -->
                <a href="{{ route('platform.dashboard') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-700 font-semibold rounded-md 
                        hover:bg-blue-50 hover:text-blue-700 transition">

                    <span class="text-lg">📊</span>
                    Dashboard
                </a>

                <!-- Categories -->
                <a href="{{ route('platform.categories') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-700 font-semibold rounded-md 
                        hover:bg-blue-50 hover:text-blue-700 transition">

                    <span class="text-lg">📁</span>
                    Kategori
                </a>

            </nav>

            <div class="mt-auto p-6 border-t text-sm text-gray-400">
                Seller Panel • {{ date('Y') }}
            </div>
        </aside>



        <!-- ========== Content ========== -->
        <main class="flex-1 p-8 overflow-auto">

<<<<<<< HEAD
            <h2 class="text-2xl font-bold mb-6">Dashboard Penjual</h2>
=======
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Dashboard Penjual</h2>
                <div class="flex gap-3">
                    <!-- Dropdown Laporan -->
                    <div class="relative inline-block">
                        <button onclick="toggleDropdown()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition">
                            📋 Laporan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <a href="{{ route('platform.reports.seller-list') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 first:rounded-t-lg transition">
                                👥 Laporan Daftar Akun Penjual
                            </a>
                            <a href="{{ route('platform.reports.store-by-province') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 transition border-t">
                                🏪 Laporan Toko per Provinsi
                            </a>
                            <a href="{{ route('platform.reports.product-rating') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 last:rounded-b-lg transition border-t">
                                📊 Laporan Produk & Rating
                            </a>
                        </div>
                    </div>
                    
                    <!-- Dashboard PDF -->
                    <a href="{{ route('platform.dashboard.export-pdf') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 transition">
                        📄 Dashboard PDF
                    </a>
                </div>
            </div>
>>>>>>> master

            <!-- ===== Flash Message ===== -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ===== Stats ===== -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="p-5 bg-white shadow rounded-lg">
                    <p class="text-gray-500">Total Penjual</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $totalSellers }}</h3>
                </div>

                <div class="p-5 bg-white shadow rounded-lg">
                    <p class="text-gray-500">Penjual Aktif</p>
                    <h3 class="text-2xl font-bold mt-2 text-green-600">{{ $activeSellers }}</h3>
                </div>

                <div class="p-5 bg-white shadow rounded-lg">
                    <p class="text-gray-500">Pending Review</p>
                    <h3 class="text-2xl font-bold mt-2 text-yellow-600">{{ $pendingSellers }}</h3>
                </div>

            </div>

<<<<<<< HEAD
=======
            <!-- ===== Charts ===== -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                <!-- Chart 1: Status Distribution -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Distribusi Status Penjual</h3>
                    <div class="h-64">
                        <canvas id="sellerStatusChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Seller Growth -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Pertumbuhan Penjual (7 hari terakhir)</h3>
                    <div class="h-64">
                        <canvas id="sellerGrowthChart" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>

>>>>>>> master
            <!-- ===== Table Latest Sellers ===== -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Daftar Penjual Terbaru</h3>

                    <!-- Filter Status -->
                    <form method="GET" action="{{ route('platform.dashboard') }}">
                        <select name="status" onchange="this.form.submit()" class="border rounded-md p-2 text-sm">
                            <option value="">Semua Status</option>
                            <option value="accepted" {{ $currentStatus == 'accepted' ? 'selected' : '' }}>accepted</option>
                            <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>pending</option>
                            <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>rejected</option>
                        </select>
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Penjual</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Bergabung</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestSellers as $seller)
                            <tr class="border-b">
                                <td class="p-3">{{ $seller->store_name }}</td>
                                <td class="p-3">{{ $seller->pic_email }}</td>
                                <td class="p-3">{{ $seller->created_at->format('d M Y') }}</td>

                                <td class="p-3">
                                    @if ($seller->status === 'accepted')
                                        <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">accepted</span>

                                    @elseif ($seller->status === 'pending')
                                        <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">pending</span>

                                    @else
                                        <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">rejected</span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <div class="flex gap-2">

                                        <!-- DETAIL BUTTON -->
                                        <a href="{{ route('platform.seller.detail', $seller->id) }}"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                            Detail
                                        </a>

                                        @if ($seller->status === 'pending')

                                            <!-- APPROVE -->
                                            <form method="POST" action="{{ route('platform.seller.approve', $seller->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                                    Approve
                                                </button>
                                            </form>

                                            <!-- REJECT -->
                                            <form method="POST" action="{{ route('platform.seller.reject', $seller->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                                    Reject
                                                </button>
                                            </form>

                                        @endif
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    Tidak ada data penjual.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </main>
    </div>

<<<<<<< HEAD
=======
    <script>
        // Chart 1: Seller Status Distribution (Pie Chart)
        const statusCtx = document.getElementById('sellerStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Pending', 'Rejected'],
                datasets: [{
                    data: [{{ $activeSellers }}, {{ $pendingSellers }}, {{ $totalSellers - $activeSellers - $pendingSellers }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Chart 2: Seller Growth (Line Chart with dummy data)
        const growthCtx = document.getElementById('sellerGrowthChart').getContext('2d');
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: ['6 hari lalu', '5', '4', '3', '2', '1', 'Hari ini'],
                datasets: [{
                    label: 'Penjual Baru',
                    data: [2, 3, 2, 4, 3, 5, 4],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.08)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.relative');
            if (!dropdown.contains(event.target)) {
                document.getElementById('dropdownMenu').classList.add('hidden');
            }
        });
    </script>

>>>>>>> master
</body>

</html>

<<<<<<< HEAD


=======
>>>>>>> master
