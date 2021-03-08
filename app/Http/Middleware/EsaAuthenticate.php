<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class EsaAuthenticate
 *
 * @see https://docs.esa.io/posts/37#X-Esa-Signature
 * @package App\Http\Middleware
 */
class EsaAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $body = $request->json();
        logger()->info(var_export($body, true));

        return $next($request);
    }
}
