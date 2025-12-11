<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Edit Produk — CampusMarket</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather+Sans:wght@400;700&display=swap" rel="stylesheet">

<!-- Icons -->
<script src="https://unpkg.com/lucide@0.252.0/dist/lucide.min.js"></script>

<!-- Tailwind -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Custom Theme -->
<style>
:root{
  --amber:#f59e0b;
  --accent:#ffb347;
  --navy:#0f172a;
  --soft:#f9fafb;
}
body{
  font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;
  background:var(--soft);
  color:var(--navy);
}
.card-hover{transition:transform .18s ease, box-shadow .18s ease;}
.card-hover:hover{transform:translateY(-6px); box-shadow:0 12px 30px rgba(15,23,42,0.08);}
.button-amber{
  background:var(--amber);
  color:white;
}
.button-amber:hover{
  background:#d97706;
}
.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.form-label {
  font-weight: 600;
  color: #374151;
  font-size: 0.95rem;
}
.form-input, .form-select, .form-textarea {
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 0.95rem;
  transition: all 0.2s ease;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
  outline: none;
  border-color: var(--amber);
  box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}
</style>
</head>

<body>

<div class="min-h-screen">

    {{-- Sidebar --}}
    @include('components.sidebar')

    <div class="ml-60 p-8">

        <div class="max-w-2xl">
            <h1 class="text-3xl font-semibold mb-2" style="font-family:'Merriweather Sans',Inter;">
                Edit Produk
            </h1>
            <p class="text-gray-600 mb-8">Perbarui informasi produk Anda di bawah ini</p>

            {{-- ERROR ALERT --}}
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- SUCCESS ALERT --}}
            @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk *</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        value="{{ old('name', $product->name) }}"
                        placeholder="Contoh: iPhone 15 Pro Max"
                        required
                        class="form-input"
                    >
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="form-group">
                    <label for="harga" class="form-label">Harga (Rp) *</label>
                    <input 
                        type="number" 
                        id="harga"
                        name="harga" 
                        value="{{ old('harga', $product->harga) }}"
                        placeholder="Contoh: 15000000"
                        step="1000"
                        required
                        class="form-input"
                    >
                    @error('harga')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori *</label>
                    <select 
                        id="category_id"
                        name="category_id" 
                        required
                        class="form-select"
                    >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="form-group">
                    <label for="kondisi" class="form-label">Kondisi *</label>
                    <select 
                        id="kondisi"
                        name="kondisi" 
                        required
                        class="form-select"
                    >
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baru" {{ old('kondisi', $product->kondisi) == 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Bekas" {{ old('kondisi', $product->kondisi) == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                    </select>
                    @error('kondisi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Stok -->
                <div class="form-group">
                    <label for="stock" class="form-label">Stok Produk *</label>
                    <input 
                        type="number" 
                        id="stock"
                        name="stock" 
                        value="{{ old('stock', $product->stock) }}"
                        placeholder="Contoh: 50"
                        min="0"
                        required
                        class="form-input"
                    >
                    @error('stock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="4"
                        placeholder="Jelaskan detail produk Anda..."
                        class="form-textarea"
                    >{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Gambar Produk -->
                <div class="form-group">
                    <label for="image_link" class="form-label">Gambar Produk</label>
                    
                    @if($product->image_link)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $product->image_link) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded-lg border">
                    </div>
                    @endif
                    
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                        <input 
                            type="file" 
                            id="image_link"
                            name="image_link" 
                            accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            onchange="previewImage(event)"
                        >
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-8l-3.172-3.172a4 4 0 00-5.656 0L28 20m0 0l-3.172-3.172a4 4 0 00-5.656 0L8 28m20-8h.01M24 8a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-700">Klik untuk upload gambar baru atau drag & drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB (opsional)</p>
                            <p id="filename" class="mt-2 text-xs text-blue-600 font-semibold"></p>
                        </div>
                    </div>
                    @error('image_link')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-4 pt-6">
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 rounded-lg font-semibold shadow-sm button-amber transition hover:shadow-md"
                    >
                        ✓ Simpan Perubahan
                    </button>
                    <a 
                        href="{{ route('seller.products') }}"
                        class="flex-1 px-6 py-3 rounded-lg font-semibold shadow-sm bg-gray-200 text-gray-800 transition hover:bg-gray-300 text-center"
                    >
                        ← Batal
                    </a>
                </div>

            </form>
        </div>

    </div>

</div>

<script>
window.addEventListener('load',()=>{ if(window.lucide) lucide.replace() })

function previewImage(event) {
    const file = event.target.files[0];
    const filename = document.getElementById('filename');
    
    if (file) {
        filename.textContent = '✓ ' + file.name;
    }
}
</script>

</body>
</html>
