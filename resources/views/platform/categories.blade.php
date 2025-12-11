<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori</title>
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
        </aside>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-auto">
            <h2 class="text-2xl font-bold mb-6">Manajemen Kategori</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Category -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Tambah Kategori</h3>

                <form method="POST" action="{{ route('platform.categories.store') }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" class="border p-2 rounded w-64" placeholder="Nama kategori">
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        Tambah
                    </button>
                </form>
            </div>

            <!-- Category List -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Daftar Kategori</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Nama Kategori</th>
                            <th class="p-3 w-32">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b">
                                <td class="p-3">{{ $category->name }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('platform.categories.delete', $category->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-6 text-gray-500">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </main>
    </div>
</body>

</html>
