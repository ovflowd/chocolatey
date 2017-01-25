<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AzureId
 * @package App\Models
 */
class AzureId extends AzureModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'azure_users_id';

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'relatedAzureId',
        'relatedAccounts'
    ];

    /**
     * Store a new Azure Id Account
     *
     * @param string $userMail
     * @param int $userId
     * @return $this
     * @throws ErrorException
     */
    public function store($userMail, $userId)
    {
        if (AzureId::query()->where('user_id', $userId)->count() > 0)
            throw new ErrorException("An User with this Id already registered.");

        $this->attributes['user_id'] = $userId;
        $this->attributes['mail'] = $userMail;

        return $this;
    }

    /**
     * Get All Accounts related with this E-mail
     *
     * @return Collection|static[]
     */
    public function getRelatedAccountsAttribute()
    {
        return User::query()->where('mail', $this->attributes['mail'])->get();
    }

    /**
     * Get All AzureId with this E-mail
     *
     * @return Collection|static[]
     */
    public function getRelatedAzureIdAttribute()
    {
        return AzureId::query()->where('mail', $this->attributes['mail'])->get();
    }
}
