<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\ChocolateyId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if ($request->user()):
            if ($request->user()->isBanned)
                $this->sendBanMessage($request);

            $request->user()->update(['last_login' => time(), 'ip_current' => $request->ip()]);

            return response()->json($request->user());
        endif;

        return response()->json(['message' => 'login.invalid_password', 'captcha' => false], 401);
    }

    /**
     * Return the Ban Message
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function sendBanMessage(Request $request): JsonResponse
    {
        return response()->json(['message' => 'login.user_banned',
            'expiryTime' => $request->user()->banDetails->ban_expire,
            'reason' => $request->user()->banDetails->ban_reason], 401);
    }

    /**
     * Destroys the User Session
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Session::erase(Config::get('chocolatey.security.session'));

        return response()->json(null);
    }

    /**
     * Register an User on the Database
     * and do the Login of the User
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        if (strpos($request->json()->get('email'), '@') == false)
            return response()->json(['error' => 'registration_email'], 409);

        if (ChocolateyId::query()->where('mail', $request->json()->get('email'))->count() > 0)
            return response()->json(['error' => 'registration_email_in_use'], 409);

        $userData = (new AccountController)->createUser($request, $request->json()->all(), true);

        $userData->update(['last_login' => time(), 'ip_register' => $request->ip(), 'ip_current' => $request->ip()]);

        if (Config::get('chocolatey.vote.enabled'))
            Session::set('VotePolicy', true);

        return response()->json($userData);
    }
}
