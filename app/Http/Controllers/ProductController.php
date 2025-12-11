<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Seller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $products = $query->get()->map(function ($p) {
            return [
                'name' => $p->name,
                'image_link' => $p->image_link,
                'kondisi' => $p->kondisi,
                'harga' => $p->harga,
                'link' => '/product/' . $p->id,
                'category' => ['name' => $p->category?->name],
            ];
        })->toArray();

        $categories = Category::all();

        return view('catalogue', [
            'products' => $products,
            'categories' => $categories,
            'search' => $request->all(),
        ]);
    }

    public function sellerIndex()
    {
        $products = Product::with('category')->get();

        return view('seller.products.index', compact('products'));
    }

    public function sellerCreate()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function sellerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'kondisi' => 'required|in:Baru,Bekas',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_link' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_link')) {
            $imagePath = $request->file('image_link')->store('product_images', 'public');
        }

        Product::create([
            'seller_id' => 1,
            'name' => $request->name,
            'harga' => $request->harga,
            'category_id' => $request->category_id,
            'kondisi' => $request->kondisi,
            'stock' => $request->stock,
            'description' => $request->description,
            'image_link' => $imagePath,
        ]);

        return redirect()->route('seller.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function sellerEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function sellerUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //image not url
        $request->validate([
            'name' => 'required',
            'harga' => 'required|string',
            'category_id' => 'required',
            'kondisi' => 'required',
            'image_link' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product->update($request->all());

        return redirect()->route('seller.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function sellerDelete($id)
    {
        Product::findOrFail($id)->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function sellerDashboard()
    {
        $sellerId = 1; // sementara karena belum ada auth

        $products = Product::where('seller_id', $sellerId)->get();

        $totalProducts = $products->count();

        $totalRatings = Rating::whereIn('product_id', $products->pluck('id'))->count();

        $averageRating = Rating::whereIn('product_id', $products->pluck('id'))
            ->avg('rating') ?? 0;

        // === Fix: Top products by rating ===
        $topProducts = Product::where('seller_id', $sellerId)
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts',
            'totalRatings',
            'averageRating',
            'products',
            'topProducts'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
    
}
