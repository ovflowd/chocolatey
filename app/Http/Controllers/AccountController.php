<?php

namespace App\Http\Controllers;

use App\Facades\Mail;
use App\Facades\User as UserFacade;
use App\Facades\Validation;
use App\Models\ChocolateyId;
use App\Models\User;
use App\Models\UserPreferences;
use App\Models\UserSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;
use Nubs\RandomNameGenerator\Alliteration;

/**
 * Class AccountController.
 */
class AccountController extends BaseController
{
    /**
     * Save User Look.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function saveLook(Request $request): JsonResponse
    {
        UserFacade::updateSession(['look' => $request->json()->get('figure'), 'gender' => $request->json()->get('gender')]);

        return response()->json(UserFacade::getUser());
    }

    /**
     * Get User Non Read Messenger Discussions.
     *
     * @TODO: Code Integration with HabboMessenger
     * @TODO: Create Messenger Model
     *
     * @return JsonResponse
     */
    public function getDiscussions(): JsonResponse
    {
        return response()->json([]);
    }

    /**
     * Get User Preferences.
     *
     * @return JsonResponse
     */
    public function getPreferences(): JsonResponse
    {
        $userPreferences = UserPreferences::firstOrCreate(['user_id' => UserFacade::getUser()->uniqueId]);

        foreach ($userPreferences->getAttributes() as $attributeName => $attributeValue) {
            $userPreferences->{$attributeName} = $attributeValue == 1;
        }

        return response()->json($userPreferences);
    }

    /**
     * Save New User Preferences.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function savePreferences(Request $request): Response
    {
        UserSettings::updateOrCreate(['user_id' => UserFacade::getUser()->uniqueId], [
            'block_following'      => $request->json()->get('friendCanFollow') == false ? '1' : '0',
            'block_friendrequests' => $request->json()->get('friendRequestEnabled') == false ? '1' : '0',
        ]);

        foreach ((array) $request->json()->all() as $setting => $value) {
            UserPreferences::find(UserFacade::getUser()->uniqueId)->update([$setting => $value == true ? '1' : '0']);
        }

        return response(null);
    }

    /**
     * Get All E-Mail Accounts.
     *
     * @return JsonResponse
     */
    public function getAvatars(): JsonResponse
    {
        return response()->json(UserFacade::getUser()->getChocolateyId()->relatedAccounts);
    }

    /**
     * Check if an Username is available
     * for a new Avatar Account.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkName(Request $request): JsonResponse
    {
        return response()->json(['isAvailable' => (User::where('username', $request->input('name'))->count() == 0
            && Validation::filterUserName($request->input('name')) && !UserFacade::getUser()->isStaff)]);
    }

    /**
     * Create a New User Avatar.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAvatar(Request $request): JsonResponse
    {
        if (User::where('username', $request->json()->get('name'))->count() == 0 && Validation::filterUserName($request->json()->get('name'))) {
            $user = $this->createUser($request, ['username' => $request->json()->get('name'), 'email' => UserFacade::getUser()->email]);

            ChocolateyId::find(UserFacade::getUser()->email)->update(['last_logged_id' => $user->uniqueId]);

            return response()->json('');
        }

        return response()->json('');
    }

    /**
     * Create a New User.
     *
     * @param Request $request
     * @param array   $userInfo
     * @param bool    $newUser  If is a New User
     *
     * @return User
     */
    public function createUser(Request $request, array $userInfo, bool $newUser = false): User
    {
        $userName = $newUser ? $this->uniqueName($userInfo['email']) : $userInfo['username'];

        $token = Mail::store($userInfo['email'], 'public/registration/activate');

        Mail::send(['email' => $userInfo['email'], 'name' => $userName, 'url' => "/activate/{$token}", 'subject' => 'Welcome to '.Config::get('chocolatey.hotelName')]);

        return UserFacade::setSession((new User())->store($userName, $userInfo['email'], $request->ip(), $newUser));
    }

    /**
     * Create Random Unique Username.
     *
     * @WARNING: Doesn't create Like Habbo Way
     *
     * @param string $userMail
     *
     * @return string
     */
    protected function uniqueName(string $userMail): string
    {
        $partialName = explode(' ', (new Alliteration())->getName());

        return strtolower($partialName[0].strstr($userMail, '@', true).$partialName[1]);
    }

    /**
     * Change Logged In User.
     *
     * @param Request $request
     */
    public function selectAvatar(Request $request)
    {
        UserFacade::getUser()->getChocolateyId()->update(['last_logged_id' => $request->json()->get('uniqueId')]);

        UserFacade::setSession(User::find($request->json()->get('uniqueId')));
    }

    /**
     * Send User Forgot E-Mail.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        if (($user = User::where('mail', $request->json()->get('email'))->first()) == null) {
            return response()->json(['email' => $request->json()->get('email')]);
        }

        $token = Mail::store($user->email, 'public/forgotPassword');

        Mail::send(['name' => $user->name, 'email' => $user->email, 'subject' => 'Password reset confirmation',
            'url'          => "/reset-password/{$token}",
        ], 'habbo-web-mail.password-reset');

        return response()->json(['email' => $user->email]);
    }

    /**
     * Send an Account Confirmation E-Mail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function verifyAccount(Request $request): Response
    {
        $token = Mail::store(UserFacade::getUser()->email, 'public/registration/activate');

        Mail::send(['name' => UserFacade::getUser()->name, 'email' => $request->user()->email,
            'url'          => "/activate/{$token}", 'subject' => 'Welcome to '.Config::get('chocolatey.hotelName'),
        ]);

        return response(null);
    }
}
