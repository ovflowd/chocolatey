<?php

namespace App\Models;

/**
 * Class Permissions.
 */
class Permissions extends ChocolateyModel
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
    protected $table = 'permissions';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
