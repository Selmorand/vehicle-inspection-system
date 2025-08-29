<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheClearController extends Controller
{
    /**
     * Clear cache via web request with secret key
     * Usage: /clear-cache?key=your_secret_key
     */
    public function clearCache(Request $request)
    {
        // Security: Check for secret key
        $secretKey = env('CACHE_CLEAR_KEY', 'default_secret_2025');
        
        if ($request->get('key') !== $secretKey) {
            abort(403, 'Unauthorized');
        }
        
        // Clear all caches
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        
        // Rebuild caches
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('optimize');
        
        return response()->json([
            'status' => 'success',
            'message' => 'All caches cleared and rebuilt successfully',
            'timestamp' => now()->toDateTimeString(),
            'cleared' => [
                'application_cache' => 'cleared',
                'config_cache' => 'cleared and rebuilt',
                'route_cache' => 'cleared and rebuilt',
                'view_cache' => 'cleared and rebuilt',
                'compiled_classes' => 'cleared and optimized'
            ]
        ]);
    }
    
    /**
     * Admin-only cache clear from dashboard
     */
    public function adminClearCache()
    {
        // Only super admin can clear cache from web
        if (!auth()->check() || !(auth()->user()->is_super_admin ?? false)) {
            abort(403, 'Only super admin can clear cache');
        }
        
        // Clear all caches
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        
        // Rebuild caches
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        
        return redirect()->back()->with('success', 'All caches cleared successfully!');
    }
}