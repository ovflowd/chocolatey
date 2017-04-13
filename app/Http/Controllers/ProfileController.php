<?php

namespace App\Http\Controllers;

use App\Facades\User as UserFacade;
use App\Models\Photo;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserPreferences;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ProfileController.
 */
class ProfileController extends BaseController
{
    /**
     * Get Public User Data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPublicData(Request $request): JsonResponse
    {
        $userData = User::where('username', $request->input('name'))->first();

        if ($userData == null || $userData->isBanned) {
            return response()->json(null, 404);
        }

        $userPreferences = UserPreferences::find($userData->uniqueId);

        $userData->selectedBadges = UserBadge::where('user_id', $userData->uniqueId)->where('slot_id', '>', 0)->orderBy('slot_id', 'ASC')->get() ?? [];
        $userData->profileVisible = $userPreferences == null ? true : $userPreferences->profileVisible == '1';

        return response()->json($userData);
    }

    /**
     * Get Public User Profile.
     *
     * @param int $userId
     *
     * @return JsonResponse
     */
    public function getPublicProfile($userId): JsonResponse
    {
        $userData = User::find($userId);

        if ($userData == null || $userData->isBanned) {
            return response()->json(null, 404);
        }

        $userPreferences = UserPreferences::find($userData->uniqueId);

        if ($userPreferences != null && $userPreferences->profileVisible == '0') {
            return response()->json(null, 404);
        }

        return response()->json(new UserProfile($userData));
    }

    /**
     * Get Private User Profile.
     *
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        return response()->json(new UserProfile(UserFacade::getUser()));
    }

    /**
     * Get User Stories.
     *
     * @TODO: Implement Habbo Stories
     *
     * @return JsonResponse
     */
    public function getStories(): JsonResponse
    {
        return response()->json([]);
    }

    /**
     * Get User Photos.
     *
     * @param int $userId
     *
     * @return JsonResponse
     */
    public function getPhotos(int $userId): JsonResponse
    {
        if (Photo::where('creator_id', $userId)->count() == 0) {
            return response()->json([]);
        }

        $userPhotos = Photo::where('creator_id', $userId)->get();

        return response()->json($userPhotos);
    }
}
