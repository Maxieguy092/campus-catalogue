<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Mail\SellerStatusChanged;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

}
