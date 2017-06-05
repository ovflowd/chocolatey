<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChocolateyModel.
 */
abstract class ChocolateyModel extends Model
{
    /**
     * Remove Useless Updated At.
     *
     * @return null
     */
    public function getUpdatedAtColumn()
    {
    }

    /**
     * Remove Useless Updated At.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        return $this;
    }
}
