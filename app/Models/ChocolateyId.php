<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ChocolateyId
 * @package App\Models
 */
class ChocolateyId extends ChocolateyModel
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
    protected $table = 'chocolatey_users_id';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = array('relatedAzureId', 'relatedAccounts');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('mail');

    /**
     * Store a new Azure Id Account.
     *
     * @param int $userId
     * @param string $userMail
     *
     * @throws ErrorException
     *
     * @return ChocolateyId
     */
    public function store(int $userId, string $userMail): ChocolateyId
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
        return User::query()->where('mail', $this->attributes['mail'])->get();
    }

    /**
     * Get All AzureId with this E-mail.
     *
     * @return Collection|static[]
     */
    public function getRelatedAzureIdAttribute()
    {
        return self::query()->where('mail', $this->attributes['mail'])->get();
    }
}
