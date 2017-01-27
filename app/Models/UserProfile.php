<?php

namespace App\Models;

/**
 * Class UserProfile
 * @package App\Models
 */
class UserProfile
{
    /**
     * User Data
     *
     * @var User
     */
    public $user;

    /**
     * User Friends
     *
     * @var UserFriend[]|array
     */
    public $friends = [];

    /**
     * User Badges
     *
     * @var UserBadge[]|array
     */
    public $badges = [];

    /**
     * User Groups
     *
     * @var UserGroup[]|array
     */
    public $groups = [];

    /**
     * User Rooms
     *
     * @var Room[]|array
     */
    public $rooms = [];

    /**
     * UserProfile constructor.
     *
     * @param User $userData
     * @internal param User $userId
     */
    public function __construct(User $userData)
    {
        $this->setUser($userData);
        $this->setFriends();
        $this->setBadges();
        $this->setGroups();
        $this->setRooms();
    }

    /**
     * Set User Data
     *
     * @param User $userData
     */
    protected function setUser(User $userData)
    {
        $this->user = $userData;
    }

    /**
     * Set User Friends
     */
    protected function setFriends()
    {
        $userFriends = UserFriend::where('user_one_id', $this->user->uniqueId)->get();

        if ($userFriends == null)
            return;

        $this->friends = $userFriends;
    }

    /**
     * Set User Badges
     */
    protected function setBadges()
    {
        $userBadges = UserBadge::where('user_id', $this->user->uniqueId)->get();

        if ($userBadges == null)
            return;

        $this->badges = $userBadges;
    }

    /**
     * Set User Groups
     */
    protected function setGroups()
    {
        $userGroups = [];

        $groupsData = GroupMember::where('user_id', $this->user->uniqueId)->get();

        if ($groupsData == null)
            return;

        foreach ($groupsData as $groupData)
            $userGroups[] = $groupData->guild;

        $this->groups = $userGroups;
    }

    /**
     * Set User Rooms
     */
    public function setRooms()
    {
        $userRooms = Room::where('owner_id', $this->user->uniqueId)->get();

        if ($userRooms == null)
            return;

        $leaderRank = 1;

        foreach ($userRooms as $room)
            $room->leaderboardRank = $leaderRank++;

        $this->rooms = $userRooms;
    }
}
