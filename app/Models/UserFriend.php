<?php

namespace App\Models;

/**
 * Class UserFriend.
 */
class UserFriend extends ChocolateyModel
{
    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messenger_friendships';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * User Friend Data.
     *
     * @var User
     */
    protected $friendData;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_one_id', 'user_two_id', 'relation', 'friends_since'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['figureString', 'motto', 'name', 'uniqueId'];

    /**
     * Get User Friend Figure String.
     *
     * @return string
     */
    public function getFigureStringAttribute(): string
    {
        return $this->getUserFriendData()->figureString;
    }

    /**
     * Get User Friend Data.
     *
     * @return User
     */
    protected function getUserFriendData(): User
    {
        return User::find($this->attributes['user_two_id']);
    }

    /**
     * Get User Friend Motto.
     *
     * @return string
     */
    public function getMottoAttribute(): string
    {
        return $this->getUserFriendData()->motto;
    }

    /**
     * Get User Friend Name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->getUserFriendData()->name;
    }

    /**
     * Get User Friend UniqueId.
     *
     * @return int
     */
    public function getUniqueIdAttribute(): int
    {
        return $this->getUserFriendData()->uniqueId;
    }
}
