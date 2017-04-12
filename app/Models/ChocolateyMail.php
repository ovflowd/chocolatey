<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Collection;

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
     * @param int $userId
     *
     * @throws ErrorException
     *
     * @return ChocolateyMail
     */
    public function store(int $userId, string $userMail): ChocolateyMail
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['mail'] = $userMail;

        return $this;
    }

    /**
     * Get All Accounts related with this E-mail.
     *
     * @return Collection|static[]
     */
    public function getRelatedAccountsAttribute()
    {
        return User::where('mail', $this->attributes['mail'])->get();
    }

    /**
     * Get All AzureId with this E-mail.
     *
     * @return Collection|static[]
     */
    public function getRelatedAzureIdAttribute()
    {
        return ChocolateyId::where('mail', $this->attributes['mail'])->get();
    }
}
