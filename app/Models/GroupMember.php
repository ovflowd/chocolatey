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
    protected $table = 'guilds_members';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'member_since',
    ];

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'guild'
    ];

    /**
     * Get User Group by Member Group Id
     *
     * @return UserGroup
     */
    public function getGuildAttribute()
    {
        return UserGroup::find($this->attributes['guild_id']);
    }

    /**
     * Store Function
     *
     * A Guild Member can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException("You cannot store a Guild by AzureWEB. Guilds need be created from the Server.");
    }

    /**
     * Get Description Attribute
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return "Badge {$this->attributes['badge_code']}";
    }
}
