<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class PhotoReportCategory
 * @property int report_category
 * @property string description
 * @package App\Models
 */
class PhotoReportCategory extends AzureModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'azure_user_photos_reported_categories';

    /**
     * Add a Report Category
     *
     * @param int $reportCategory
     * @param string $description
     * @return $this
     */
    public function store($reportCategory, $description)
    {
        if (PhotoReportCategory::query()->where('report_category', $reportCategory)->count() > 0)
            throw new InvalidMutatorException("Already Exists a Category with this Id");

        $this->report_category = $reportCategory;
        $this->description = $description;

        return $this;
    }
}
