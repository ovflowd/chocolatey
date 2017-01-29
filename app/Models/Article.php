<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Article
 * @package App\Models
 */
class Article extends ChocolateyModel
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
    protected $table = 'chocolatey_articles';

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
        'updatedAt' => 'updated_at',
        'createdAt' => 'created_at',
    ];
    
    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'updatedAt',
        'createdAt',
    ];
    
        /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at'
    ];

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
