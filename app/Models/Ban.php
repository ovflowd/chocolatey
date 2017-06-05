<?php

namespace App\Models;

/**
 * Class Ban.
 */
class Ban extends ChocolateyModel
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
    protected $table = 'bans';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store an User Ban.
     *
     * @param int    $userId
     * @param int    $userStaffId
     * @param string $banReason
     * @param string $banType     (Account, IP, Machine, Super)
     * @param int    $banExpire
     * @param string $ipAddress
     * @param string $machineId
     *
     * @return Ban
     */
    public function store(int $userId, int $userStaffId, string $banReason, $banType = 'account', $banExpire = 0, $ipAddress = '', $machineId = ''): Ban
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['user_staff_id'] = $userStaffId;
        $this->attributes['ban_reason'] = $banReason;
        $this->attributes['ban_expire'] = $banExpire;
        $this->attributes['timestamp'] = time();
        $this->attributes['ip'] = $ipAddress;
        $this->attributes['type'] = $banType;
        $this->attributes['machine_id'] = $machineId;
        $this->timestamps = false;

        $this->save();

        return $this;
    }

    /**
     * Get Ban Expire Attribute.
     *
     * @return string
     */
    public function getBanExpireAttribute(): string
    {
        return date('M/d/Y h:m A', $this->attributes['ban_expire']);
    }
}
