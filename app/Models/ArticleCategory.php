<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Class ArticleCategory
 * @package App\Models
 */
class ArticleCategory extends ChocolateyModel
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
    protected $table = 'chocolatey_articles_categories';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'link';

    /**
     * Store a New Article Category
     *
     * @param string $link
     * @param string $translate
     * @return $this
     */
    public function store($link, $translate)
    {
        if (ArticleCategory::query()->where('link', $link)->count() > 0)
            throw new InvalidArgumentException("This Link actually Exists on the Database");

        $this->attributes['link'] = $link;
        $this->attributes['translate'] = $translate;

        return $this;
    }
}
