<?php

namespace App\Models;

/**
 * Class UserSettings.
 */
class UserSettings extends ChocolateyModel
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
    protected $table = 'users_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'block_following', 'block_friendrequests'];

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
