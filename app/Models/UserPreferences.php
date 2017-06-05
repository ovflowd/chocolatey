<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPreferences.
 */
class UserPreferences extends Model
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
    protected $table = 'chocolatey_users_preferences';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['emailFriendRequestNotificationEnabled', 'emailGiftNotificationEnabled', 'emailGroupNotificationEnabled', 'emailMiniMailNotificationEnabled',
        'emailNewsletterEnabled', 'emailRoomMessageNotificationEnabled', 'friendCanFollow', 'friendRequestEnabled', 'offlineMessagingEnabled', 'onlineStatusVisible', 'profileVisible', ];

    /**
     * Store an User Preference set on the Database.
     *
     * @param int $userId
     *
     * @return UserPreferences
     */
    public function store(int $userId): UserPreferences
    {
        $this->attributes['user_id'] = $userId;
        $this->timestamps = false;

        $this->save();

        return $this;
    }
}
