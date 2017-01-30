<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 */
class UserPreferences extends Model
{
    /**
     * Disable Timestamps
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
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * Store an User Preference set on the Database
     *
     * @param int $userId
     * @return UserPreferences
     */
    public function store($userId): UserPreferences
    {
        $this->attributes['user_id'] = $userId;

        return $this;
    }
}
