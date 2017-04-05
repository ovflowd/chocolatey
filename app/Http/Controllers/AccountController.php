<?php

namespace App\Http\Controllers;

use App\Facades\Mail;
use App\Facades\Nux;
use App\Facades\User as UserFacade;
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
     * Check an User Name.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkName(Request $request): JsonResponse
    {
        if (User::where('username', $request->json()->get('name'))->count() > 0 && $request->json()->get('name') != $request->user()->name) {
            return response()->json(['code' => 'NAME_IN_USE', 'validationResult' => null, 'suggestions' => []]);
        }

        if (strlen($request->json()->get('name')) > 50 || !$this->filterName($request->json()->get('name'))) {
            return response()->json(['code' => 'INVALID_NAME', 'validationResult' => ['resultType' => 'VALIDATION_ERROR_ILLEGAL_WORDS'], 'suggestions' => []]);
        }

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Filter an Username from the Invalid Names Base.
     *
     * @param string $userName
     *
     * @return bool
     */
    protected function filterName(string $userName): bool
    {
        return count(array_filter(Config::get('chocolatey.invalid'), function ($username) use ($userName) {
            return strpos($userName, $username) !== false;
        })) == 0;
    }

    /**
     * Select an User Name.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function selectName(Request $request): JsonResponse
    {
        UserFacade::updateUser(['username' => $request->json()->get('name')]);

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Save User Look.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function saveLook(Request $request): JsonResponse
    {
        UserFacade::updateUser(['look' => $request->json()->get('figure'), 'gender' => $request->json()->get('gender')]);

        return response()->json($request->user());
    }

    /**
     * Select a Room.
     *
     * @TODO: Generate the Room for the User
     * @TODO: Get Room Models.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function selectRoom(Request $request): Response
    {
        if (!in_array($request->json()->get('roomIndex'), [1, 2, 3])) {
            return response('', 400);
        }

        UserFacade::updateUser(Nux::generateRoom($request) ? ['traits' => ['USER']] : ['traits' => ['NEW_USER', 'USER']]);

        return response(null, 200);
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPreferences(Request $request): JsonResponse
    {
        $userPreferences = UserPreferences::find($request->user()->uniqueId);

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
        UserSettings::updateOrCreate(['user_id' => $request->user()->uniqueId], [
            'block_following'      => $request->json()->get('friendCanFollow') == false ? '1' : '0',
            'block_friendrequests' => $request->json()->get('friendRequestEnabled') == false ? '1' : '0',
        ]);

        foreach ((array) $request->json()->all() as $setting => $value) {
            UserPreferences::find($request->user()->uniqueId)->update([$setting => $value == true ? '1' : '0']);
        }

        return response(null);
    }

    /**
     * Get All E-Mail Accounts.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAvatars(Request $request): JsonResponse
    {
        return response()->json(ChocolateyId::where('mail', $request->user()->email)->first()->relatedAccounts);
    }

    /**
     * Check if an Username is available
     * for a new Avatar Account.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkNewName(Request $request): JsonResponse
    {
        return response()->json(['isAvailable' => User::where('username', $request->input('name'))->count() > 0 || !$this->filterName($request->input('name')) == false]);
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
        if (User::where('username', $request->json()->get('name'))->count() > 0 || !$this->filterName($request->json()->get('name'))) {
            return response()->json(['isAvailable' => false]);
        }

        $this->createUser($request, UserFacade::updateData($request->user(),
            ['name' => $request->json()->get('name')])->getAttributes());

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
        $userMail = $newUser ? $userInfo['email'] : $userInfo['mail'];

        $token = Mail::store($userMail, 'public/registration/activate');

        Mail::send(['email' => $userMail, 'name' => $userName,
            'url'           => "/activate/{$token}", 'subject' => 'Welcome to '.Config::get('chocolatey.hotelName'),
        ]);

        return UserFacade::setSession((new User())->store($userName, $userInfo['password'], $userMail, $request->ip()));
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
        UserFacade::setSession(User::find($request->json()->get('uniqueId')));
    }

    /**
     * Confirm E-Mail Activation.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function confirmActivation(Request $request): JsonResponse
    {
        if (Mail::getByToken($request->json()->get('token')) == null) {
            return response()->json(['error' => 'activation.invalid_token'], 400);
        }

        if (strpos(Mail::getMail()->link, 'change-email') !== false):
            $email = str_replace('change-email/', '', Mail::getMail()->link);

        User::where('mail', Mail::getMail()->mail)->update(['mail' => $email]);

        ChocolateyId::where('mail', Mail::getMail()->mail)->update(['mail' => $email]);
        endif;

        User::where('mail', Mail::getMail()->mail)->update(['mail_verified' => '1']);

        return response()->json(['email' => Mail::getMail()->mail, 'emailVerified' => true, 'identityVerified' => true]);
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
        $token = Mail::store($request->user()->email, 'public/registration/activate');

        Mail::send(['name' => $request->user()->name, 'email' => $request->user()->email,
            'url'          => "/activate/{$token}", 'subject' => 'Welcome to '.Config::get('chocolatey.hotelName'),
        ]);

        return response(null);
    }
}
