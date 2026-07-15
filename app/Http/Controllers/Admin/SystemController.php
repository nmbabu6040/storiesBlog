<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Setting;

class SystemController extends Controller
{
    public function clearCache()
    {
        Artisan::call('cache:clear');

        activityLog(
            'System',
            'Cache Clear',
            auth()->user()->name . ' cleared application cache.'
        );

        return back()->with(
            'success',
            'Application cache cleared successfully.'
        );
    }

    public function clearConfig()
    {
        Artisan::call('config:clear');

        activityLog(
            'System',
            'Config Clear',
            auth()->user()->name . ' cleared config cache.'
        );

        return back()->with(
            'success',
            'Config cache cleared successfully.'
        );
    }

    public function clearRoute()
    {
        Artisan::call('route:clear');

        activityLog(
            'System',
            'Route Clear',
            auth()->user()->name . ' cleared route cache.'
        );

        return back()->with(
            'success',
            'Route cache cleared successfully.'
        );
    }

    public function clearView()
    {
        Artisan::call('view:clear');

        activityLog(
            'System',
            'View Clear',
            auth()->user()->name . ' cleared compiled views.'
        );

        return back()->with(
            'success',
            'Compiled views cleared successfully.'
        );
    }

    public function optimize()
    {
        $userName = auth()->user()?->name ?? 'System';

        Artisan::call('optimize');

        activityLog(
            'System',
            'Optimize',
            $userName . ' optimized the application.'
        );

        return back()->with(
            'success',
            'Application optimized successfully.'
        );
    }

    public function optimizeClear()
    {
        $userName = auth()->user()?->name ?? 'System';

        Artisan::call('optimize:clear');

        activityLog(
            'System',
            'Optimize Clear',
            $userName . ' cleared optimization cache.'
        );

        return back()->with(
            'success',
            'Optimization cache cleared successfully.'
        );
    }

    public function maintenanceOn()
    {
        $setting = Setting::first();

        // dd($setting);
        $setting->update([
            'maintenance_mode' => true
        ]);

        activityLog(
            'System',
            'Maintenance ON',
            auth()->user()->name . ' enabled maintenance mode.'
        );

        return back()->with(
            'success',
            'Maintenance Mode Enabled.'
        );

        // $setting = Setting::first();

        // $setting->maintenance_mode = 1;

        // $setting->save();

        // dd($setting->fresh()->maintenance_mode);

        // return back()->with(
        //     'success',
        //     'Maintenance Mode Enabled.'
        // );
    }

    public function maintenanceOff()
    {
        $setting = Setting::first();


        $setting->update([
            'maintenance_mode' => false
        ]);

        activityLog(
            'System',
            'Maintenance OFF',
            auth()->user()->name . ' disabled maintenance mode.'
        );

        return back()->with(
            'success',
            'Maintenance Mode Disabled.'
        );
    }
}
