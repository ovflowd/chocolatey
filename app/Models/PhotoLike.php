<?php

namespace App\Models;

/**
 * Class PhotoLike.
 */
class PhotoLike extends ChocolateyModel
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
    protected $table = 'chocolatey_users_photos_likes';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store a new Photo Data.
     *
     * @param int    $photoId
     * @param string $userName
     *
     * @return PhotoLike
     */
    public function store(int $photoId, string $userName): PhotoLike
    {
        $this->attributes['photo_id'] = $photoId;
        $this->attributes['username'] = $userName;
        $this->timestamps = false;

        $this->save();

        return $this;
    }
}
