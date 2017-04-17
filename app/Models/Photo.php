<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Photo.
 */
class Photo extends ChocolateyModel
{
    use Eloquence, Mappable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'camera_web';

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
    protected $maps = ['creator_id' => 'user_id', 'previewUrl' => 'url', 'creator_uniqueId' => 'user_id', 'time' => 'timestamp'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['creator_uniqueId', 'version', 'previewUrl', 'creator_id', 'likes', 'tags', 'version', 'type', 'room_id', 'creator_name'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['tags' => 'array', 'creator_uniqueId' => 'string'];

    /**
     * Get the Unique Id of the Photo.
     *
     * @return string
     */
    public function getIdAttribute(): string
    {
        return (string) $this->attributes['id'];
    }

    /**
     * Get the URL of the Photo.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return str_replace('http:', '', str_replace('https:', '', $this->attributes['url']));
    }

    /**
     * Get the Version Attribute.
     *
     * @return int
     */
    public function getVersionAttribute(): int
    {
        return 1;
    }

    /**
     * Get All Tags
     * Transforming it on an Array.
     *
     * @return array(string)
     */
    public function getTagsAttribute(): array
    {
        return [];
    }

    /**
     * Get Formatted Time
     * Convert Date to UNIX Timestamp.
     *
     * @return int
     */
    public function getTimeAttribute(): int
    {
        return strtotime($this->attributes['timestamp']) * 1000;
    }

    /**
     * Get Photo Likes Directly as Username.
     *
     * @return array
     */
    public function getLikesAttribute(): array
    {
        return array_map(function (array $item) {
            return $item['username'];
        }, PhotoLike::query()->select('username')->where('photo_id', $this->attributes['id'])->get(['username'])->toArray());
    }

    /**
     * Get the Photo Type Attribute.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return 'PHOTO';
    }

    /**
     * Get Room Id.
     *
     * @TODO: Add real RoomID
     *
     * @return int
     */
    public function getRoomIdAttribute(): int
    {
        return 1;
    }

    /**
     * Get User Name.
     *
     * @return string
     */
    public function getCreatorNameAttribute(): string
    {
        return User::find($this->attributes['user_id'])->name;
    }
}
