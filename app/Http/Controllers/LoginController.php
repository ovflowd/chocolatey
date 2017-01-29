<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\Ban;
use App\Models\ChocolateyId;
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
    public function login(Request $request)
    {
        return $request->user('api') ? response()->json($request->user(), 200)
            : response()->json(['message' => 'login.invalid_password', 'captcha' => false], 401);
    }
    
    /**
     * Destroys the User Session
     *
     * @return Response
     */
    public function logout()
    {
        Session::erase('ChocolateyWEB');

        return response(null, 200);
    }

    /**
     * Register an User on the Database
     * and do the Login of the User
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        if (strpos($request->json()->get('email'), '@') == false)
            return response()->json(['error' => 'registration_email'], 409);

        if (ChocolateyId::query()->where('mail', $request->json()->get('email'))->count() > 0)
            return response()->json(['error' => 'registration_email_in_use'], 409);

        $userData = (new AccountController)->createUser($request, $request->json()->all(), true);

        return response()->json($userData, 200);
    }
}
