<?php

namespace App\Http\Controllers;

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
        if ($request->input('user.name') !== env('ESA_USER')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        logger()->info(json_encode($request->input('user')));
        logger()->info(json_encode($request->input('user.name')));
        logger()->info(json_encode($request->input('user')['name']));
    }
}
