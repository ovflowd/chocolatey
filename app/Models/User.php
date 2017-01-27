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
    protected $table = 'users';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that will be mapped
     *
     * @var array
     */
    protected $maps = [
        'uniqueId' => 'id',
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
        'buildersClubMember',
        'sessionLoginId',
        'loginLogId',
        'identityVerified',
        'identityType',
        'trusted',
        'country',
        'traits',
        'uniqueId',
        'name',
        'figureString',
        'lastWebAccess',
        'creationTime',
        'email',
        'identityId',
        'emailVerified',
        'accountId',
        'memberSince'
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
        'id',
        'username',
        'mail',
        'account_created',
        'password',
        'mail_verified',
        'real_name',
        'account_day_of_birth',
        'last_online',
        'ip_current',
        'last_login',
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'traits' => 'string',
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
        $this->attributes['motto'] = Config::get('chocolatey.motto');
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
     * Set the Trait Attribute
     *
     * @param array $accountType
     */
    public function setTraitsAttribute(array $accountType)
    {
        $this->attributes['traits'] = $accountType;
    }

    /**
     * What is this field?
     *
     * @return array
     */
    public function getTraitsAttribute()
    {
        return !empty($this->attributes['traits'])
            ? $this->attributes['traits'] : ["USER"];
    }

    /**
     * Set Trusted Attribute
     * by a remote Address being in White list
     *
     * @param string $remoteAddress
     */
    public function setTrustedAttribute($remoteAddress)
    {
        $this->attributes['trusted'] = UserSecurity::where('user_id', $this->attributes['id'])->count() == 0 ?
            true : in_array($remoteAddress, UserSecurity::where('user_id', $this->attributes['id'])
                ->first()->trustedDevices);
    }

    /**
     * We don't care about this?
     *
     * @return bool
     */
    public function getTrustedAttribute()
    {
        return array_key_exists('trusted', $this->attributes) ? $this->attributes['trusted'] : true;
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
     * Get the Builders Club Attribute
     * In a Retro Habbo everyone is BC, yeah?
     *
     * @return bool
     */
    public function getBuildersClubMemberAttribute()
    {
        return true;
    }

    /**
     * Get GTimestamp in Habbo Currency
     *
     * @return false|string
     */
    public function getAccountCreatedAttribute()
    {
        return date("Y-m-d", $this->attributes['account_created'])
            . 'T' . date("H:i:s.ZZZZ+ZZZZ", $this->attributes['account_created']);
    }

    /**
     * Get GTimestamp in Habbo Currency
     *
     * @return false|string
     */
    public function getMemberSinceAttribute()
    {
        return date("Y-m-d", $this->attributes['account_created'])
            . 'T' . date("H:i:s.ZZZZ+ZZZZ", $this->attributes['account_created']);
    }

    /**
     * Get GTimestamp in Habbo Currency
     *
     * @return false|string
     */
    public function getLastLoginAttribute()
    {
        return date("Y-m-d", $this->attributes['last_login'])
            . 'T' . date("H:i:s.ZZZZ+ZZZZ", $this->attributes['last_login']);
    }

    /**
     * Get E-Mail Verified Attribute
     *
     * @return bool
     */
    public function getMailVerifiedAttribute()
    {
        return $this->attributes['mail_verified'] == 1;
    }
}
