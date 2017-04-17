<?php

namespace App\Helpers;

use App\Models\Room;
use App\Models\RoomItem;
use App\Models\User;
use App\Singleton;
use Illuminate\Http\Request;

/**
 * Class Nux.
 */
final class Nux extends Singleton
{
    /**
     * Generate a NUX Room.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function generateRoom(Request $request): bool
    {
        switch ($request->json()->get('roomIndex')):
            case 1:
                return $this->createBedRoom($request->user());
        case 2:
                return $this->createPoolRoom($request->user());
        case 3:
                return $this->createClubRoom($request->user());
        default:
                return false;
        endswitch;
    }

    /**
     * Create the NUX Bed Room.
     *
     * @param User $user
     *
     * @return bool
     */
    protected function createBedRoom(User $user): bool
    {
        $room = (new Room())->store("{$user->name}'s room", "{$user->name} has entered the building", 'model_h', 25, 12, 610, 2403, 0.0, $user->uniqueId, $user->name);

        $user->update(['home_room' => $room->id]);

        // Floor Items
        (new RoomItem())->store($user->uniqueId, $room->id, 15542, 9, 9, '0.00000', 4, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 15542, 9, 12, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 15542, 10, 9, '0.00000', 4, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 15542, 10, 12, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16412, 9, 5, '1.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16435, 7, 5, '1.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16486, 8, 5, '1.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17816, 6, 2, '1.00000', 0, '4');
        (new RoomItem())->store($user->uniqueId, $room->id, 17816, 9, 2, '1.00000', 0, '4');
        (new RoomItem())->store($user->uniqueId, $room->id, 17824, 7, 2, '1.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 17894, 9, 10, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18074, 8, 4, '1.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 18817, 3, 10, '0.01000', 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18835, 3, 9, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18835, 3, 11, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18835, 5, 9, '0.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18835, 5, 11, '0.00000', 0, '');

        // Wall Items
        (new RoomItem())->store($user->uniqueId, $room->id, 22988, 0, 0, '0', 0, '', ':w=4,2 l=0,35 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23163, 0, 0, '0', 0, '1', ':w=4,8 l=0,43 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23261, 0, 0, '0', 0, '', ':w=2,10 l=2,34 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23331, 0, 0, '0', 0, '', ':w=2,10 l=2,29 l');

        return true;
    }

    /**
     * Create the Pool Room.
     *
     * @param User $user
     *
     * @return bool
     */
    protected function createPoolRoom(User $user): bool
    {
        $room = (new Room())->store("{$user->name}'s room", "{$user->name} has entered the building", 'model_h', 25, 12, 307, 3104, 1.10, $user->uniqueId, $user->name);

        $user->update(['home_room' => $room->id]);

        // Floor Items
        (new RoomItem())->store($user->uniqueId, $room->id, 16715, 5, 11, 1.30000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16732, 3, 10, 0.40000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17016, 3, 9, 0.00000, 2, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 17016, 3, 11, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17016, 4, 9, 0.00000, 4, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17090, 3, 9, 0.00000, 2, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 17176, 3, 9, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17176, 3, 9, 0.40000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17176, 3, 10, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17190, 3, 11, 0.00000, 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17190, 4, 9, 0.00000, 4, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17191, 3, 10, 0.40000, 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17191, 3, 12, 0.00000, 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17484, 8, 3, 1.00000, 0, '0', 0);
        (new RoomItem())->store($user->uniqueId, $room->id, 17499, 7, 3, 1.00000, 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 7, 2, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 7, 4, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 7, 5, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 8, 2, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 8, 5, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 9, 2, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 9, 5, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 10, 2, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 10, 3, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 10, 4, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17520, 10, 5, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17987, 5, 11, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 5, 2, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 5, 4, 1.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 8, 9, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 8, 11, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 9, 9, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18051, 9, 11, 0.00000, 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18061, 8, 8, 0.00000, 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18061, 8, 9, 0.00000, 6, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 18061, 10, 8, 0.00000, 4, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 18070, 8, 2, 1.50000, 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 18079, 9, 8, 0.00000, 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 18363, 3, 9, 0.80000, 0, '2');

        // Wall Items
        (new RoomItem())->store($user->uniqueId, $room->id, 22996, 0, 0, '0', 0, '', ':w=4,8 l=7,45 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 22996, 0, 0, '0', 0, '', ':w=4,8 l=9,45 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23063, 0, 0, '0', 0, '', ':w=2,10 l=10,56 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23063, 0, 0, '0', 0, '', ':w=2,11 l=6,58 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23078, 0, 0, '0', 0, '1', ':w=6,1 l=0,26 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23078, 0, 0, '0', 0, '3', ':w=7,1 l=4,28 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23078, 0, 0, '0', 0, '1', ':w=8,1 l=13,33 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23078, 0, 0, '0', 0, '3', ':w=10,1 l=0,26 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23229, 0, 0, '0', 0, '1', ':w=4,3 l=6,49 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23229, 0, 0, '0', 0, '1', ':w=4,5 l=11,45 l');

        return true;
    }

    /**
     * Create the NUX Club Room.
     *
     * @param User $user
     *
     * @return bool
     */
    protected function createClubRoom(User $user): bool
    {
        $room = (new Room())->store("{$user->name}'s room", "{$user->name} has entered the building", 'model_h', 25, 12, 409, 1902, 0.0, $user->uniqueId, $user->name);

        $user->update(['home_room' => $room->id]);

        // Floor Items
        (new RoomItem())->store($user->uniqueId, $room->id, 16904, 4, 11, '0.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16905, 6, 9, '0.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16905, 6, 10, '0.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16905, 8, 9, '0.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16905, 8, 10, '0.00000', 0, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16907, 5, 9, '0.00000', 6, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16907, 5, 10, '0.00000', 6, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 16909, 4, 9, '0.00000', 2, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16909, 4, 10, '0.00000', 2, '1');
        (new RoomItem())->store($user->uniqueId, $room->id, 16913, 6, 7, '1.30000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 16913, 9, 7, '1.30000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 17189, 10, 2, '1.00000', 0, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 17573, 6, 7, '0.00000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 17573, 7, 7, '0.00000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 17573, 8, 7, '0.00000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 17573, 9, 7, '0.00000', 0, '3');
        (new RoomItem())->store($user->uniqueId, $room->id, 18048, 7, 2, '1.00000', 4, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18082, 6, 3, '1.00000', 2, '');
        (new RoomItem())->store($user->uniqueId, $room->id, 18082, 9, 3, '1.00000', 6, '');

        // Wall Items
        (new RoomItem())->store($user->uniqueId, $room->id, 23008, 0, 0, '0', 0, '2', ':w=4,8 l=0,27 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23013, 0, 0, '0', 0, '', ':w=2,10 l=2,44 l');
        (new RoomItem())->store($user->uniqueId, $room->id, 23014, 0, 0, '0', 0, '1', ':w=8,1 l=14,27 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23236, 0, 0, '0', 0, '1', ':w=6,1 l=5,31 r');
        (new RoomItem())->store($user->uniqueId, $room->id, 23239, 0, 0, '0', 0, '', ':w=4,7 l=4,29 l');

        return true;
    }
}
