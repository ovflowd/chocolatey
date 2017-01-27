<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class UserBadge
 * @package App\Models
 */
class UserBadge extends ChocolateyModel
{
    use Eloquence, Mappable;

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
    protected $table = 'users_badges';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that will be mapped
     *
     * @var array
     */
    protected $maps = [
        'badgeIndex' => 'slot_id',
        'code' => 'badge_code',
        'name' => 'badge_code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'badge_code',
        'slot_id',
        'id'
    ];

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'description',
        'badgeIndex',
        'code',
        'name'
    ];

    /**
     * Store Function
     *
     * A Badge can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException("You cannot store an User Badge by AzureWEB. Badges need be created from the Server.");
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
