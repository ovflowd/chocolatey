<?php

namespace App\Models;

/**
 * Class PhotoLike
 * @package App\Models
 */
class PhotoLike extends AzureModel
{
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
        $this->attributes['photoId'] = $photoId;
        $this->attributes['userName'] = $userName;

        return $this;
    }
}
