<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogActivity
{
    /**
     * Handle an incoming request and log the activity
     */
    public function handle(Request $request, Closure $next)
    {
        // Process the request
        $response = $next($request);
        
        // Don't log certain routes
        $excludedPaths = [
            'api/*',
            'storage/*',
            'css/*',
            'js/*',
            'images/*',
            'favicon.ico',
        ];
        
        foreach ($excludedPaths as $path) {
            if ($request->is($path)) {
                return $response;
            }
        }
        
        // Determine the action based on the route
        $action = $this->determineAction($request);
        $description = $this->generateDescription($request);
        
        // Log the activity
        try {
            ActivityLog::log($action, $description);
        } catch (\Exception $e) {
            // Silently fail to not break the application
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
        
        return $response;
    }
    
    private function determineAction(Request $request)
    {
        $method = $request->method();
        $path = $request->path();
        
        // Login/Logout actions
        if ($path === 'login' && $method === 'POST') {
            return auth()->check() ? 'login_success' : 'login_attempt';
        }
        if ($path === 'logout') {
            return 'logout';
        }
        
        // CRUD actions
        if ($method === 'POST') return 'create';
        if ($method === 'PUT' || $method === 'PATCH') return 'update';
        if ($method === 'DELETE') return 'delete';
        
        // View actions
        if (str_contains($path, 'report')) return 'view_report';
        if (str_contains($path, 'inspection')) return 'view_inspection';
        if (str_contains($path, 'admin')) return 'admin_access';
        
        return 'page_view';
    }
    
    private function generateDescription(Request $request)
    {
        $user = auth()->user();
        $userName = $user ? $user->name : 'Anonymous visitor';
        $path = $request->path();
        $method = $request->method();
        
        // Special descriptions for specific pages
        if ($path === '/') {
            return "$userName visited homepage";
        }
        
        if ($path === 'login') {
            if ($method === 'GET') {
                return "$userName visited login page";
            }
            if ($method === 'POST') {
                return auth()->check() 
                    ? "$userName logged in successfully" 
                    : "Failed login attempt from " . $request->ip();
            }
        }
        
        if (str_contains($path, 'dashboard')) {
            return "$userName accessed dashboard";
        }
        
        if (str_contains($path, 'report')) {
            $reportId = $request->route('id') ?? 'unknown';
            return "$userName accessed report #$reportId";
        }
        
        if (str_contains($path, 'inspection')) {
            $inspectionId = $request->route('id') ?? 'unknown';
            return "$userName accessed inspection #$inspectionId";
        }
        
        // Blocked access for non-logged in users
        if (!$user && !in_array($path, ['/', 'login', 'register'])) {
            return "Anonymous visitor blocked from accessing /$path";
        }
        
        return "$userName accessed /$path";
    }
}