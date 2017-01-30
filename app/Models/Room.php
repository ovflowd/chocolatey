<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class Room
 * @package App\Models
 */
class Room extends Model
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
    protected $table = 'rooms';

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
        'uniqueId' => 'id',
        'ownerName' => 'owner_name',
        'ownerUniqueId' => 'owner_id',
        'doorMode' => 'state',
        'leaderboardValue' => 'score',
        'maximumVisitors' => 'users_max',
        'habboGroupId' => 'guild_id',
        'rating' => 'score',
    ];

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'uniqueId',
        'leaderboardRank',
        'thumbnailUrl',
        'imageUrl',
        'leaderboardValue',
        'doorMode',
        'maximumVisitors',
        'publicRoom',
        'ownerUniqueId',
        'ownerName',
        'showOwnerName',
        'categories',
        'rating'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'owner_name',
        'owner_id',
        'is_public',
        'state',
        'password',
        'model',
        'users',
        'users_max',
        'guild_id',
        'category',
        'score',
        'paper_floor',
        'paper_wall',
        'paper_landscape',
        'thickness_wall',
        'wall_height',
        'thickness_floor',
        'moodlight_data',
        'is_staff_picked',
        'allow_other_pets',
        'allow_other_pets_eat',
        'allow_walkthrough',
        'allow_hidewall',
        'chat_mode',
        'chat_weight',
        'chat_speed',
        'chat_hearing_distance',
        'chat_protection',
        'override_model',
        'who_can_mute',
        'who_can_kick',
        'who_can_ban',
        'poll_id',
        'roller_speed',
        'promoted',
        'trade_mode',
        'move_diagonally'
    ];

    /**
     * Store Function
     *
     * A Room can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException("You cannot store a Room by Chocolatey. Rooms need be created from the Server.");
    }

    /**
     * Get Room Tags
     *
     * @return array
     */
    public function getTagsAttribute(): array
    {
        return explode(';', $this->attributes['tags'] ?? '');
    }

    /**
     * Get Image Url
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        $roomName = Config::get('chocolatey.arcturus');

        return "http://arcturus.wf/camera/{$roomName}/thumbnail_{$this->attributes['id']}.png";
    }

    /**
     * Get Thumbnail Url
     *
     * @return string
     */
    public function getThumbnailUrlAttribute(): string
    {
        $roomName = Config::get('chocolatey.arcturus');

        return "http://arcturus.wf/camera/{$roomName}/thumbnail_{$this->attributes['id']}.png";
    }

    /**
     * Return if need show Owner Name
     *
     * @TODO: What this really does?
     *
     * @return bool
     */
    public function getShowOwnerNameAttribute(): bool
    {
        return true;
    }

    /**
     * Set a Leader Board Position
     *
     * @param int $roomPosition
     */
    public function setLeaderBoardRankAttribute(int $roomPosition = 1)
    {
        $this->attributes['leaderboardRank'] = $roomPosition;
    }

    /**
     * Get Leader Board Rank
     *
     * @return int
     */
    public function getLeaderBoardRankAttribute(): int
    {
        return $this->attributes['leaderboardRank'];
    }

    /**
     * Get if the Room is Public
     *
     * @return bool
     */
    public function getPublicRoomAttribute(): bool
    {
        return $this->attributes['is_public'] == 1;
    }

    /**
     * Get Room Category
     *
     * @return array
     */
    public function getCategoriesAttribute(): array
    {
        return [str_replace('}', '', str_replace('${', '', FlatCat::find($this->attributes['category'])))];
    }
}
