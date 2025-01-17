<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /*
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $nonce = Str::random(32);
        $request->attributes->set('csp-nonce', $nonce);

        $response = $next($request);

        $cspHeader = "default-src 'self'; " .
            "script-src 'self' 'nonce-{$nonce}' https://cdnjs.cloudflare.com; " .
            "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com; " .
            "img-src 'self' data: blob:; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "connect-src 'self'; " .
            "media-src 'self'; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self'; " .
            "frame-ancestors 'none'; " .
            "upgrade-insecure-requests;";

        $response->headers->set('Content-Security-Policy', $cspHeader);

        return $response;
    }
}
