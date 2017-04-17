<?php

namespace App\Models;

/**
 * Class PaymentCategory
 * @package App\Models
 */
class PaymentCategory extends ChocolateyModel
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
    protected $table = 'chocolatey_shop_payment_categories';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store an Shop Country.
     *
     * @param string $paymentName
     * @return PaymentCategory
     */
    public function store(string $paymentName): PaymentCategory
    {
        $this->attributes['payment_type'] = $paymentName;

        $this->save();

        return $this;
    }
}
