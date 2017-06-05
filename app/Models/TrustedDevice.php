<?php

namespace App\Models;

/**
 * Class TrustedDevice.
 */
class TrustedDevice extends ChocolateyModel
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
    protected $table = 'chocolatey_users_security_trusted';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * Store a new TrustedDevice.
     *
     * @param int    $userId
     * @param string $ipAddress
     *
     * @return TrustedDevice
     */
    public function store(int $userId, string $ipAddress): TrustedDevice
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['ip_address'] = $ipAddress;
        $this->timestamps = false;

        $this->save();

        return $this;
    }
}
