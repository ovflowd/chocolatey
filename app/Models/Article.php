<?php

namespace App\Models;

/**
 * Class Article
 * @package App\Models
 */
class Article extends AzureModel
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
    protected $table = 'azure_articles';

    /**
     * Store a new CMS Article
     *
     * @param int $title
     * @param string $description
     * @param string $content
     * @param int $author
     * @param string $categories
     * @param string $imageUrl
     * @param string $thumbnailUrl
     * @return $this
     */
    public function store($title, $description, $content, $author, $categories, $imageUrl, $thumbnailUrl)
    {
        $this->attributes['title'] = $title;
        $this->attributes['description'] = $description;
        $this->attributes['content'] = $content;
        $this->attributes['author'] = $author;
        $this->attributes['categories'] = $categories;
        $this->attributes['imageUrl'] = $imageUrl;
        $this->attributes['thumbnailUrl'] = $thumbnailUrl;

        return $this;
    }

    /**
     * Get All Article Categories from the Article
     *
     * @return array
     */
    public function getCategoriesAttribute()
    {
        $categories = [];

        foreach (explode(',', $this->attributes['categories']) as $articleCategory)
            $categories[] = ArticleCategory::query()->where('link', $articleCategory)->first();

        return $categories;
    }
}
