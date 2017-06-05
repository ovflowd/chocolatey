<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class ShopItem.
 *
 * @property mixed uniqueId
 */
class ShopItem extends ChocolateyModel
{
    use Eloquence, Mappable;

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
    protected $table = 'chocolatey_shop_items';

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
    protected $appends = ['paymentMethods', 'uniqueId'];

    /**
     * The attributes that will be mapped.
     *
     * @var array
     */
    protected $maps = ['paymentMethods' => 'payment_methods', 'uniqueId' => 'id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['payment_methods'];

    /**
     * Store an Shop Country.
     *
     * @param string $itemName
     * @param string $countryCode
     * @param int    $creditAmount
     * @param int    $iconId
     * @param array  $paymentMethods
     *
     * @return ShopItem
     */
    public function store(string $itemName, string $countryCode, int $creditAmount, int $iconId, array $paymentMethods): ShopItem
    {
        $this->attributes['name'] = $itemName;
        $this->attributes['countryCode'] = $countryCode;
        $this->attributes['creditAmount'] = $creditAmount;
        $this->attributes['iconId'] = $iconId;
        $this->attributes['payment_methods'] = implode(',', $paymentMethods);
        $this->timestamps = false;

        $this->save();

        return $this;
    }

    /**
     * Get Payment Methods.
     *
     * @return array
     */
    public function getPaymentMethodsAttribute(): array
    {
        $paymentMethods = [];

        if (!array_key_exists('payment_methods', $this->attributes)) {
            return $paymentMethods;
        }

        foreach (explode(',', $this->attributes['payment_methods']) as $shopCategory) {
            $paymentMethod = PaymentMethod::where('localizationKey', $shopCategory)->first();
            $paymentMethod->setPurchaseParams([Country::where('countryCode', $this->attributes['countryCode'])->first()->uniqueId, $this->attributes['id']]);
            $paymentMethods[] = $paymentMethod;
        }

        return $paymentMethods;
    }

    /**
     * Get Shop Item Categories.
     *
     * @return array
     */
    public function getCategoriesAttribute(): array
    {
        $shopCategories = [];

        foreach (explode(',', $this->attributes['categories']) as $shopCategory) {
            $shopCategories[] = ShopCategory::find($shopCategory)->category;
        }

        return $shopCategories;
    }
}
