<?php

namespace App\Models;

/**
 * Class EmulatorSettings.
 */
class EmulatorSettings extends ChocolateyModel
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
    protected $table = 'emulator_settings';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
