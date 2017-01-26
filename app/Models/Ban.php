<?php

namespace App\Models;

/**
 * Class Ban
 * @package App\Models
 */
class Ban extends AzureModel
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
    protected $table = 'bans';

    /**
     * Store an User Ban
     *
     * @param int $userId
     * @param int $userStaffId
     * @param string $banReason
     * @param string $banType (Account, IP, Machine, Super)
     * @param int $banExpire
     * @param string $ipAddress
     * @param string $machineId
     * @return $this
     */
    public function store($userId, $userStaffId, $banReason, $banType = 'account', $banExpire = 0, $ipAddress = '', $machineId = '')
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['user_staff_id'] = $userStaffId;
        $this->attributes['ban_reason'] = $banReason;
        $this->attributes['ban_expire'] = $banExpire;
        $this->attributes['timestamp'] = time();
        $this->attributes['ip'] = $ipAddress;
        $this->attributes['type'] = $banType;
        $this->attributes['machine_id'] = $machineId;

        return $this;
    }
}
