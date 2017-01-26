<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\AzureId;
use App\Models\Ban;
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
        if ($request->json()->has('email') && $request->json()->has('password')):
            Session::set('azureWEB', User::query()->where('mail', $request->json()->get('email'))
                ->where('password', md5($request->json()->get('password')))->first());

            if (Session::get('azureWEB') == null)
                return null;

            if (Ban::query()->where('user_id', Session::get('azureWEB')->id)->count() > 0)
                return null;

            return Session::get('azureWEB');
        endif;

        return null;
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

    /**
     * Register an User on the Database
     * and do the Login of the User
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $email = $request->json()->get('email');
        $password = $request->json()->get('password');

        if (strpos($email, '@') == false)
            return response()->json(['error' => 'registration_email'], 409);

        if (AzureId::query()->where('mail', $email)->count() > 0)
            return response()->json(['error' => 'registration_email_in_use'], 409);

        (new User)->store($userName = $this->generateUserName($email), $password, $email)->save();

        $userData = User::where('username', $userName)->first();

        $userData->traits = ["NEW_USER", "USER"];

        (new AzureId)->store($userData->uniqueId, $email)->save();

        Session::set('azureWEB', $userData);

        return response()->json($userData, 200);
    }

    /**
     * Return Random Username
     *
     * @param string $email
     * @return mixed|string
     */
    protected function generateUserName($email)
    {
        $email = explode('@', $email);
        $email = $email[0];

        $username = '';
        $username .= $this->symbols(rand(0, 9));
        $username .= $this->symbols(rand(0, 9));

        $username .= (sizeof($email) > 10 ? substr($email, 0, 10) : $email);
        $username .= $this->symbols(rand(0, 9));
        $username .= $this->symbols(rand(0, 9));

        return User::query()->where('username', $username)->count() > 0
            ? $this->generateUserName($email) : $username;
    }

    /**
     * Random Symbols for Username
     *
     * @param int $rand
     * @return string
     */
    protected function symbols($rand = 1)
    {
        switch ($rand):
            case 1:
                return '!';
            case 2:
                return '@';
            case 3:
                return '#';
            case 4:
                return '_';
            case 5:
                return '-';
            case 6:
                return '=';
            case 7:
                return '.';
            case 8:
                return '<';
            case 9:
                return '>';
            default:
                return '*';
        endswitch;
    }
}
