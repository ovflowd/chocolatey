<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class PhotoReport
 * @property int photo_id
 * @property int reason_id
 * @property int reported_by
 * @property int approved
 * @package App\Models
 */
class PhotoReport extends AzureModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'azure_user_photos_reported';

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
        $this->photo_id = $photoId;
        $this->reason_id = $reasonId;
        $this->reported_by = $reportedBy;
        $this->approved = 0;

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
