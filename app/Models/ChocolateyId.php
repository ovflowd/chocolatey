<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class ChocolateyId
 * @package App\Models
 *
 * @property boolean mail_verified
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
    protected $primaryKey = 'mail';

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = array('relatedAccounts');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('mail', 'password', 'last_logged_id', 'mail_verified');

    /**
     * Store a new Azure Id Account.
     *
     * @param string $userMail
     * @param string $userPassword
     * @return ChocolateyId
     */
    public function store(string $userMail, string $userPassword): ChocolateyId
    {
        $this->attributes['password'] = hash(Config::get('chocolatey.security.hash'), $userPassword);
        $this->attributes['mail'] = $userMail;

        $this->save();

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
}
