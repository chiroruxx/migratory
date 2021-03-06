<?php

namespace App\Http\Controllers;

use App\Converters\EsaConverter;
use App\Converters\HatenaConverter;
use App\Entities\Esa\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class MigrationController
 * @package App\Http\Controllers
 */
class MigrationController extends Controller
{
    public function __invoke(Request $request, EsaConverter $esaConverter, HatenaConverter $hatenaConverter): Response
    {
        if ($request->input('user.screen_name') !== env('ESA_USER')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $esa = Post::createFrom($request->input('post'));
        $post = $esaConverter->convertFromEsa($esa);
        $hatena = $hatenaConverter->convertToHatena($post)->toXml();

        $hatenaID = env('HATENA_NAME');
        $blogID = env('HATENA_URL');
        $response = Http::withBasicAuth($hatenaID, env('HATENA_PASSWORD'))
            ->withBody($hatena, 'application/atomsvc+xml')
            ->post("https://blog.hatena.ne.jp/{$hatenaID}/{$blogID}/atom/entry");

        logger()->info($response->status());
        logger()->info($response->body());

        return response()->noContent();
    }
}
