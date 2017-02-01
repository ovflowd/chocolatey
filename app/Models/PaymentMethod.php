<?php

namespace App\Models;

use stdClass;

/**
 * Class PaymentMethod
 * @package App\Models
 */
class PaymentMethod extends ChocolateyModel
{
    /**
     * Disable Timestamps
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * Purchase Params
     *
     * @var array
     */
    public $purchaseParams = null;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_shop_payment_methods';
    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * The Appender(s) of the Model
     *
     * @var array
     */
    protected $appends = [
        'disclaimerRequired',
        'premiumSms',
        'purchaseParams',
        'requestPath',
        'smallPrint'
    ];

    /**
     * Store an Shop Country
     * @param string $methodName
     * @param string $code
     * @param string $buttonImageUrl
     * @param string $buttonText
     * @return PaymentMethod
     */
    public function store(string $methodName, string $code, string $buttonImageUrl, string $buttonText): PaymentMethod
    {
        $this->attributes['name'] = $methodName;
        $this->attributes['buttonLogoUrl'] = $buttonImageUrl;
        $this->attributes['buttonText'] = $buttonText;
        $this->attributes['localizationKey'] = $code;

        return $this;
    }

    /**
     * Get Disclaimer Required Attribute
     *
     * @return bool
     */
    public function getDisclaimerRequiredAttribute(): bool
    {
        return false;
    }

    /**
     * Get Premium SMS Attribute
     *
     * @return bool
     */
    public function getPremiumSmsAttribute(): bool
    {
        return false;
    }

    /**
     * Get Request Path Attribute
     *
     * @return string
     */
    public function getRequestPathAttribute(): string
    {
        return 'online';
    }

    /**
     * Get the Purchase Params
     *
     * @return array
     */
    public function getPurchaseParamsAttribute()
    {
        return $this->purchaseParams;
    }

    /**
     * Set Purchase Params
     * @param array $parameters
     */
    public function setPurchaseParams(array $parameters)
    {
        $params = new stdClass();
        $params->countryId = $parameters[0];
        $params->pricePointId = $parameters[1];
        $params->paymentMethodId = $this->attributes['id'];

        $this->purchaseParams = $params;
    }

    /**
     * Get Small Print Attribute
     *
     * @return string
     */
    public function getSmallPrintAttribute(): string
    {
        return 'null';
    }
}
