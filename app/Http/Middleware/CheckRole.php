<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on user's actual role
        if ($user->isUser()) {
            return redirect()->route('reports.index')->with('error', 'Access denied. You can only view reports.');
        } elseif ($user->isInspector()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Inspectors cannot access admin functions.');
        }

        return redirect()->route('dashboard')->with('error', 'Access denied.');
    }
}
