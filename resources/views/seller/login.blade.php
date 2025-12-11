<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penjual</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-xl mx-auto mt-16 mb-12">

        <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">
            Login Akun Penjual Marketplace
        </h1>

        {{-- ALERT SUCCESS --}}
        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
        @endif

        {{-- ALERT ERROR --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded-md mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('seller.login.submit') }}" method="POST" class="space-y-8">
            @csrf

            <!-- CARD LOGIN -->
            <div class="bg-white p-8 rounded-xl shadow-md">

                <div class="space-y-6">

                    <!-- EMAIL -->
                    <div>
                        <label class="font-semibold text-gray-700">Email *</label>
                        <input type="email" name="pic_email"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300"
                               required>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="font-semibold text-gray-700">Password *</label>
                        <input type="password" name="password"
                               class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300"
                               required>
                    </div>

                </div>

                <!-- REMEMBER ME -->
                <div class="mt-6 flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 border-gray-300 rounded">
                    <label for="remember" class="text-gray-700 text-sm font-medium">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white p-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition">
                Masuk Sekarang
            </button>

            <!-- LINK TO REGISTER -->
            <p class="text-center text-gray-700 mt-4">
                Belum punya akun?
                <a href="{{ route('seller.register') }}" class="text-blue-600 font-semibold hover:underline">
                    Daftar sebagai Penjual
                </a>
            </p>

        </form>

    </div>

</body>
</html>
