<?php

namespace App\Models;

/**
 * Class PhotoLike
 * @package App\Models
 */
class PhotoLike extends AzureModel
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
    protected $table = 'azure_user_photos_likes';

    /**
     * Store a new Photo Data
     *
     * @param int $photoId
     * @param string $userName
     * @return $this
     */
    public function store($photoId, $userName)
    {
        $this->attributes['photo_id'] = $photoId;
        $this->attributes['username'] = $userName;

        return $this;
    }
}
