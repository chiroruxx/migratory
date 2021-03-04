<?php

namespace App\Http\Controllers;

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
     */
    public function __invoke(Request $request)
    {
        if ($request->input('user.screen_name') !== env('ESA_USER')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $post = Post::createFrom($request->input('post'));
        logger()->info(var_export($post, true));
    }
}
