<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class PhotoReport
 * @package App\Models
 */
class PhotoReport extends AzureModel
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
    protected $table = 'chocolatey_users_photos_reported';
    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'reason_category'
    ];

    /**
     * Store a new Photo Report
     *
     * @param int $photoId
     * @param int $reasonId
     * @param int $reportedBy
     * @return $this
     */
    public function store($photoId, $reasonId, $reportedBy)
    {
        $this->attributes['photo_id'] = $photoId;
        $this->attributes['reason_id'] = $reasonId;
        $this->attributes['reported_by'] = $reportedBy;
        $this->attributes['approved'] = 0;

        return $this;
    }

    /**
     * Get the Report Category Content
     *
     * @return Builder
     */
    public function getReasonCategoryAttribute()
    {
        return PhotoReportCategory::query()->where('report_category', $this->attributes['reason_id'])->first();
    }
}
