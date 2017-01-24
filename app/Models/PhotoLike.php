<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PhotoLike
 * @package App\Models
 */
class PhotoLike extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'azure_user_photos_likes';

    /**
     * Unique Identifier of Like
     *
     * @var int
     */
    public $id;

    /**
     * The Photo Referenced Id
     *
     * @var int
     */
    public $photoId;

    /**
     * The Username of the User that
     * Liked the Photo
     *
     * @var string
     */
    public $userName;
}
