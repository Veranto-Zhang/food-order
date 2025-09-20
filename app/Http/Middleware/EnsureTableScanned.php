<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTableScanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('table_number')) {
            return redirect()->route('scan.notice');
        }

        // Expire after 2 hours
        $scannedAt = session('table_scanned_at');
        if ($scannedAt && Carbon::parse($scannedAt)->addHours(1)->isPast()) {
            session()->forget(['table_number', 'table_scanned_at']);
            return redirect()->route('scan.notice')
                ->with('error', 'Your session expired. Please scan QR again.');
        }

        return $next($request);
    }
}
