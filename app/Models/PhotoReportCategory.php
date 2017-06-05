<?php

namespace App\Models;

/**
 * Class PhotoReportCategory.
 */
class PhotoReportCategory extends ChocolateyModel
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
    protected $table = 'chocolatey_users_photos_reported_categories';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'reported_category';

    /**
     * Add a Report Category.
     *
     * @param int    $reportCategory
     * @param string $description
     *
     * @return PhotoReportCategory
     */
    public function store(int $reportCategory, string $description): PhotoReportCategory
    {
        $this->attributes['report_category'] = $reportCategory;
        $this->attributes['description'] = $description;
        $this->timestamps = false;

        $this->save();

        return $this;
    }
}
