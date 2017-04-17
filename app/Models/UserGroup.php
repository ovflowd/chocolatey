<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class UserGroup.
 */
class UserGroup extends ChocolateyModel
{
    use Eloquence, Mappable;

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
    protected $table = 'guilds';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that will be mapped.
     *
     * @var array
     */
    protected $maps = ['badgeCode' => 'badge', 'roomId' => 'room_id', 'primaryColour' => 'color_one', 'secondaryColour' => 'color_two'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id', 'badge', 'slot_id', 'id', 'user_id', 'room_id', 'state', 'rights', 'forum', 'date_created', 'read_forum', 'post_messages', 'post_threads', 'mod_forum'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['badgeCode', 'roomId', 'primaryColour', 'secondaryColour', 'type', 'isAdmin'];

    /**
     * Return if is Admin.
     *
     * @TODO: Link with User Data
     *
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return false;
    }

    /**
     * Get the Group Type.
     *
     * @TODO: What NORMAL means?
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return 'NORMAL';
    }
}
