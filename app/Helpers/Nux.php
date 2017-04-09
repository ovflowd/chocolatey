<?php

namespace App\Helpers;

use App\Models\Room;
use App\Models\User;
use App\Models\RoomItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class Nux.
 */
final class Nux
{
    /**
     * Create and return a Nux instance.
     *
     * @return Nux
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

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
        $room->save();
        
        Users::find($user->uniqueId)->update(['home_room' => $room->id]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 15542, 'x' => 9, 'y' => 9, 'z' => '0.00000', 'rot' => 4, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 15542, 'x' => 9, 'y' => 12, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 15542, 'x' => 10, 'y' => 9, 'z' => '0.00000', 'rot' => 4, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 15542, 'x' => 10, 'y' => 12, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16412, 'x' => 9, 'y' => 5, 'z' => '1.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16435, 'x' => 7, 'y' => 5, 'z' => '1.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16486, 'x' => 8, 'y' => 5, 'z' => '1.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17816, 'x' => 6, 'y' => 2, 'z' => '1.00000', 'rot' => 0, 'extra_data' => '4'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17816, 'x' => 9, 'y' => 2, 'z' => '1.00000', 'rot' => 0, 'extra_data' => '4'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17824, 'x' => 7, 'y' => 2, 'z' => '1.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17894, 'x' => 9, 'y' => 10, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18074, 'x' => 8, 'y' => 4, 'z' => '1.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18817, 'x' => 3, 'y' => 10, 'z' => '0.01000', 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18835, 'x' => 3, 'y' => 9, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18835, 'x' => 3, 'y' => 11, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18835, 'x' => 5, 'y' => 9, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18835, 'x' => 5, 'y' => 11, 'z' => '0.00000', 'rot' => 0, 'extra_data' => ''],
        ]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 22988, 'wall_pos' => ':w=4,2 l=0,35 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23163, 'wall_pos' => ':w=4,8 l=0,43 r', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23261, 'wall_pos' => ':w=2,10 l=2,34 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23331, 'wall_pos' => ':w=2,10 l=2,29 l', 'extra_data' => ''],
        ]);

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
        $room->save();

        Users::find($user->uniqueId)->update(['home_room' => $room->id]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16715, 'x' => 5, 'y' => 11, 'z' => 1.30000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16732, 'x' => 3, 'y' => 10, 'z' => 0.40000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17016, 'x' => 3, 'y' => 9, 'z' => 0.00000, 'rot' => 2, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17016, 'x' => 3, 'y' => 11, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17016, 'x' => 4, 'y' => 9, 'z' => 0.00000, 'rot' => 4, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17090, 'x' => 3, 'y' => 9, 'z' => 0.00000, 'rot' => 2, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17176, 'x' => 3, 'y' => 9, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17176, 'x' => 3, 'y' => 9, 'z' => 0.40000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17176, 'x' => 3, 'y' => 10, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17190, 'x' => 3, 'y' => 11, 'z' => 0.00000, 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17190, 'x' => 4, 'y' => 9, 'z' => 0.00000, 'rot' => 4, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17191, 'x' => 3, 'y' => 10, 'z' => 0.40000, 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17191, 'x' => 3, 'y' => 12, 'z' => 0.00000, 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17484, 'x' => 8, 'y' => 3, 'z' => 1.00000, 'rot' => 0, 'extra_data' => '0'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17499, 'x' => 7, 'y' => 3, 'z' => 1.00000, 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 7, 'y' => 2, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 7, 'y' => 4, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 7, 'y' => 5, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 8, 'y' => 2, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 8, 'y' => 5, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 9, 'y' => 2, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 9, 'y' => 5, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 10, 'y' => 2, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 10, 'y' => 3, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 10, 'y' => 4, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17520, 'x' => 10, 'y' => 5, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17987, 'x' => 5, 'y' => 11, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 5, 'y' => 2, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 5, 'y' => 4, 'z' => 1.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 8, 'y' => 9, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 8, 'y' => 11, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 9, 'y' => 9, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18051, 'x' => 9, 'y' => 11, 'z' => 0.00000, 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18061, 'x' => 8, 'y' => 8, 'z' => 0.00000, 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18061, 'x' => 8, 'y' => 9, 'z' => 0.00000, 'rot' => 6, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18061, 'x' => 10, 'y' => 8, 'z' => 0.00000, 'rot' => 4, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18070, 'x' => 8, 'y' => 2, 'z' => 1.50000, 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18079, 'x' => 9, 'y' => 8, 'z' => 0.00000, 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18363, 'x' => 3, 'y' => 9, 'z' => 0.80000, 'rot' => 0, 'extra_data' => '2'],
        ]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 22996, 'wall_pos' => ':w=4,8 l=7,45 r', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 22996, 'wall_pos' => ':w=4,8 l=9,45 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23063, 'wall_pos' => ':w=2,10 l=10,56 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23063, 'wall_pos' => ':w=2,11 l=6,58 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23078, 'wall_pos' => ':w=6,1 l=0,26 r', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23078, 'wall_pos' => ':w=7,1 l=4,28 r', 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23078, 'wall_pos' => ':w=8,1 l=13,33 r', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23078, 'wall_pos' => ':w=10,1 l=0,26 r', 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23229, 'wall_pos' => ':w=4,3 l=6,49 l', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23229, 'wall_pos' => ':w=4,5 l=11,45 l', 'extra_data' => '1'],
        ]);

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
        $room->save();

        Users::find($user->uniqueId)->update(['home_room' => $room->id]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16904, 'x' => 4, 'y' => 11, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16905, 'x' => 6, 'y' => 9, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16905, 'x' => 6, 'y' => 10, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16905, 'x' => 8, 'y' => 9, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16905, 'x' => 8, 'y' => 10, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16907, 'x' => 5, 'y' => 9, 'z' => '0.00000', 'rot' => 6, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16907, 'x' => 5, 'y' => 10, 'z' => '0.00000', 'rot' => 6, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16909, 'x' => 4, 'y' => 9, 'z' => '0.00000', 'rot' => 2, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16909, 'x' => 4, 'y' => 10, 'z' => '0.00000', 'rot' => 2, 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16913, 'x' => 6, 'y' => 7, 'z' => '1.30000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 16913, 'x' => 9, 'y' => 7, 'z' => '1.30000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17189, 'x' => 10, 'y' => 2, 'z' => '1.00000', 'rot' => 0, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17573, 'x' => 6, 'y' => 7, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17573, 'x' => 7, 'y' => 7, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17573, 'x' => 8, 'y' => 7, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 17573, 'x' => 9, 'y' => 7, 'z' => '0.00000', 'rot' => 0, 'extra_data' => '3'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18048, 'x' => 7, 'y' => 2, 'z' => '1.00000', 'rot' => 4, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18082, 'x' => 6, 'y' => 3, 'z' => '1.00000', 'rot' => 2, 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 18082, 'x' => 9, 'y' => 3, 'z' => '1.00000', 'rot' => 6, 'extra_data' => ''],
        ]);

        DB::table('items')->insert([
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23008, 'wall_pos' => ':w=4,8 l=0,27 r', 'extra_data' => '2'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23013, 'wall_pos' => ':w=2,10 l=2,44 l', 'extra_data' => ''],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23014, 'wall_pos' => ':w=8,1 l=14,27 r', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23236, 'wall_pos' => ':w=6,1 l=5,31 r', 'extra_data' => '1'],
            ['user_id' => $user->uniqueId, 'room_id' => $room->id, 'item_id' => 23239, 'wall_pos' => ':w=4,7 l=4,29 l', 'extra_data' => ''],
        ]);

        return true;
    }
}
