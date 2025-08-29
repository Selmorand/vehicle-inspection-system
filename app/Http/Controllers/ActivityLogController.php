<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        // Only admin and super admin can access
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect('/login');
            }
            
            $user = auth()->user();
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = ActivityLog::query();
        
        // Filter by date range
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->subMonth());
                    break;
            }
        }
        
        // Filter by user
        if ($request->has('user_filter') && $request->user_filter) {
            $query->where('user_email', $request->user_filter);
        }
        
        // Filter by action
        if ($request->has('action_filter') && $request->action_filter) {
            $query->where('action', $request->action_filter);
        }
        
        // Filter by visitors only (non-logged in)
        if ($request->has('visitors_only') && $request->visitors_only) {
            $query->whereNull('user_id');
        }
        
        // Get unique values for filters
        $users = ActivityLog::select('user_email')
            ->whereNotNull('user_email')
            ->distinct()
            ->pluck('user_email');
            
        $actions = ActivityLog::select('action')
            ->distinct()
            ->pluck('action');
        
        // Get logs with pagination
        $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        
        // Get statistics
        $stats = [
            'total_today' => ActivityLog::whereDate('created_at', Carbon::today())->count(),
            'unique_visitors_today' => ActivityLog::whereDate('created_at', Carbon::today())
                ->whereNull('user_id')
                ->distinct('ip_address')
                ->count('ip_address'),
            'failed_logins_today' => ActivityLog::whereDate('created_at', Carbon::today())
                ->where('action', 'login_attempt')
                ->count(),
            'active_users_today' => ActivityLog::whereDate('created_at', Carbon::today())
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),
        ];
        
        return view('admin.activity-logs', compact('logs', 'users', 'actions', 'stats'));
    }
    
    public function show($id)
    {
        $log = ActivityLog::findOrFail($id);
        
        // Only admin can view details
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        
        return view('admin.activity-log-detail', compact('log'));
    }
    
    public function export(Request $request)
    {
        // Only super admin can export
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only super admin can export logs');
        }
        
        $logs = ActivityLog::query();
        
        if ($request->has('from_date')) {
            $logs->where('created_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date')) {
            $logs->where('created_at', '<=', $request->to_date);
        }
        
        $logs = $logs->get();
        
        // Generate CSV
        $csv = "Date,Time,User,Email,Role,Action,Description,IP Address,Browser,Device\n";
        
        foreach ($logs as $log) {
            $csv .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $log->created_at->format('Y-m-d'),
                $log->created_at->format('H:i:s'),
                $log->user_name ?? 'Anonymous',
                $log->user_email ?? 'N/A',
                $log->user_role ?? 'visitor',
                $log->action,
                str_replace(',', ';', $log->description),
                $log->ip_address,
                $log->browser,
                $log->device
            );
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="activity-logs-' . date('Y-m-d') . '.csv"');
    }
}