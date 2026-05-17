<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Visit', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user' => $request->user()?->id ?? 'guest',
        ]);

        return $next($request);
    }
}
