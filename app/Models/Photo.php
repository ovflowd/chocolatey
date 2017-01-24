<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App\Models
 */
class Photo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'azure_user_photos';

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'creator_uniqueId',
        'version'
    ];

    /**
     * Get the Unique Id of the Photo
     *
     * @return string
     */
    public function getIdAttribute()
    {
        return "{$this->attributes['id']}";
    }

    /**
     * Create the Creator Unique Identifier based on Identifier
     *
     * @return string
     */
    public function getCreatorUniqueIdAttribute()
    {
        return "{$this->attributes['creator_id']}";
    }

    /**
     * Get the Version Attribute
     *
     * @return int
     */
    public function getVersionAttribute()
    {
        return 1;
    }

    /**
     * Get All Tags
     * Transforming it on an Array
     *
     * @return array(string)
     */
    public function getTagsAttribute()
    {
        return empty($this->attributes['tags']) ? [] : explode(',', $this->attributes['tags']);
    }

    /**
     * Get Formatted Time
     * Convert Date to UNIX Timestamp
     *
     * @return int
     */
    public function getTimeAttribute()
    {
        return strtotime($this->attributes['time']);
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'creator_uniqueId' => 'string'
    ];
}
