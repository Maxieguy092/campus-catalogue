<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Penjual</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto mt-12 mb-12">

        <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">
            Bergabung sebagai Penjual Marketplace
        </h1>

        {{-- ALERT --}}
        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded-md mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <form action="{{ route('seller.register.submit') }}" method="POST" 
              enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- ============================== -->
            <!-- 1. Informasi Toko -->
            <!-- ============================== -->
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4 flex items-center gap-2">
                    🏬 Informasi Toko
                </h2>

                <div class="space-y-5">

                    <div>
                        <label class="font-semibold text-gray-700">Nama Toko *</label>
                        <input type="text" name="store_name"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Deskripsi Toko *</label>
                        <textarea name="store_description"
                                  class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300"
                                  rows="3"></textarea>
                    </div>

                </div>
            </div>

            <!-- ============================== -->
            <!-- 2. Informasi Pribadi -->
            <!-- ============================== -->
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4 flex items-center gap-2">
                    👤 Informasi Personal PIC
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="font-semibold text-gray-700">Nama Lengkap *</label>
                        <input type="text" name="pic_name"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Nomor HP *</label>
                        <input type="text" name="pic_phone"
                               placeholder="+62 ..."
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Email *</label>
                        <input type="email" name="pic_email"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Nomor KTP *</label>
                        <input type="text" name="pic_ktp_number"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                </div>
            </div>

            <!-- ============================== -->
            <!-- 3. Informasi Alamat -->
            <!-- ============================== -->
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📍 Informasi Alamat
                </h2>

                <div class="space-y-5">

                    <div>
                        <label class="font-semibold text-gray-700">Alamat Jalan *</label>
                        <input type="text" name="pic_street"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="font-semibold text-gray-700">RT *</label>
                            <input type="text" name="pic_rt"
                                   class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">RW *</label>
                            <input type="text" name="pic_rw"
                                   class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Kelurahan *</label>
                            <input type="text" name="pic_village"
                                   class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-semibold text-gray-700">Provinsi *</label>
                            <select id="provinsi" name="pic_province"
                                    onchange="loadKota()"
                                    class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Kota/Kabupaten *</label>
                            <select id="kota" name="pic_city"
                                    class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300">
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ============================== -->
            <!-- 4. Dokumen -->
            <!-- ============================== -->
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📄 Upload Dokumen
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Upload Foto Profil -->
                    <div>
                        <label class="font-semibold text-gray-700">Foto Profil *</label>

                        <label for="fotoProfil" 
                            class="cursor-pointer mt-2 flex flex-col items-center justify-center 
                                border border-gray-300 border-dashed rounded-lg h-64 bg-gray-50 
                                hover:bg-gray-100 transition relative">

                            <!-- PREVIEW FOTO -->
                            <img id="previewProfil"
                                class="hidden absolute inset-0 w-full h-full object-cover rounded-lg" />

                            <!-- ICON -->
                            <div id="iconProfil" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-10 h-10 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2 9m2-9h10m0 0l2 9m-2-9l-4-8m-6 17a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-gray-600 mt-2">Klik untuk mengupload foto profil</p>
                                <p class="text-xs text-gray-400">PNG, JPG hingga 2MB</p>
                            </div>
                        </label>

                        <input type="file" id="fotoProfil" name="pic_photo_path" accept="image/*" class="hidden">
                    </div>

                    <!-- Upload Foto KTP -->
                    <div>
                        <label class="font-semibold text-gray-700">Foto / Scan KTP *</label>

                        <label for="fotoKTP" 
                            class="cursor-pointer mt-2 flex flex-col items-center justify-center 
                                border border-gray-300 border-dashed rounded-lg h-64 bg-gray-50 
                                hover:bg-gray-100 transition relative">

                            <!-- PREVIEW KTP -->
                            <img id="previewKTP"
                                class="hidden absolute inset-0 w-full h-full object-cover rounded-lg" />

                            <!-- ICON -->
                            <div id="iconKTP" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-10 h-10 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zM4 6h16v12H4z" />
                                </svg>
                                <p class="text-gray-600 mt-2">Klik untuk mengupload foto KTP</p>
                                <p class="text-xs text-gray-400">PNG, JPG hingga 2MB</p>
                            </div>
                        </label>

                        <input type="file" id="fotoKTP" name="pic_ktp_file_path" accept="image/*" class="hidden">
                    </div>

                </div>

                <div class="mt-6">
                    <label class="font-semibold">Password Akun *</label>
                    <input type="password" name="password"
                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300">
                </div>
            </div>

            <!-- Script Preview Foto -->
            <script>
                // Preview Foto Profil
                document.getElementById("fotoProfil").addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById("previewProfil");
                    const icon = document.getElementById("iconProfil");

                    if (file) {
                        preview.src = URL.createObjectURL(file);
                        preview.classList.remove("hidden");
                        icon.classList.add("hidden");
                    }
                });

                // Preview Foto KTP
                document.getElementById("fotoKTP").addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById("previewKTP");
                    const icon = document.getElementById("iconKTP");

                    if (file) {
                        preview.src = URL.createObjectURL(file);
                        preview.classList.remove("hidden");
                        icon.classList.add("hidden");
                    }
                });
            </script>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white p-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition">
                Daftar Sekarang
            </button>

        </form>
    </div>

    <script>

        const dataIndonesia = @json($dataIndonesia);

        // --- FUNGSI MENGISI SELECT ---
        function loadProvinsi() {
            const provinsiSelect = document.getElementById("provinsi");

            for (let prov in dataIndonesia) {
                let opt = document.createElement("option");
                opt.value = prov;
                opt.textContent = prov;
                provinsiSelect.appendChild(opt);
            }
        }

        function loadKota() {
            const prov = document.getElementById("provinsi").value;
            const kotaSelect = document.getElementById("kota");

            kotaSelect.innerHTML = "";

            if (prov && dataIndonesia[prov]) {
                dataIndonesia[prov].forEach(kota => {
                    let opt = document.createElement("option");
                    opt.value = kota;
                    opt.textContent = kota;
                    kotaSelect.appendChild(opt);
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            loadProvinsi();
        });
        </script>

</body>
</html>

