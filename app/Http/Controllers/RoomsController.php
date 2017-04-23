<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class RoomsController.
 */
class RoomsController extends BaseController
{
    /**
     * Get LeaderBoard Data.
     *
     * @TODO: Make Possible Filter with all the Possible Criteria
     *
     * @param string $countryId
     * @param string $roomRange
     * @param string $roomInterval
     *
     * @return JsonResponse
     */
    public function getLeader($countryId, $roomRange, $roomInterval): JsonResponse
    {
        $leaderRank = 1;

        foreach (($leaderBoard = Room::where('state', '!=', 'invisible')->orderBy('score', 'DESC')->orderBy('users', 'DESC')->limit(50)->get()) as $room) {
            $room->leaderboardRank = $leaderRank++;
        }

        return response()->json($leaderBoard, 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get a specific Room Data.
     *
     * @param int $roomId
     *
     * @return JsonResponse
     */
    public function getRoom($roomId): JsonResponse
    {
        return response()->json(Room::find($roomId) ?? ['error' => 'not-found'], 200, [], JSON_UNESCAPED_SLASHES);
    }
}
