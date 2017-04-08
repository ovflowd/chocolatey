<?php

namespace App\Models;

/**
 * Class ShopInventory.
 */
class ShopInventory
{
    /**
     * Payment Categories of the Country.
     *
     * @var PaymentCategory[]
     */
    public $paymentCategories = [];

    /**
     * Inventory Items.
     *
     * @var array
     */
    public $pricePoints = [];

    /**
     * If double Credits are Enabled.
     *
     * @var bool
     */
    public $doubleCredits = false;

    /**
     * Country Meta Data.
     *
     * @var Country
     */
    public $country = null;

    /**
     * Create a Shop Inventory.
     *
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->setCountry($country);
        $this->setPaymentCategories($country->countryCode);
        $this->setPricePoints($country->countryCode);
    }

    /**
     * Set the Country Metadata.
     *
     * @param Country $country
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
    }

    /**
     * Set the Payment Methods.
     *
     * @param string $countryCode
     */
    public function setPaymentCategories(string $countryCode)
    {
        $paymentMethods = [];

        foreach (PaymentCategory::where('country_code', $countryCode)->get(['payment_type']) as $paymentMethod) {
            $paymentMethods[] = $paymentMethod->payment_type;
        }

        $this->paymentCategories = $paymentMethods;
    }

    /**
     * Get All Shop Items from this Country Code.
     *
     * @param string $countryCode
     */
    public function setPricePoints(string $countryCode)
    {
        $this->pricePoints = ShopItem::where('countryCode', $countryCode)->get();
    }
}
