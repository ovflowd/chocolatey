<?php

namespace App\Models;

/**
 * Class UserSecurity
 * @package App\Models
 */
class UserSecurity extends AzureModel
{
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
    protected $table = 'azure_users_security';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * Store a new Azure Id Account
     * @param int $userId
     * @param int $firstQuestion
     * @param int $secondQuestion
     * @param string $firstAnswer
     * @param string $secondAnswer
     * @return $this
     */
    public function store($userId, $firstQuestion, $secondQuestion, $firstAnswer, $secondAnswer)
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['firstQuestion'] = $firstQuestion;
        $this->attributes['secondQuestion'] = $secondQuestion;
        $this->attributes['firstAnswer'] = $firstAnswer;
        $this->attributes['secondAnswer'] = $secondAnswer;

        return $this;
    }
}
