<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Room.
 *
 * @property int id
 */
class Room extends Model
{
    use Eloquence, Mappable;

    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Leader Board Rank.
     *
     * @var int
     */
    public $leaderboardRank = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rooms';

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
    protected $maps = ['uniqueId' => 'id', 'ownerName' => 'owner_name', 'ownerUniqueId' => 'owner_id', 'doorMode' => 'state',
        'leaderboardValue'        => 'score', 'maximumVisitors' => 'users_max', 'habboGroupId' => 'guild_id', 'rating' => 'score', ];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['uniqueId', 'leaderboardRank', 'thumbnailUrl', 'imageUrl', 'leaderboardValue', 'doorMode', 'maximumVisitors',
        'publicRoom', 'ownerUniqueId', 'ownerName', 'showOwnerName', 'categories', 'rating', ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['owner_name', 'owner_id', 'is_public', 'state', 'password', 'model', 'users', 'users_max', 'guild_id', 'category', 'score', 'paper_floor', 'paper_wall',
        'paper_landscape', 'thickness_wall', 'wall_height', 'thickness_floor', 'moodlight_data', 'is_staff_picked', 'allow_other_pets', 'allow_other_pets_eat', 'allow_walkthrough',
        'allow_hidewall', 'chat_mode', 'chat_weight', 'chat_speed', 'chat_hearing_distance', 'chat_protection', 'override_model', 'who_can_mute', 'who_can_kick', 'who_can_ban', 'poll_id',
        'roller_speed', 'promoted', 'trade_mode', 'move_diagonally', ];

    /**
     * Stores a new Room.
     *
     * @param string $roomName
     * @param string $description
     * @param string $model
     * @param int    $maxUsers
     * @param int    $roomCategory
     * @param int    $floorPaper
     * @param int    $wallPaper
     * @param float  $landscapePaper
     * @param int    $ownerId
     * @param string $ownerName
     *
     * @return Room
     */
    public function store(string $roomName, string $description, string $model, int $maxUsers, int $roomCategory, int $floorPaper, int $wallPaper, float $landscapePaper, int $ownerId, string $ownerName)
    {
        $this->attributes['name'] = $roomName;
        $this->attributes['description'] = $description;
        $this->attributes['model'] = $model;
        $this->attributes['users_max'] = $maxUsers;
        $this->attributes['category'] = $roomCategory;
        $this->attributes['paper_floor'] = $floorPaper;
        $this->attributes['paper_wall'] = $wallPaper;
        $this->attributes['paper_landscape'] = $landscapePaper;
        $this->attributes['thickness_wall'] = 0;
        $this->attributes['wall_height'] = -1;
        $this->attributes['thickness_floor'] = 0;
        $this->attributes['owner_id'] = $ownerId;
        $this->attributes['owner_name'] = $ownerName;
        $this->timestamps = false;

        $this->save();

        return $this;
    }

    /**
     * Get Room Tags.
     *
     * @return array
     */
    public function getTagsAttribute(): array
    {
        return array_filter(explode(';', $this->attributes['tags']), function ($element) {
            return !empty($element);
        });
    }

    /**
     * Get Image Url.
     *
     * @TODO: Get Real Full Room Image
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return "//arcturus.wf/full_{$this->attributes['id']}.png";
    }

    /**
     * Get Thumbnail Url.
     *
     * @return string
     */
    public function getThumbnailUrlAttribute(): string
    {
        $userName = Config::get('chocolatey.arcturus');

        return "//arcturus.wf/camera/{$userName}/thumbnail_{$this->attributes['id']}.png";
    }

    /**
     * Return if need show Owner Name.
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
     * Set a Leader Board Position.
     *
     * @param int $roomPosition
     */
    public function setLeaderBoardRankAttribute(int $roomPosition = 1)
    {
        $this->leaderboardRank = $roomPosition;
    }

    /**
     * Get Leader Board Rank.
     *
     * @return int
     */
    public function getLeaderBoardRankAttribute(): int
    {
        return $this->leaderboardRank;
    }

    /**
     * Get if the Room is Public.
     *
     * @return bool
     */
    public function getPublicRoomAttribute(): bool
    {
        return $this->attributes['is_public'] == 1;
    }

    /**
     * Get Room Category.
     *
     * @return array
     */
    public function getCategoriesAttribute(): array
    {
        return [str_replace('}', '', str_replace('${', '', FlatCat::find($this->attributes['category'])->caption))];
    }
}
