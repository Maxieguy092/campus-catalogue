<?php

namespace App\Http\Middleware;

use Closure;

class SellerAuth
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('seller_id')) {
            return redirect()->route('seller.login')->withErrors([
                'auth' => 'Silakan login terlebih dahulu.'
            ]);
        }

        return $next($request);
    }
}
