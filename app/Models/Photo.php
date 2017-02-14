<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class Photo
 * @package App\Models
 */
class Photo extends ChocolateyModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_users_photos';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'creator_uniqueId',
        'version',
        'likes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'creator_uniqueId' => 'string'
    ];

    /**
     * Store Function
     *
     * A photo can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException("You cannot store a Photo by Chocolatey. Photos need be created from the Server.");
    }

    /**
     * Get the Unique Id of the Photo
     *
     * @return string
     */
    public function getIdAttribute(): string
    {
        return "{$this->attributes['id']}";
    }

    /**
     * Create the Creator Unique Identifier based on Identifier
     *
     * @return string
     */
    public function getCreatorUniqueIdAttribute(): string
    {
        return "{$this->attributes['creator_id']}";
    }

    /**
     * Get the Version Attribute
     *
     * @return int
     */
    public function getVersionAttribute(): int
    {
        return 1;
    }

    /**
     * Get All Tags
     * Transforming it on an Array
     *
     * @return array(string)
     */
    public function getTagsAttribute(): array
    {
        return explode(',', $this->attributes['tags'] ?? '');
    }

    /**
     * Get Formatted Time
     * Convert Date to UNIX Timestamp
     *
     * @return int
     */
    public function getTimeAttribute(): int
    {
        return strtotime($this->attributes['time']) * 1000;
    }

    /**
     * Get Photo Likes Directly as Username
     *
     * @return array
     */
    public function getLikesAttribute(): array
    {
        return PhotoLike::query()->select('username')->where('photo_id', $this->attributes['id'])->get(['username'])->toArray();
    }
}
