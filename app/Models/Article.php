<?php

namespace App\Models;

/**
 * Class Article
 * @property string description
 * @property int title
 * @property string content
 * @property int author
 * @property string thumbnailUrl
 * @property string categories
 * @property string imageUrl
 * @package App\Models
 */
class Article extends AzureModel
{
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
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->author = $author;
        $this->categories = $categories;
        $this->imageUrl = $imageUrl;
        $this->thumbnailUrl = $thumbnailUrl;

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
