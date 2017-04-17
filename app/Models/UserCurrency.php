<?php

namespace App\Models;

/**
 * Class UserCurrency.
 */
class UserCurrency extends ChocolateyModel
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
    protected $table = 'users_currency';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
