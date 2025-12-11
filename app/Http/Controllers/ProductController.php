<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RatingThankYou;
use Barryvdh\DomPDF\Facade\Pdf;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Public catalogue: show ALL products, optionally filtered
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
                'id' => $p->id,
                'name' => $p->name,
                'image_link' => $p->image_link,
                'kondisi' => $p->kondisi,
                'harga' => $p->harga,
                'link' => route('product.detail', $p->id),
                'category' => ['name' => $p->category?->name],
            ];
        });

        $categories = Category::all();

        return view('catalogue', [
            'products' => $products,
            'categories' => $categories,
            'search' => $request->all(),
        ]);
    }


    public function sellerIndex()
    {
        // Get the logged-in seller ID from the session
        $sellerId = session('seller_id');

        // Fetch only products belonging to this seller
        $products = Product::where('seller_id', $sellerId)
            ->with('category')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'harga' => 'Rp ' . number_format($p->harga, 0, ',', '.'),
                    'kondisi' => $p->kondisi,
                    'image_link' => $p->image_link,
                    'category' => ['name' => $p->category?->name],
                ];
            })
            ->toArray();

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
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'kondisi' => 'required|in:Baru,Bekas',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        // Handle file upload
        if ($request->hasFile('image_link')) {
            $imagePath = $request->file('image_link')->store('products', 'public');
        }

        $sellerId = session('seller_id');

        Product::create([
            'name' => $request->name,
            'harga' => $request->harga,
            'category_id' => $request->category_id,
            'kondisi' => $request->kondisi,
            'stock' => $request->stock,
            'description' => $request->description,
            'image_link' => $imagePath,
            'seller_id' => $sellerId, // TODO: Get from authenticated seller
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

        $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'kondisi' => 'required|in:Baru,Bekas',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'harga' => $request->harga,
            'category_id' => $request->category_id,
            'kondisi' => $request->kondisi,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // Handle file upload (optional - jika user upload gambar baru)
        if ($request->hasFile('image_link')) {
            // Delete old image if exists
            if ($product->image_link && Storage::disk('public')->exists($product->image_link)) {
                Storage::disk('public')->delete($product->image_link);
            }
            
            $data['image_link'] = $request->file('image_link')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function sellerDelete($id)
    {
        Product::findOrFail($id)->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Seller dashboard with product and rating summary
     */
    public function sellerDashboard()
    {
        // For now, using seller_id = 1; TODO: replace with authenticated seller
        $sellerId = session('seller_id');
        
        $products = Product::where('seller_id', $sellerId)->with('ratings')->get();
        $totalProducts = $products->count();
        $totalRatings = $products->sum(function($p) { return $p->ratings->count(); });
        $averageRating = $products->isEmpty() ? 0 : $products->avg('average_rating');
        
        // Top products by rating count
        $topProducts = $products->sortByDesc(function($p) { 
            return $p->ratings->count(); 
        })->take(5)->values();
        
        return view('seller.dashboard', compact(
            'totalProducts',
            'totalRatings',
            'averageRating',
            'topProducts',
            'products'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show product detail with ratings and comments
     */
    public function showDetail($id)
    {
        $product = Product::with(['category', 'seller', 'ratings' => function($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('productdetail', compact('product'));
    }

    /**
     * Store rating and comment for product
     */
    public function storeRating(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if email already has a rating for this product
        $existingRating = $product->ratings()
            ->where('email', $request->email)
            ->exists();

        if ($existingRating) {
            return redirect()->route('product.detail', $id)
                           ->with('error', 'Email ini sudah pernah memberikan rating untuk produk ini.');
        }

        // Create rating
        $rating = $product->ratings()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province' => $request->province,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Send thank you email
        try {
            Mail::to($request->email)->send(new RatingThankYou($product, $rating));
        } catch (\Exception $e) {
            // Log error but don't fail the request
        }

        return redirect()->route('product.detail', $id)
                       ->with('success', 'Terima kasih! Rating dan komentar Anda telah disimpan.');
    }

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

    /**
     * Export seller dashboard to PDF
     */
    public function exportSellerDashboardPDF()
    {
        $sellerId = session('seller_id'); // TODO: use authenticated seller
        
        $products = Product::where('seller_id', $sellerId)->with('ratings')->get();
        $totalProducts = $products->count();
        $totalRatings = $products->sum(function($p) { return $p->ratings->count(); });
        $averageRating = $products->isEmpty() ? 0 : $products->avg('average_rating');
        
        $topProducts = $products->sortByDesc(function($p) { 
            return $p->ratings->count(); 
        })->take(5)->values();
        
        $data = [
            'totalProducts' => $totalProducts,
            'totalRatings' => $totalRatings,
            'averageRating' => $averageRating,
            'topProducts' => $topProducts,
            'products' => $products,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.seller-dashboard-pdf', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('seller-dashboard-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 1: Daftar Stok Produk Diurutkan Nama (dengan rating, kategori, harga)
     */
    public function exportSellerStockReport()
    {
        $sellerId = session('seller_id'); // TODO: use authenticated seller
        
        $products = Product::where('seller_id', $sellerId)
            ->with(['category', 'ratings'])
            ->get();
        
        $data = [
            'products' => $products,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.seller-stock-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-stok-produk-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 2: Daftar Produk Diurutkan Rating Menurun (dengan stok, kategori, harga)
     */
    public function exportSellerRatingReport()
    {
        $sellerId = session('seller_id'); // TODO: use authenticated seller
        
        $products = Product::where('seller_id', $sellerId)
            ->with(['category', 'ratings'])
            ->get();
        
        $data = [
            'products' => $products,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.seller-rating-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-produk-rating-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 3: Daftar Stok Barang Perlu Pemesanan (Stok < 2)
     */
    public function exportSellerLowStockReport()
    {
        $sellerId = session('seller_id'); // TODO: use authenticated seller
        
        $lowStockProducts = Product::where('seller_id', $sellerId)
            ->where('stock', '<', 2)
            ->with(['category', 'ratings'])
            ->get();
        
        $data = [
            'lowStockProducts' => $lowStockProducts,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.seller-low-stock-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-stok-perlu-pesan-' . now()->format('Y-m-d-His') . '.pdf');
    }
    
}
