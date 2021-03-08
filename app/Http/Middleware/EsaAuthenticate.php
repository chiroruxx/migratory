<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $calculated = 'sha256=' . hash_hmac('sha256', $request->getContent(), env('ESA_SECRET', ''));
        $given = $request->header('x-esa-signature');

        if ($calculated !== $given) {
            logger()->info(
                'Esa auth failed.',
                [
                    'calculated' => $calculated,
                    'given' => $given,
                ]
            );

            throw new HttpException(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
