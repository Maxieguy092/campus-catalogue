<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Seller - {{ $seller->store_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-10">

    <div class="max-w-4xl mx-auto">

        <a href="{{ route('platform.dashboard') }}"
        class="inline-block px-4 py-2 mt-4 bg-white border border-gray-400 text-gray-700 rounded hover:bg-gray-100 shadow">
            ← Kembali ke Dashboard
        </a>

        <h1 class="text-3xl font-bold mb-6">Detail Seller: {{ $seller->store_name }}</h1>

        <!-- ===== Informasi Toko ===== -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Toko</h2>

            <p><strong>Nama Toko:</strong> {{ $seller->store_name }}</p>
            <p><strong>Deskripsi:</strong> {{ $seller->store_description }}</p>

            <p class="mt-2">
                <strong>Status:</strong>
                @if($seller->status === 'pending')
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Pending</span>
                @elseif($seller->status === 'accepted')
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Accepted</span>
                @elseif($seller->status === 'rejected')
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Rejected</span>
                @endif
            </p>

            <p class="mt-2"><strong>Dibuat Pada:</strong> {{ $seller->created_at }}</p>
        </div>

        <!-- ===== Informasi PIC ===== -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Informasi PIC</h2>

            <p><strong>Nama PIC:</strong> {{ $seller->pic_name }}</p>
            <p><strong>Telepon:</strong> {{ $seller->pic_phone }}</p>
            <p><strong>Email:</strong> {{ $seller->pic_email }}</p>

            <h3 class="font-semibold mt-4 mb-1">Alamat PIC</h3>
            <p>
                {{ $seller->pic_street }}<br>
                RT {{ $seller->pic_rt }} / RW {{ $seller->pic_rw }}<br>
                Desa/Kel: {{ $seller->pic_village }}<br>
                Kota: {{ $seller->pic_city }}<br>
                Provinsi: {{ $seller->pic_province }}
            </p>

            <p class="mt-3"><strong>No KTP:</strong> {{ $seller->pic_ktp_number }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <!-- Foto PIC -->
                <div>
                    <h4 class="font-semibold mb-1">Foto PIC:</h4>
                    @if($seller->pic_photo_path)
                        <img src="{{ asset('storage/' . $seller->pic_photo_path) }}"
                             class="rounded shadow-md max-w-xs">
                    @else
                        <p class="text-gray-500">Belum ada foto.</p>
                    @endif
                </div>

                <!-- Foto KTP -->
                <div>
                    <h4 class="font-semibold mb-1">Foto KTP:</h4>
                    @if($seller->pic_ktp_file_path)
                        <img src="{{ asset('storage/' . $seller->pic_ktp_file_path) }}"
                             class="rounded shadow-md max-w-xs">
                    @else
                        <p class="text-gray-500">Belum ada file KTP.</p>
                    @endif
                </div>

            </div>
        </div>

        <a href="{{ route('platform.dashboard') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Kembali
        </a>

    </div>

</body>
</html>

