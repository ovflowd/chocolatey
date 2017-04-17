<?php

namespace App\Models;

/**
 * Class Voucher.
 */
class Voucher extends ChocolateyModel
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
    protected $table = 'vouchers';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
