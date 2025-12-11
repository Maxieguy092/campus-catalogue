<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Campus Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --amber: #f59e0b;
            --accent: #ffb347;
        }
        .rating-stars { color: var(--amber); }
        .star { cursor: pointer; font-size: 28px; transition: all 0.2s; }
        .star:hover { transform: scale(1.2); }
        .star.active { color: var(--amber); }
        .star.inactive { color: #d1d5db; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('catalogue') }}" class="flex items-center gap-3">
                    <div class="rounded-lg p-2" style="background:linear-gradient(135deg,var(--amber),var(--accent)); color:white; font-weight:700;">CM</div>
                    <div>
                        <div class="text-lg font-semibold">Campus Marketplace</div>
                        <div class="text-xs text-gray-500">Katalog Produk</div>
                    </div>
                </a>
                <a href="{{ route('catalogue') }}" class="text-gray-600 hover:text-gray-800 font-semibold">← Kembali ke Katalog</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ session('error') }}
        </div>
        @endif

        <!-- Product Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 items-stretch">

            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow-md p-6 h-full">
                <img 
                    src="{{ $product->image_url }}" 
                    alt="{{ $product->name }}"
                    class="w-full rounded-lg"
                    style="object-fit:cover;"
                >
            </div>

            <!-- Product Info -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 h-full">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    
                    <!-- Rating Summary -->
                    <div class="mb-6 pb-6 border-b">
                        <div class="flex items-center gap-4">
                            <div>
                                <div class="text-4xl font-bold">{{ number_format($product->average_rating, 1) }}</div>
                                <div class="text-sm text-gray-600">dari 5</div>
                            </div>
                            <div>
                                <div class="rating-stars text-2xl">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($product->average_rating))
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600 mt-1">{{ $product->rating_count }} ulasan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Stock -->
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-amber-600 mb-2">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </div>
                        <div class="flex gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Stok Tersedia</p>
                                <p class="text-2xl font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock }} unit
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Seller Info -->
                    @if($product->seller)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">📍 Penjual</h3>
                        <p class="text-lg font-bold">{{ $product->seller->store_name }}</p>
                        <p class="text-sm text-gray-600">{{ $product->seller->pic_city }}, {{ $product->seller->pic_province }}</p>
                    </div>
                    @endif
                </div>

                
            </div>

        </div>

        <!-- Product Details Full Width -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">Detail Produk</h3>
            <div class="space-y-4">
                <div class="pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-1">Kondisi</p>
                    <p class="font-semibold text-gray-800">{{ $product->kondisi }}</p>
                </div>
                <div class="pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-1">Min. Pemesanan</p>
                    <p class="font-semibold text-gray-800">1 buah</p>
                </div>
                <div class="pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-1">Kategori</p>
                    <p class="font-semibold text-gray-800">{{ $product->category->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Deskripsi</p>
                    <p class="text-gray-800">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
        </div>

        <!-- Rating & Comments Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Rating Form -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-6">Berikan Rating</h2>

                    @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('product.rating.store', $product->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama *</label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Nama Anda"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="email@example.com"
                            >
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP *</label>
                            <input 
                                type="text" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="+62 812..."
                            >
                        </div>

                        <!-- Province -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                            <select 
                                name="province" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            >
                                <option value="">-- Pilih Provinsi --</option>
                                @php
                                    use App\Helpers\LocationHelper;
                                    $provinces = LocationHelper::getProvinces();
                                @endphp
                                @foreach($provinces as $province)
                                    <option value="{{ $province }}" {{ old('province') === $province ? 'selected' : '' }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rating Stars -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating *</label>
                            <div class="flex gap-2" id="rating-input">
                                @for($i = 1; $i <= 5; $i++)
                                    <span 
                                        class="star inactive" 
                                        data-value="{{ $i }}"
                                        onclick="setRating({{ $i }})"
                                    >★</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 0) }}" required>
                        </div>

                        <!-- Comment -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Komentar (Opsional)</label>
                            <textarea 
                                name="comment" 
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Bagikan pengalaman Anda..."
                            >{{ old('comment') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 1000 karakter</p>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full py-2 px-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg transition"
                        >
                            ✓ Kirim Rating
                        </button>
                    </form>
                </div>
            </div>

            <!-- Comments List -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6">
                        Ulasan Produk ({{ $product->rating_count }})
                    </h2>

                    @forelse($product->ratings as $rating)
                    <div class="pb-6 mb-6 border-b last:border-b-0">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $rating->name }}</p>
                                <p class="text-xs text-gray-500">{{ $rating->province }}</p>
                            </div>
                            <p class="text-xs text-gray-400">
                                {{ $rating->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Rating Stars -->
                        <div class="rating-stars text-lg mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating)
                                    ⭐
                                @else
                                    ☆
                                @endif
                            @endfor
                            <span class="text-gray-600 text-sm ml-2">({{ $rating->rating }}/5)</span>
                        </div>

                        <!-- Comment -->
                        @if($rating->comment)
                        <p class="text-gray-700">{{ $rating->comment }}</p>
                        @else
                        <p class="text-gray-500 italic">Tidak ada komentar</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500 mb-2">Belum ada ulasan untuk produk ini</p>
                        <p class="text-sm text-gray-400">Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <script>
        function setRating(value) {
            document.getElementById('rating-value').value = value;
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                if (index < value) {
                    star.classList.remove('inactive');
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                    star.classList.add('inactive');
                }
            });
        }

        // Initialize stars if there's an old value
        const initialRating = document.getElementById('rating-value').value;
        if (initialRating) {
            setRating(initialRating);
        }
    </script>

</body>
</html>
