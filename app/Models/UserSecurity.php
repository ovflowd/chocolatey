<?php

namespace App\Models;

/**
 * Class UserSecurity.
 */
class UserSecurity extends ChocolateyModel
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
    protected $table = 'chocolatey_users_security';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = [
        'trustedDevices',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'firstQuestion', 'secondQuestion', 'firstAnswer', 'secondAnswer'];

    /**
     * Get Trusted Devices.
     *
     * @return array
     */
    public function getTrustedDevicesAttribute(): array
    {
        return TrustedDevice::where('user_id', $this->attributes['user_id'])->get(['ip_address'])->map(function ($item) {
            return $item->ip_address;
        })->toArray();
    }

    /**
     * Store a new User Security Metadata.
     *
     * @param int    $userId
     * @param int    $firstQuestion
     * @param int    $secondQuestion
     * @param string $firstAnswer
     * @param string $secondAnswer
     *
     * @return UserSecurity
     */
    public function store(int $userId, int $firstQuestion, int $secondQuestion, string $firstAnswer, string $secondAnswer): UserSecurity
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['firstQuestion'] = $firstQuestion;
        $this->attributes['secondQuestion'] = $secondQuestion;
        $this->attributes['firstAnswer'] = $firstAnswer;
        $this->attributes['secondAnswer'] = $secondAnswer;
        $this->timestamps = false;

        return $this;
    }
}
