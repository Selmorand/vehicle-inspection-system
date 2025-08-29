<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProtectSuperAdmin
{
    /**
     * Protect super admin account from modifications
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if trying to modify super admin
        if ($request->route('user')) {
            $user = $request->route('user');
            
            // If target is super admin and current user is not super admin
            if ($user->email === 'superadmin@system.local') {
                if (!auth()->user()->isSuperAdmin()) {
                    abort(403, 'Cannot modify super admin account');
                }
            }
        }

        // Check if trying to delete super admin
        if ($request->isMethod('delete')) {
            $userId = $request->route('user') ? $request->route('user')->id : $request->route('id');
            if ($userId) {
                $user = \App\Models\User::find($userId);
                if ($user && $user->email === 'superadmin@system.local') {
                    abort(403, 'Cannot delete super admin account');
                }
            }
        }

        return $next($request);
    }
}