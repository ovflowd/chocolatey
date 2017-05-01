<?php

namespace App\Http\Controllers;

use App\Facades\User as UserFacade;
use App\Models\ChocolateyId;
use App\Models\User;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class LoginController.
 */
class LoginController extends BaseController
{
    /**
     * Handles the Response of the Login Attempt.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (UserFacade::loginUser($request) !== null) {
            if (UserFacade::getUser()->isBanned) {
                return $this->sendBanMessage($request);
            }

            return response()->json(UserFacade::updateSession(['last_login' => time(), 'ip_current' => $request->ip()]));
        }

        //return response()->json(['message' => 'login.staff_login_not_allowed', 'captcha' => false], 401); // Example for Non Allowance of Staffs
        return response()->json(['message' => 'login.invalid_password', 'captcha' => false], 401);
    }

    /**
     * Return the Ban Message.
     *
     * @return JsonResponse
     */
    protected function sendBanMessage(): JsonResponse
    {
        return response()->json(['message' => 'login.user_banned',
            'expiryTime'                   => UserFacade::getUser()->banDetails->ban_expire,
            'reason'                       => UserFacade::getUser()->banDetails->ban_reason, ], 401);
    }

    /**
     * Destroys the User Session.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        UserFacade::eraseSession();

        return response()->json(null);
    }

    /**
     * Register an User on the Database
     * and do the Login of the User.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        if (ChocolateyId::where('mail', $request->json()->get('email'))->count() > 0) {
            return response()->json(['error' => 'registration_email_in_use'], 409);
        }

        $dateOfBirth = strtotime("{$request->json()->get('birthdate')['day']}/{$request->json()->get('birthdate')['month']}/{$request->json()->get('birthdate')['year']}");

        (new AccountController())->createUser($request, $request->json()->all(), true);

        (new ChocolateyId())->store($request->json()->get('email'), $request->json()->get('password'));

        UserFacade::updateSession(['last_login' => time(), 'ip_register' => $request->ip(), 'ip_current' => $request->ip(), 'account_day_of_birth' => $dateOfBirth]);

        return response()->json(UserFacade::getUser());
    }

    /**
     * Create or Login a Facebook User.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function facebook(Request $request): JsonResponse
    {
        $fbUser = $this->fbAuth($request);

        if (User::query()->where('real_name', $fbUser->getId())->count() > 0) {
            return response()->json(UserFacade::setSession(User::where('real_name', $fbUser->getId())->first()));
        }

        (new AccountController())->createUser($request, ['email' => $fbUser->getEmail()], true);

        UserFacade::updateSession(['last_login' => time(), 'ip_register' => $request->ip(), 'ip_current' => $request->ip(), 'real_name' => $fbUser->getId()]);

        return response()->json(UserFacade::getUser());
    }

    /**
     * Do Facebook Authentication.
     *
     * @param Request $request
     *
     * @return GraphUser
     */
    protected function fbAuth(Request $request): GraphUser
    {
        $facebook = new Facebook(['app_id' => Config::get('chocolatey.facebook.app.key'), 'app_secret' => Config::get('chocolatey.facebook.app.secret')]);

        $facebook->setDefaultAccessToken($request->json()->get('accessToken'));

        return $facebook->get('/me?fields=id,name,email')->getGraphUser();
    }
}
