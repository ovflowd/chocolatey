<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class GroupMember
 * @package App\Models
 */
class GroupMember extends ChocolateyModel
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
    protected $table = 'guilds_members';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('id', 'member_since', 'guild_id', 'level_id', 'user_id');

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = array('guild');

    /**
     * Store Function.
     *
     * A Guild Member can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException('You cannot store a Guild by Chocolatey. Guilds need be created from the Server.');
    }

    /**
     * Get User Group by Member Group Id.
     *
     * @return UserGroup
     */
    public function getGuildAttribute(): UserGroup
    {
        return UserGroup::find($this->attributes['guild_id']);
    }

    /**
     * Get Description Attribute.
     *
     * @TODO: Get Real Badge Description
     *
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return "Badge {$this->attributes['badge_code']}";
    }
}
