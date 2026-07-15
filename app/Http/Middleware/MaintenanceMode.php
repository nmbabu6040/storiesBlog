<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::first();

        // dd($setting->maintenance_mode);
        if (!$setting || !filter_var($setting->maintenance_mode, FILTER_VALIDATE_BOOLEAN)) {
            return $next($request);
        }

        /*
        Admin Login থাকলে Allow
        */

        if (
            auth()->check() &&
            auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin'
            ])
        ) {
            return $next($request);
        }
        /*
        Admin Route Allow
        */

        if ($request->is('admin*')) {
            return $next($request);
        }

        return response()->view(
            'errors.503',
            [],
            503
        );
    }
}
