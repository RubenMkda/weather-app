<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class OptionalAuthWithLimit
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next)
    {
        Auth::shouldUse('sanctum');

        if (!Auth::check()) {
            $key = $this->resolveRequestSignature($request);

            if ($this->limiter->tooManyAttempts($key, 5)) {
                return response()->json([
                    'message' => 'Demasiadas solicitudes. Intenta nuevamente más tarde.'
                ], Response::HTTP_TOO_MANY_REQUESTS);
            }

            $this->limiter->hit($key, 60);
        }

        return $next($request);
    }

    protected function resolveRequestSignature(Request $request)
    {
        return sha1($request->ip());
    }
}
