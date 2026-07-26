<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        $userId = session('admin_user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }

        return redirect()->route('admin.login')->with('error', 'Please sign in to access the staff panel.');
    }
}
