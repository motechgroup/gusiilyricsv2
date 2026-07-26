<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            return redirect()->route('admin.songs.index')->with('error', 'Access restricted. Only Super Admins can access site settings, stats, and user management.');
        }

        return $next($request);
    }
}
