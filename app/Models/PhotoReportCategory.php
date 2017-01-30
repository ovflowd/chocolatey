<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class PhotoReportCategory
 * @package App\Models
 */
class PhotoReportCategory extends ChocolateyModel
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
    protected $table = 'chocolatey_users_photos_reported_categories';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'reported_category';

    /**
     * Add a Report Category
     *
     * @param int $reportCategory
     * @param string $description
     * @return PhotoReportCategory
     */
    public function store($reportCategory, $description): PhotoReportCategory
    {
        if (PhotoReportCategory::query()->where('report_category', $reportCategory)->count() > 0)
            throw new InvalidMutatorException("Already Exists a Category with this Id");

        $this->attributes['report_category'] = $reportCategory;
        $this->attributes['description'] = $description;

        return $this;
    }
}
