<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Auth\Authorizable;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class User
 * @package App\Models
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Eloquence, Mappable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that will be mapped
     *
     * @var array
     */
    protected $maps = [
        'id' => 'uniqueId',
        'name' => 'username',
        'figureString' => 'look',
        'lastWebAccess' => 'last_login',
        'creationTime' => 'account_created',
        'email' => 'mail',
        'identityId' => 'id',
        'emailVerified' => 'mail_verified',
        'accountId' => 'id'
    ];

    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'habboClubMember',
        'sessionLoginId',
        'loginLogId',
        'identityVerified',
        'identityType',
        'trusted',
        'traits',
        'country'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'real_name',
        'account_day_of_birth',
        'last_online',
        'ip_current',
        'ip_register',
        'auth_ticket',
        'home_room',
        'points',
        'online',
        'pixels',
        'credits',
        'gender',
        'points',
        'rank'
    ];

    /**
     * Store an User on the Database
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return $this
     */
    public function store($username, $password, $email)
    {
        $this->attributes['username'] = $username;
        $this->attributes['password'] = md5($password);
        $this->attributes['mail'] = $email;
        $this->attributes['account_created'] = time();
        $this->attributes['motto'] = Config::get('azure.motto');
        $this->attributes['auth_ticket'] = '';

        return $this;
    }

    /**
     * Get Current User Country
     * @TODO: Implement this in a proper way
     *
     * @return string
     */
    public function getCountryAttribute()
    {
        return 'com';
    }

    /**
     * What is this field?
     *
     * @return array
     */
    public function getTraitsAttribute()
    {
        return ["NONE"];
    }

    /**
     * We don't care about this?
     *
     * @return bool
     */
    public function getTrustedAttribute()
    {
        return true;
    }

    /**
     * What is this field?
     *
     * @return string
     */
    public function getIdentityTypeAttribute()
    {
        return 'HABBO';
    }

    /**
     * We don't care about this, every user is trusted.
     *
     * @return bool
     */
    public function getIdentityVerifiedAttribute()
    {
        return true;
    }

    /**
     * We don't care about this
     *
     * @return int
     */
    public function getLoginLogIdAttribute()
    {
        return 1;
    }

    /**
     * We don't care about this
     *
     * @return int
     */
    public function getSessionLoginIdAttribute()
    {
        return 1;
    }

    /**
     * Get the HabboClub Attribute
     * In a Retro Habbo everyone is HC, yeah?
     *
     * @return bool
     */
    public function getHabboClubMemberAttribute()
    {
        return true;
    }

    /**
     * Get GTimestamp in Habbo Currency
     *
     * @return false|string
     */
    public function getCreationTimeAttribute()
    {
        return date("yyyy-MM-dd'T'HH:mm:ss.SSSZ", $this->attributes['creationTime']);
    }

    /**
     * Get GTimestamp in Habbo Currency
     *
     * @return false|string
     */
    public function getLastWebAccessAttribute()
    {
        return date("yyyy-MM-dd'T'HH:mm:ss.SSSZ", $this->attributes['lastWebAccess']);
    }
}
