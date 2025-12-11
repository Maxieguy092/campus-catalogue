<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Mail\SellerStatusChanged;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
<<<<<<< HEAD
=======
use Barryvdh\DomPDF\Facade\Pdf;
>>>>>>> master

class PlatformController extends Controller
{
    // Dashboard / list penjual
    public function index(Request $request)
    {
        $query = Seller::query();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('store_name', 'like', "%{$q}%")
                    ->orWhere('pic_email', 'like', "%{$q}%")
                    ->orWhere('pic_name', 'like', "%{$q}%");
            });
        }

        $sellers = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return view('admin.dashboard', compact('sellers'));
    }

    // Approve seller → status ACTIVE
    public function approve($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->status = 'accepted';
        $seller->save();

        // email: pastikan alamat email PIC tersedia sebelum mengirim
        if (!empty($seller->pic_email) && filter_var($seller->pic_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($seller->pic_email)->send(new SellerStatusChanged($seller, 'accepted'));
        } else {
            Log::warning('Cannot send seller status email: invalid or empty pic_email', ['seller_id' => $seller->id, 'pic_email' => $seller->pic_email]);
        }
        return redirect()->back()
            ->with('success', "Penjual \"{$seller->store_name}\" berhasil di-approve.");
    }

    // Reject seller → status REJECTED
    public function reject(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $reason = $request->input('reason', null);

        $seller->status = 'rejected';
        $seller->save();

        // email: pastikan alamat email PIC tersedia sebelum mengirim
        if (!empty($seller->pic_email) && filter_var($seller->pic_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($seller->pic_email)->send(new SellerStatusChanged($seller, 'rejected', $reason));
        } else {
            Log::warning('Cannot send seller status email: invalid or empty pic_email', ['seller_id' => $seller->id, 'pic_email' => $seller->pic_email]);
        }
        return redirect()->back()
            ->with('success', "Penjual \"{$seller->store_name}\" berhasil di-reject.");
    }

    public function dashboard(Request $request)
    {
        // Filter status (optional)
        $status = $request->get('status');

        $query = Seller::query();

        if ($status && in_array($status, ['pending', 'active', 'rejected'])) {
            $query->where('status', $status);
        }

        return view('platform.dashboard', [
            'totalSellers'    => Seller::count(),
            'activeSellers'   => Seller::where('status', 'accepted')->count(),
            'pendingSellers'  => Seller::where('status', 'pending')->count(),
            'latestSellers'   => $query->latest()->limit(10)->get(),
            'currentStatus'   => $status,
        ]);
    }

    public function detail($id)
    {
        $seller = Seller::findOrFail($id);
        return view('platform.show', compact('seller'));
    }

    public function categories()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('platform.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create(['name' => $request->name]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

<<<<<<< HEAD
=======
    /**
     * Export platform dashboard to PDF
     */
    public function exportPlatformDashboardPDF()
    {
        $data = [
            'totalSellers' => Seller::count(),
            'activeSellers' => Seller::where('status', 'accepted')->count(),
            'pendingSellers' => Seller::where('status', 'pending')->count(),
            'rejectedSellers' => Seller::where('status', 'rejected')->count(),
            'latestSellers' => Seller::latest()->limit(10)->get(),
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.platform-dashboard-pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('platform-dashboard-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 1: Daftar Akun Penjual Aktif dan Tidak Aktif
     */
    public function exportSellerListReport()
    {
        $sellers = Seller::all();
        
        $data = [
            'sellers' => $sellers,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.admin-seller-list-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-akun-penjual-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 2: Daftar Toko Berdasarkan Lokasi Provinsi
     */
    public function exportStoreByProvinceReport()
    {
        $sellers = Seller::with('products')->get();
        
        // Group by province
        $sellersByProvince = $sellers->groupBy('pic_province');
        
        $data = [
            'sellersByProvince' => $sellersByProvince,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.admin-store-by-province-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-toko-per-provinsi-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Laporan 3: Daftar Produk dan Rating (Diurutkan Rating Menurun)
     */
    public function exportProductRatingReport()
    {
        $products = \App\Models\Product::with(['seller', 'category', 'ratings'])->get();
        
        $data = [
            'products' => $products,
            'generatedAt' => now()->format('d M Y H:i'),
        ];
        
        $pdf = Pdf::loadView('reports.admin-product-rating-report', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('laporan-produk-rating-' . now()->format('Y-m-d-His') . '.pdf');
    }

>>>>>>> master
}
