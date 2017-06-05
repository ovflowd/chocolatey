<?php

namespace App\Models;

/**
 * Class Country.
 *
 * @property mixed countryCode
 * @property mixed uniqueId
 */
class Country extends ChocolateyModel
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
    protected $table = 'chocolatey_shop_countries';

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['uniqueId'];

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store an Shop Country.
     *
     * @param string $countryCode
     * @param string $name
     *
     * @return Country
     */
    public function store(string $countryCode, string $name): Country
    {
        $this->attributes['countryCode'] = $countryCode;
        $this->attributes['name'] = $name;
        $this->timestamps = false;

        return $this;
    }

    /**
     * Get Unique Id.
     *
     * @return int
     */
    public function getUniqueIdAttribute(): int
    {
        return $this->attributes['id'];
    }
}
