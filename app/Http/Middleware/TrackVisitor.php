<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track public GET requests (ignore admin, api, or static assets)
        if ($request->isMethod('GET') && !$request->is('admin*') && !$request->is('api*') && !$request->ajax()) {
            try {
                $userAgent = $request->header('User-Agent');
                $deviceType = 'desktop';

                if (preg_match('/(android|bb\d+|meego).+mobile|avail|blackberry|emulator|iphone|ipod|sm-b|opera mini|mobile/i', $userAgent)) {
                    $deviceType = 'mobile';
                } elseif (preg_match('/ipad|tablet|playbook|silk/i', $userAgent)) {
                    $deviceType = 'tablet';
                }

                VisitorLog::create([
                    'ip_address' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'referrer' => $request->header('referer'),
                    'device_type' => $deviceType,
                    'user_agent' => substr($userAgent, 0, 250),
                ]);
            } catch (\Throwable $e) {
                // Silently ignore tracking errors to avoid blocking user response
            }
        }

        return $response;
    }
}
