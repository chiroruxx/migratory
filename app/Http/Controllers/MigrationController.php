<?php

namespace App\Http\Controllers;

use App\Converters\EsaConverter;
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
     * @param EsaConverter $converter
     */
    public function __invoke(Request $request, EsaConverter $converter)
    {
        if ($request->input('user.screen_name') !== env('ESA_USER')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $esa = Post::createFrom($request->input('post'));
        $post = $converter->convertFromEsa($esa);
        logger()->info(var_export($post, true));
    }
}
