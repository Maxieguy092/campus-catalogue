<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SellerAuthController extends Controller
{
    public function registerView()
    {
        // Load file JSON
        $path = public_path('json/indonesia_full.json');
        $dataIndonesia = json_decode(file_get_contents($path), true);

        return view('seller.register', [
            'dataIndonesia' => $dataIndonesia
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'store_name'        => 'required',
            'store_description' => 'required',
            'pic_name'          => 'required',
            'pic_phone'         => 'required',
            'pic_email'         => 'required|email|unique:sellers,pic_email',
            'pic_street'        => 'required',
            'pic_rt'            => 'required',
            'pic_rw'            => 'required',
            'pic_village'       => 'required',
            'pic_kecamatan'     => 'required',
            'pic_city'          => 'required',
            'pic_province'      => 'required',
            'pic_ktp_number'    => 'required',
            'pic_photo_path'    => 'required|image',
            'pic_ktp_file_path' => 'required|mimes:jpg,png,pdf',
            'password'          => 'required|min:6',
        ]);

        // Upload files
        $photoPath = $request->file('pic_photo_path')->store('sellers/photos', 'public');
        $ktpPath   = $request->file('pic_ktp_file_path')->store('sellers/ktp', 'public');

        Seller::create([
            'store_name'        => $request->store_name,
            'store_description' => $request->store_description,

            'pic_name'          => $request->pic_name,
            'pic_phone'         => $request->pic_phone,
            'pic_email'         => $request->pic_email,

            'pic_street'        => $request->pic_street,
            'pic_rt'            => $request->pic_rt,
            'pic_rw'            => $request->pic_rw,
            'pic_village'       => $request->pic_village,
            'pic_kecamatan'     => $request->pic_kecamatan,
            'pic_city'          => $request->pic_city,
            'pic_province'      => $request->pic_province,

            'pic_ktp_number'    => $request->pic_ktp_number,
            'pic_photo_path'    => $photoPath,
            'pic_ktp_file_path' => $ktpPath,

            'password' => Hash::make($request->password),
            'status'   => 'pending',
        ]);

        return redirect()->back()->with('success', 'Registration successful! Waiting for admin verification.');
    }

    public function loginView()
    {
        return view('seller.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pic_email' => 'required|email',
            'password'  => 'required'
        ]);

        $seller = Seller::where('pic_email', $request->pic_email)->first();

        if (!$seller || !Hash::check($request->password, $seller->password)) {
            return back()->withErrors(['pic_email' => 'Invalid email or password.']);
        }

        // Store seller session
        session(['seller_id' => $seller->id]);

        return redirect()->route('seller.products');
    }
}
