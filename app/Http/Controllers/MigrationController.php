<?php

namespace App\Http\Controllers;

use App\Converters\EsaConverter;
use App\Converters\HatenaConverter;
use App\Entities\Esa\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MigrationController
 * @package App\Http\Controllers
 */
class MigrationController extends Controller
{
    /**
     * @param Request $request
     * @param EsaConverter $esaConverter
     * @param HatenaConverter $hatenaConverter
     */
    public function __invoke(Request $request, EsaConverter $esaConverter, HatenaConverter $hatenaConverter)
    {
        if ($request->input('user.screen_name') !== env('ESA_USER')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $esa = Post::createFrom($request->input('post'));
        $post = $esaConverter->convertFromEsa($esa);
        $hatena = $hatenaConverter->convertToHatena($post);
        logger()->info(var_export($hatena, true));
    }
}
