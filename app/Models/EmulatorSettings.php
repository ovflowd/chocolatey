<?php

namespace App\Models;

use Sofa\Eloquence\Metable\InvalidMutatorException;

/**
 * Class EmulatorSettings
 * @package App\Models
 */
class EmulatorSettings extends ChocolateyModel
{
    /**
     * Disable Timestamps
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
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store Function
     */
    public function store()
    {
        throw new InvalidMutatorException("Currently Chocolatey/Espreso doesn't support store Emulator Settings by CMS.");
    }
}
