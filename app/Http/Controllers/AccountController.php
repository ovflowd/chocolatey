<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Facades\Generators;
use App\Models\ChocolateyId;
use App\Models\User;
use App\Models\UserPreferences;
use App\Models\UserSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        if (User::where('username', $request->json()->get('name'))->count() > 0)
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
        User::find($request->user()->uniqueId)->update(['username' => $request->json()->get('name')]);

        Session::set('ChocolateyWEB', User::find($request->user()->uniqueId));

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

        User::find($request->user()->uniqueId)->update([
            'look' => $request->json()->get('figure'),
            'gender' => $request->json()->get('gender')]);

        Session::set('ChocolateyWEB', ($userData = User::find($request->user()->uniqueId)));

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
        if (!in_array($request->json()->get('roomIndex'), [1, 2, 3]))
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
        $userPreferences = UserPreferences::find($request->user()->uniqueId);

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
        UserSettings::updateOrCreate([
            'user_id' => $request->user()->uniqueId,
            'block_following' => $request->json()->get('friendCanFollow') == false,
            'block_friendrequests' => $request->json()->get('friendRequestEnabled') == false
        ]);

        UserPreferences::find($request->user()->uniqueId)->update((array)$request->json()->all());

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
        $azureIdAccounts = ChocolateyId::where('mail', $request->user()->email)->first();

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
        if (User::where('username', $request->input('name'))->count() > 0)
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
        if (User::where('username', $request->json()->get('name'))->count() > 0)
            return response()->json(['isAvailable' => false]);

        $userData = User::find($request->user()->uniqueId);

        $this->createUser($request, [
            'username' => $request->json()->get('name'),
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
        (new User)->store($newsUser ? ($userInfo['username'] = Generators::generateUserName($userInfo['email'])) : $userInfo['username'], 
            $userInfo['password'], $userInfo['email'])->save();

        $userData = User::where('username', $userInfo['username'])->first();

        (new ChocolateyId)->store($userData->uniqueId, $userInfo['email'])->save();

        (new UserPreferences)->store($userData->uniqueId)->save();

        $userData->trusted = $request->ip();

        $userData->traits = $newUser ? ["NEW_USER", "USER"] : ["USER"];

        Session::set('ChocolateyWEB', $userData);

        return $userData;
    }
}
