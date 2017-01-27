<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\AzureId;
use App\Models\User;
use App\Models\UserPreferences;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends BaseController
{
    /**
     * Check an User Name
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkName(Request $request)
    {
        $desiredUsername = $request->json()->get('name');

        if (User::where('username', $desiredUsername)->count() > 0)
            return response()->json(['code' => 'NAME_IN_USE', 'validationResult' => null, 'suggestions' => []]);

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Select an User Name
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function selectName(Request $request)
    {
        $desiredUsername = $request->json()->get('name');

        User::where('id', $request->user()->uniqueId)->update(['username' => $desiredUsername]);

        Session::set('ChocolateyWEB', User::where('id', $request->user()->uniqueId)->first());

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Save User Look
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function saveLook(Request $request)
    {
        if ($request->json()->get('gender') != 'm' && $request->json()->get('gender') != 'f')
            return response(null, 400);

        User::where('id', $request->user()->uniqueId)
            ->update(['look' => $request->json()->get('figure'), 'gender' => $request->json()->get('gender')]);

        Session::set('ChocolateyWEB', ($userData = User::where('id', $request->user()->uniqueId)->first()));

        return response()->json($userData);
    }

    /**
     * Select a Room
     *
     * @TODO: Generate the Room for the User
     * @TODO: Get Room Models.
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function selectRoom(Request $request)
    {
        $roomIndex = $request->json()->get('roomIndex');

        if ($roomIndex != 1 && $roomIndex != 2 && $roomIndex != 3)
            return response(null, 400);

        return response(null, 200);
    }

    /**
     * Get User Non Read Messenger Discussions
     *
     * @TODO: Code Integration with HabboMessenger
     * @TODO: Create Messenger Model
     *
     * @return JsonResponse
     */
    public function getDiscussions()
    {
        return response()->json([]);
    }

    /**
     * Get User Preferences
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPreferences(Request $request)
    {
        $userPreferences = UserPreferences::where('user_id', $request->user()->uniqueId)->first();

        foreach ($userPreferences->getAttributes() as $attributeName => $attributeValue)
            $userPreferences->{$attributeName} = $attributeValue == 1;

        return response()->json($userPreferences);
    }

    /**
     * Save New User Preferences
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function savePreferences(Request $request)
    {
        UserPreferences::query()->where('user_id', $request->user()->uniqueId)->update((array)$request->json()->all());

        return response(null, 200);
    }

    /**
     * Get All E-Mail Accounts
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAvatars(Request $request)
    {
        $userEmail = $request->user()->email;

        $azureIdAccounts = AzureId::where('mail', $userEmail)->first();

        return response()->json($azureIdAccounts->relatedAccounts, 200);
    }

    /**
     * Check if an Username is available
     * for a new Avatar Account
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkNewName(Request $request)
    {
        $userName = $request->input('name');

        if (DB::table('users')->where('username', $userName)->count() > 0)
            return response()->json(['isAvailable' => false]);

        return response()->json(['isAvailable' => true]);
    }

    /**
     * Create a New User Avatar
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function createAvatar(Request $request)
    {
        $userName = $request->json()->get('name');

        if (DB::table('users')->where('username', $userName)->count() > 0)
            return response()->json(['isAvailable' => false]);

        $userData = DB::table('users')->where('id', $request->user()->uniqueId)->first();

        $this->createUser($request, [
            'username' => $userName,
            'password' => $userData->password,
            'mail' => $userData->mail]);

        return response(null, 200);
    }

    /**
     * Create a New User
     *
     * @param Request $request
     * @param array $userInfo
     * @param bool $newUser
     * @return User
     */
    public function createUser(Request $request, array $userInfo, $newUser = false)
    {
        (new User)->store($userInfo['username'], $userInfo['password'], $userInfo['mail'])->save();

        $userData = User::where('username', $userInfo['username'])->first();

        (new AzureId)->store($userData->uniqueId, $userInfo['mail'])->save();

        (new UserPreferences)->store($userData->uniqueId)->save();

        $userData->trusted = $request->ip();

        $userData->traits = $newUser ? ["NEW_USER", "USER"] : ["USER"];

        Session::set('ChocolateyWEB', $userData);

        return $userData;
    }
}
