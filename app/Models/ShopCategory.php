<?php

namespace App\Models;

/**
 * Class ShopCategory.
 */
class ShopCategory extends ChocolateyModel
{
    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_shop_items_categories';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'category_name';

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['category'];

    /**
     * Store an Shop Country.
     *
     * @param string $categoryName
     *
     * @return ShopCategory
     */
    public function store(string $categoryName): ShopCategory
    {
        $this->attributes['category_name'] = $categoryName;
        $this->timestamps = false;

        $this->save();

        return $this;
    }

    /**
     * Get Shop Category Name.
     *
     * @return string
     */
    public function getCategoryAttribute(): string
    {
        return $this->attributes['category_name'];
    }
}
