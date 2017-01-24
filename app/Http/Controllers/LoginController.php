<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends BaseController
{
    /**
     * Does Login on the System
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        if ($request->user('api'))
            return response()->json($request->user(), 401);

        return response()->json(['message' => 'login.invalid_password', 'captcha' => false], 401);
    }
}
