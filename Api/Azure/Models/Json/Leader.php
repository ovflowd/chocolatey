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
 * Class Leader
 * @package Azure\Models\Json
 */
class Leader extends JsonType
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
	 public $id, $uniqueId, $leaderboardRank, $leaderboardValue, $name, $description, $ownerName, $ownerUniqueId, $thumbnailUrl, $imageUrl, $rating, $publicRoom = false, $doorMode = 'open', $tags = []; 
	 
	/**
	 * function construct
	 * create a model for the leaderboards
	 */
	function __construct($roomId, $rank, $leaderId, $roomName, $roomDesc, $ownerName, $ownerId, $rating, $tags, $official)
	{
		$this->id               = $roomId;
		$this->uniqueId			= $roomId;
		$this->leaderboardRank	= $rank;
		$this->leaderboardValue	= $leaderId;
		$this->name				= $roomName;
		$this->description		= $roomDesc;
		$this->ownerName		= $ownerName;
		$this->ownerUniqueId	= $ownerId;
		$this->thumbnailUrl		= 'https://habbo-stories-content.s3.amazonaws.com/navigator-thumbnail/hhus/' . $roomId . '.png'; //Static
		$this->imageUrl 		= 'https://habbo-stories-content.s3.amazonaws.com/fullroom-photo/hhus/' . $roomId . '.png'; //Static
		$this->rating			= $rating;
		$this->publicRoom		= $official;
		$this->tags				= $tags;
	}
}