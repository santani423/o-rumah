<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitors;
use Jenssegers\Agent\Agent; // Library untuk mendeteksi device dan browser
// composer clear-cache
// composer require jenssegers/agent --prefer-source
class CaptureVisitorData
{
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        Visitors::create([
            'ip_address' => $request->ip(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'visited_at' => now(),
            'page_visited' => $request->path()
        ]);

        return $next($request);
    }
}
