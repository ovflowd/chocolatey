<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

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

    /**
     * Store Function.
     *
     * A Voucher can't be inserted by the CMS.
     * Only by the Emulator
     */
    public function store()
    {
        throw new InvalidMutatorException('You cannot store a Voucher by Chocolatey. Voucher need be created from the Server.');
    }
}
