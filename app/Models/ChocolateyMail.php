<?php

namespace App\Models;

/**
 * Class ChocolateyMail.
 */
class ChocolateyMail extends ChocolateyModel
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
    protected $table = 'chocolatey_users_mail_requests';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store a new Azure Id Account.
     *
     * @param string $userMail
     * @param int    $userId
     *
     * @return ChocolateyMail
     */
    public function store(int $userId, string $userMail): ChocolateyMail
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['mail'] = $userMail;

        $this->save();

        return $this;
    }
}
