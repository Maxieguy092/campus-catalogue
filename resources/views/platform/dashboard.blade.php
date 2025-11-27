<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

            <h2 class="text-2xl font-bold mb-6">Dashboard Penjual</h2>

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

</body>

</html>



