<?php

namespace App\Models;

/**
 * Class UserSettings
 * @package App\Models
 */
class UserSettings extends ChocolateyModel
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
    protected $table = 'users_settings';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
