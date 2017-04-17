<?php

namespace App\Models;

/**
 * Class GroupMember.
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
    protected $hidden = ['id', 'member_since', 'guild_id', 'level_id', 'user_id'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['guild'];

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
