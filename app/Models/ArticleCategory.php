<?php

namespace App\Models;

/**
 * Class ArticleCategory.
 *
 * @property string name
 */
class ArticleCategory extends ChocolateyModel
{
    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Appenders Array.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_articles_categories';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'link';

    /**
     * Get the Original Link Attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes['link'];
    }

    /**
     * Store a New Article Category.
     *
     * @param string $link
     * @param string $translate
     *
     * @return $this
     */
    public function store(string $link, string $translate)
    {
        $this->attributes['link'] = $link;
        $this->attributes['translate'] = $translate;
        $this->timestamps = false;

        $this->save();

        return $this;
    }
}
