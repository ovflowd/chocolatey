<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Models\Json;

use Azure\Types\Json as JsonType;

/**
 * Class Rooms
 * @package Azure\Models\Json
 */
class Rooms extends JsonType
{

    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $id, $name, $description, $creationTime = '00', $habboGroupId = 0, $maxiumVisitors, $tags = [], $showOwnerName = true, $ownerName, $ownerUniqueId, $thumbnailUrl, $imageUrl, $categories = [], $publicRoom = false, $doorMode = 'open', $uniqueId, $rating;

    /**
     * function construct
     * create a model for the leaderboards
     */
    function __construct($roomId, $roomName, $roomDesc, $maxVisitors, $ownerName, $ownerId, $rating, $tags, $official)
    {
        $this->id = $roomId;
        $this->uniqueId = $roomId;
        $this->name = $roomName;
        $this->description = $roomDesc;
        $this->ownerName = $ownerName;
        $this->ownerUniqueId = $ownerId;
        $this->maximumVisitors = $maxVisitors;
        $this->thumbnailUrl = 'https://habbo-stories-content.s3.amazonaws.com/navigator-thumbnail/hhus/' . $roomId . '.png'; //Static
        $this->imageUrl = 'https://habbo-stories-content.s3.amazonaws.com/fullroom-photo/hhus/' . $roomId . '.png'; //Static
        $this->rating = $rating;
        $this->publicRoom = $official;
        $this->rating = $rating;
        $this->tags = $tags;
    }
}