<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        var_dump($request->all());
    }
}