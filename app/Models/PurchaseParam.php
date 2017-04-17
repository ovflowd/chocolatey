<?php

namespace App\Models;

/**
 * Class PurchaseParam.
 */
class PurchaseParam
{
    /**
     * Country Id.
     *
     * @var int
     */
    public $countryId;

    /**
     * Price Point Id.
     *
     * @var int
     */
    public $pricePointId;

    /**
     * Payment Method Id.
     *
     * @var int
     */
    public $paymentMethodId;

    /**
     * Create a new Purchase Param.
     *
     * @param int $countryId
     * @param int $pricePointId
     * @param int $paymentMethodId
     */
    public function __construct(int $countryId, int $pricePointId, int $paymentMethodId)
    {
        $this->countryId = $countryId;
        $this->pricePointId = $pricePointId;
        $this->paymentMethodId = $paymentMethodId;
    }
}
