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
     * @param string $selectType
     * @return JsonResponse
     */
    public function checkName(Request $request, $selectType)
    {
        if ($selectType != 'select' && $selectType != 'check')
            return response(null, 400);

        $desiredUsername = $request->json()->get('name');

        if (DB::table('users')->where('username', $desiredUsername)->count() > 0)
            return response()->json(['code' => 'NAME_IN_USE', 'validationResult' => null, 'suggestions' => []]);

        if ($selectType == 'select'):
            $userData = $request->user();
            $userData->name = $desiredUsername;

            DB::table('users')->where('id', $userData->uniqueId)->update(['username' => $userData->name]);

            Session::set('azureWEB', $userData);
        endif;

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

        $userData = $request->user();
        $userData->figureString = $request->json()->get('figure');
        $userData->gender = $request->json()->get('gender');

        DB::table('users')->where('id', $userData->uniqueId)->update(
            ['look' => $userData->figureString, 'gender' => $userData->gender]);

        Session::set('azureWEB', $userData);

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
        $userPreferences = UserPreferences::query()->where('user_id', $request->user()->uniqueId)->first();

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

        $azureIdAccounts = AzureId::query()->where('mail', $userEmail)->first();

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

    public function createAvatar(Request $request)
    {
        $userName = $request->json()->get('name');

        if (DB::table('users')->where('username', $userName)->count() > 0)
            return response()->json(['isAvailable' => false]);

        $userData = DB::table('users')->where('id', $request->user()->uniqueId)->first();

        (new User)->store($userName, $userData->password, $userData->mail)->save();

        $userNewData = User::query()->where('username', $userName)->first();

        (new AzureId)->store($userNewData->uniqueId, $userData->mail)->save();

        (new UserPreferences)->store($userNewData->uniqueId)->save();

        Session::set('azureWEB', $userNewData);

        return response(null, 200);
    }
}
