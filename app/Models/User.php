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
 * Class User.
 *
 * @property string trusted
 * @property int uniqueId
 * @property string figureString
 * @property string name
 * @property string motto
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Eloquence, Mappable;

    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * User Traits.
     *
     * @var array
     */
    public $traits = ['USER'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that will be mapped.
     *
     * @var array
     */
    protected $maps = ['uniqueId' => 'id', 'name' => 'username', 'figureString' => 'look', 'lastWebAccess' => 'last_login', 'creationTime' => 'account_created', 'email' => 'mail', 'identityId' => 'id', 'accountId' => 'id'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['habboClubMember', 'buildersClubMember', 'sessionLoginId', 'loginLogId', 'identityVerified', 'identityType', 'trusted', 'country', 'traits',
        'uniqueId', 'name', 'figureString', 'lastWebAccess', 'creationTime', 'email', 'identityId', 'emailVerified', 'accountId', 'memberSince', 'isBanned', 'banDetails', 'isStaff', ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mail', 'id', 'username', 'auth_ticket', 'last_login', 'ip_current', 'ip_register', 'mail_verified', 'account_day_of_birth',
        'real_name', 'look', 'gender', 'credits', 'pixels', 'home_room', ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'username', 'mail', 'account_created', 'password', 'mail_verified', 'real_name', 'account_day_of_birth',
        'last_online', 'last_login', 'ip_register', 'auth_ticket', 'home_room', 'points', 'look', 'ip_current', 'online', 'pixels', 'credits', 'gender', 'points', 'rank', ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['traits' => 'string'];

    /**
     * Store an User on the Database.
     *
     * @param string $username
     * @param string $email
     * @param string $address
     * @param bool   $newUser
     *
     * @return User
     */
    public function store(string $username, string $email, string $address = '', bool $newUser = true): User
    {
        $this->attributes['username'] = $username;
        $this->attributes['mail'] = $email;

        $this->attributes['motto'] = Config::get('chocolatey.motto');
        $this->attributes['look'] = Config::get('chocolatey.figure');
        $this->attributes['auth_ticket'] = '';

        $this->attributes['password'] = hash(Config::get('chocolatey.security.hash'), openssl_random_pseudo_bytes(50));
        $this->attributes['account_created'] = time();

        $this->attributes['ip_current'] = $address;

        $this->traits = $newUser ? ['NEW_USER', 'USER'] : ['USER'];

        $this->timestamps = false;

        $this->save();
        $this->createData();

        return $this;
    }

    /**
     * Store an User Alias Set on Database.
     */
    public function createData()
    {
        (new UserPreferences())->store($this->attributes['id']);
    }

    /**
     * Get Is User is Banned.
     *
     * @return bool
     */
    public function getIsBannedAttribute(): bool
    {
        $ban = Ban::where('user_id', $this->attributes['id'])->first();

        if ($ban == null) {
            return false;
        }

        return $ban->ban_expire >= time();
    }

    /**
     * Check if Is Staff.
     *
     * @return bool
     */
    public function getIsStaffAttribute(): bool
    {
        return array_key_exists('rank', $this->attributes) ? $this->attributes['rank'] >= 5 : false;
    }

    /**
     * Get Ban Details.
     *
     * @return Ban
     */
    public function getBanDetailsAttribute()
    {
        return Ban::where('user_id', $this->attributes['id'])->first();
    }

    /**
     * Get Current User Country.
     *
     * @TODO: Implement this in a proper way
     *
     * @return string
     */
    public function getCountryAttribute(): string
    {
        return 'com';
    }

    /**
     * Set the Trait Attribute.
     *
     * @param array $accountType
     */
    public function setTraitsAttribute(array $accountType)
    {
        $this->traits = $accountType;
    }

    /**
     * What is this field?
     *
     * @return array
     */
    public function getTraitsAttribute(): array
    {
        if (array_key_exists('rank', $this->attributes) && $this->attributes['rank'] >= config('chocolatey.minRank')) {
            return ['STAFF'];
        }

        return $this->traits;
    }

    /**
     * We don't care about this?
     *
     * @return bool
     */
    public function getTrustedAttribute(): bool
    {
        if (UserSecurity::find($this->attributes['id']) == null) {
            return true;
        }

        return in_array($this->attributes['ip_current'],
            UserSecurity::find($this->attributes['id'])->trustedDevices);
    }

    /**
     * What is this field?
     *
     * @return string
     */
    public function getIdentityTypeAttribute(): string
    {
        return 'HABBO';
    }

    /**
     * We don't care about this, every user is trusted.
     *
     * @return bool
     */
    public function getIdentityVerifiedAttribute(): bool
    {
        return true;
    }

    /**
     * We don't care about this.
     *
     * @return int
     */
    public function getLoginLogIdAttribute(): int
    {
        return 1;
    }

    /**
     * We don't care about this.
     *
     * @return int
     */
    public function getSessionLoginIdAttribute(): int
    {
        return 1;
    }

    /**
     * Get the HabboClub Attribute
     * In a Retro Habbo everyone is HC, yeah?
     *
     * @WARNING: This is used for Advertisement
     *
     * @return bool
     */
    public function getHabboClubMemberAttribute(): bool
    {
        return Config::get('chocolatey.ads.enabled') == false;
    }

    /**
     * Get the Builders Club Attribute
     * In a Retro Habbo everyone is BC, yeah?
     *
     * @WARNING: This is used for Advertisement
     *
     * @return bool
     */
    public function getBuildersClubMemberAttribute(): bool
    {
        return Config::get('chocolatey.ads.enabled') == false;
    }

    /**
     * Get GTimestamp in Habbo UserCurrency.
     *
     * @return string
     */
    public function getAccountCreatedAttribute(): string
    {
        $accountCreated = $this->attributes['account_created'] ?? time();

        return date('Y-m-d', $accountCreated).'T'.date('H:i:s.ZZZZ+ZZZZ', $accountCreated);
    }

    /**
     * Get GTimestamp in Habbo UserCurrency.
     *
     * @return string
     */
    public function getMemberSinceAttribute(): string
    {
        $accountCreated = $this->attributes['account_created'] ?? time();

        return date('Y-m-d', $accountCreated).'T'.date('H:i:s.ZZZZ+ZZZZ', $accountCreated);
    }

    /**
     * Retrieve User Figure String.
     *
     * @return string
     */
    public function getFigureStringAttribute(): string
    {
        return $this->attributes['look'] ?? 'hr-115-42.hd-195-19.ch-3030-82.lg-275-1408.fa-1201.ca-1804-64';
    }

    /**
     * Get GTimestamp in Habbo UserCurrency.
     *
     * @return false|string
     */
    public function getLastLoginAttribute(): string
    {
        $lastLogin = $this->attributes['last_login'] ?? time();

        return date('Y-m-d', $lastLogin).'T'.date('H:i:s.ZZZZ+ZZZZ', $lastLogin);
    }

    /**
     * Get E-Mail Verified Attribute.
     *
     * @return bool
     */
    public function getEmailVerifiedAttribute(): bool
    {
        return $this->getChocolateyId()->mail_verified ?? false;
    }

    /**
     * Get Account Chocolatey Id.
     *
     * @return ChocolateyId
     */
    public function getChocolateyId()
    {
        return ChocolateyId::find($this->attributes['mail']);
    }
}
