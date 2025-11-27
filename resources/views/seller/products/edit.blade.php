<div class="flex">

    @include('components.sidebar')

    <div class="flex-1 p-6">

        <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

        <form action="{{ route('seller.products.update', $product['id']) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ $product['name'] }}" class="w-full border p-2">
            </div>

            <div>
                <label class="block mb-1">Harga</label>
                <input type="number" name="harga" value="{{ $product['harga'] }}" class="w-full border p-2">
            </div>

            <div>
                <label class="block mb-1">Kategori</label>
                <select name="category_id" class="w-full border p-2">
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}"
                            {{ ($product['category']['name'] ?? '') == $c->name ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </form>

    </div>

</div>
