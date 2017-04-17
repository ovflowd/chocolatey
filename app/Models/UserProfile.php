<?php

namespace App\Models;

/**
 * Class UserProfile.
 */
class UserProfile
{
    /**
     * User Data.
     *
     * @var User
     */
    public $user;

    /**
     * User Friends.
     *
     * @var UserFriend[]|array
     */
    public $friends = [];

    /**
     * User Badges.
     *
     * @var UserBadge[]|array
     */
    public $badges = [];

    /**
     * User Groups.
     *
     * @var UserGroup[]|array
     */
    public $groups = [];

    /**
     * User Rooms.
     *
     * @var Room[]|array
     */
    public $rooms = [];

    /**
     * UserProfile constructor.
     *
     * @param User $userData
     *
     * @return UserProfile
     */
    public function __construct(User $userData)
    {
        $this->setUser($userData);

        $this->setFriends();
        $this->setBadges();
        $this->setGroups();
        $this->setRooms();

        return $this;
    }

    /**
     * Set User Data.
     *
     * @param User $userData
     */
    protected function setUser(User $userData)
    {
        $this->user = $userData;
    }

    /**
     * Set User Friends.
     */
    protected function setFriends()
    {
        $this->friends = UserFriend::where('user_one_id', $this->user->uniqueId)->get() ?? [];
    }

    /**
     * Set User Badges.
     */
    protected function setBadges()
    {
        $this->badges = UserBadge::where('user_id', $this->user->uniqueId)->get() ?? [];
    }

    /**
     * Set User Groups.
     */
    protected function setGroups()
    {
        $groups = GroupMember::where('user_id', $this->user->uniqueId)->get() ?? [];

        foreach ($groups as $group) {
            $this->groups[] = $group->guild;
        }
    }

    /**
     * Set User Rooms.
     */
    public function setRooms()
    {
        $this->rooms = Room::where('owner_id', $this->user->uniqueId)->where('state', '!=', 'invisible')->get() ?? [];
    }
}
