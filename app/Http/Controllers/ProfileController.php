<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserPreferences;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends BaseController
{
    /**
     * Get Public User Data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPublicData(Request $request)
    {
        $userData = User::where('username', $request->input('name'))->first();

        if ($userData == null)
            return response(null, 404);

        $userBadges = UserBadge::where('user_id', $userData->uniqueId)->where('slot_id', '>', 0)->get();
        $userPreferences = UserPreferences::find($userData->uniqueId);

        $userData->selectedBadges = $userBadges == null ? [] : $userBadges;
        $userData->profileVisible = $userPreferences == null ? true : $userPreferences->profileVisible == '1';

        return response()->json($userData);
    }

    /**
     * Get Public User Profile
     *
     * @param int $userId
     * @return ResponseFactory
     */
    public function getPublicProfile($userId)
    {
        $userData = User::find($userId);

        if ($userData == null)
            return response(null, 404);

        $userPreferences = UserPreferences::find($userData->uniqueId);

        if ($userPreferences != null && $userPreferences->profileVisible == '0')
            return response(null, 404);

        $userProfile = new UserProfile($userData);

        return response()->json($userProfile);
    }

    /**
     * Get Private User Profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProfile(Request $request)
    {
        $userProfile = new UserProfile($request->user());

        return response()->json($userProfile);
    }

    /**
     * Get User Stories
     *
     * @TODO: Implement Habbo Stories
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getStories(Request $request)
    {
        return response()->json([]);
    }

    /**
     * Get User Photos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPhotos(Request $request)
    {
        if (Photo::where('creator_id', $request->user()->uniqueId)->count() == 0)
            return response()->json([]);

        $userPhotos = Photo::where('creator_id', $request->user()->uniqueId)->get();

        return response()->json($userPhotos);
    }
}
