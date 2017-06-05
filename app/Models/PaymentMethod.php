<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class PaymentMethod.
 */
class PaymentMethod extends ChocolateyModel
{
    use Eloquence, Mappable;

    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Purchase Params.
     *
     * @var PurchaseParam
     */
    public $purchaseParams = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_shop_payment_methods';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['disclaimerRequired', 'premiumSms', 'purchaseParams', 'requestPath'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['disclaimer'];

    /**
     * The attributes that will be mapped.
     *
     * @var array
     */
    protected $maps = ['disclaimerRequired' => 'disclaimer'];

    /**
     * Store an Shop Country.
     *
     * @param string $methodName
     * @param string $code
     * @param string $buttonImageUrl
     * @param string $buttonText
     *
     * @return PaymentMethod
     */
    public function store(string $methodName, string $code, string $buttonImageUrl, string $buttonText): PaymentMethod
    {
        $this->attributes['name'] = $methodName;
        $this->attributes['buttonLogoUrl'] = $buttonImageUrl;
        $this->attributes['buttonText'] = $buttonText;
        $this->attributes['localizationKey'] = $code;
        $this->timestamps = false;

        $this->save();

        return $this;
    }

    /**
     * Get Disclaimer Required Attribute.
     *
     * @return bool
     */
    public function getDisclaimerRequiredAttribute(): bool
    {
        return $this->attributes['disclaimer'] == 1;
    }

    /**
     * Get Premium SMS Attribute.
     *
     * @return bool
     */
    public function getPremiumSmsAttribute(): bool
    {
        return false;
    }

    /**
     * Get Request Path Attribute.
     *
     * @return string
     */
    public function getRequestPathAttribute(): string
    {
        return 'online';
    }

    /**
     * Get the Purchase Params.
     *
     * @return PurchaseParam
     */
    public function getPurchaseParamsAttribute(): PurchaseParam
    {
        return $this->purchaseParams;
    }

    /**
     * Set Purchase Params.
     *
     * @param array $parameters
     */
    public function setPurchaseParams(array $parameters)
    {
        $this->purchaseParams = new PurchaseParam($parameters[0], $parameters[1], $this->attributes['id']);
    }

    /**
     * Get Category Payment Type.
     *
     * @return string
     */
    public function getCategoryAttribute(): string
    {
        return PaymentCategory::find($this->attributes['category'])->payment_type;
    }
}
