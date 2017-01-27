<?php

namespace App\Models;

/**
 * Class UserSecurity
 * @package App\Models
 */
class UserSecurity extends AzureModel
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
    protected $table = 'chocolatey_users_security';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'trustedDevices'
    ];

    /**
     * Get Trusted Devices
     *
     * @return mixed
     */
    public function getTrustedDevicesAttribute()
    {
        $deviceAddresses = [];

        foreach (TrustedDevice::where('user_id', $this->attributes['user_id'])->get() as $device)
            $deviceAddresses[] = $device->ip_address;

        return $deviceAddresses;
    }

    /**
     * Store a new User Security Metadata
     *
     * @param int $userId
     * @param int $firstQuestion
     * @param int $secondQuestion
     * @param string $firstAnswer
     * @param string $secondAnswer
     * @return $this
     */
    public function store($userId, $firstQuestion, $secondQuestion, $firstAnswer, $secondAnswer)
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['firstQuestion'] = $firstQuestion;
        $this->attributes['secondQuestion'] = $secondQuestion;
        $this->attributes['firstAnswer'] = $firstAnswer;
        $this->attributes['secondAnswer'] = $secondAnswer;

        return $this;
    }
}
