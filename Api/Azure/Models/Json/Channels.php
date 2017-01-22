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
 * Class Badge
 * @package Azure\Models\Json
 */
class Channels extends JsonType
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
	public $_id, $slug, $description, $titleKey, $publicationDate = "2012-12-31T22:00:00.000Z", $competitionEnd = "2096-01-01T00:00:00.000Z", $contentTag, $assetUrl, $title, $originIds = ['hhus', 'hhes', 'hhbr'];

	/**
	 * function construct
	 * create a model for the channels instance
	 * @param string $user_id
	 * @param string $title
	 * @param string $description
	 * @param string $tag
	 * @param string $title_key
	 * @param string $image
	 * @param string $url
	 */
	function __construct($user_id = '', $title = '', $description = '', $tag = '', $title_key = '', $image = '', $url = '')
	{
		$this->_id         = $user_id;
		$this->title       = $title;
		$this->description = $description;
		$this->contentTag  = $tag;
		$this->assetUrl    = $image;
		$this->slug        = $url;
		$this->titleKey    = $title_key;
	}
}