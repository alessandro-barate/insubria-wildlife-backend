<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ContentSecurityPolicy
{
    /*
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        Log::stack(['single'])->emergency('CSP Middleware START');

        // $nonce = Str::random(32);
        // $request->attributes->set('csp-nonce', $nonce);
        
        $response = $next($request);

        try {
            Log::stack(['single'])->emergency('Setting CSP headers');
            
            $cspHeader = "default-src 'self'; " .
                "script-src 'self' 'unsafe-eval' 'unsafe-inline' https://cdnjs.cloudflare.com; " .
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
                "img-src 'self' data: blob:; " .
                "font-src 'self' https://fonts.gstatic.com; " .
                "connect-src 'self' ws: wss:; " .
                "media-src 'self'; " .
                "object-src 'none'; " .
                "base-uri 'self'; " .
                "form-action 'self'; " .
                "frame-ancestors 'none'";

            $response->headers->set('Content-Security-Policy', $cspHeader);
            Log::stack(['single'])->emergency('CSP header set: ' . $cspHeader);

        } catch (\Exception $e) {
            Log::stack(['single'])->emergency('Error in CSP middleware: ' . $e->getMessage());
        }

        Log::stack(['single'])->emergency('CSP Middleware END');

        return $response;
    }
}
