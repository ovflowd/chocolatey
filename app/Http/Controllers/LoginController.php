<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\User;
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
     * Handles the Response of the Login Attempt
     *
     * @param Request $request
     * @return Response
     */
    public function attempt(Request $request)
    {
        return $request->user('api') ? response()->json($request->user(), 200)
            : response()->json(['message' => 'login.invalid_password', 'captcha' => false], 401);
    }

    /**
     * Does the Login on the System
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if ($request->json()->has('email') && $request->json()->has('password'))
            Session::set('azureWEB', User::where('mail', $request->json()->get('email'))
                ->where('password', md5($request->json()->get('password')))->first());

        return Session::get('azureWEB');
    }

    /**
     * Destroys the User Session
     *
     * @return Response
     */
    public function logout()
    {
        Session::erase('azureWEB');

        return response(null, 200);
    }
}
