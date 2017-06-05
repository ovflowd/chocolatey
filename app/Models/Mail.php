<?php

namespace App\Models;

/**
 * Class Mail.
 */
class Mail extends ChocolateyModel
{
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['used'];

    /**
     * Store a Mail Request.
     *
     * @param string $token
     * @param string $link
     * @param string $userMail
     *
     * @return Mail
     */
    public function store(string $token, string $link, string $userMail): Mail
    {
        $this->attributes['token'] = $token;
        $this->attributes['link'] = $link;
        $this->attributes['mail'] = $userMail;

        $this->save();

        return $this;
    }
}
