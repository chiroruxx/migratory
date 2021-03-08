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
        $body = $request->getContent();
        $hash = hash_hmac('sha256', $body, env('ESA_SECRET'));
        logger()->info('calced', ['hash' => $hash]);
        logger()->info('header', ['hash' => $request->header(' X-Esa-Signature')]);

        return $next($request);
    }
}
