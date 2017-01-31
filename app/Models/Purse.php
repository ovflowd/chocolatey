<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * Class Purse
 * @package App\Models
 */
class Purse
{
    /**
     * User Credits Balance
     *
     * @var int
     */
    public $creditBalance = 0;

    /**
     * User Builders Club Furniture Limit
     *
     * @var int
     */
    public $buildersClubFurniLimit = 0;

    /**
     * User Habbo Club Days
     *
     * @var int
     */
    public $habboClubDays = 0;

    /**
     * User Diamond Balance
     *
     * @var int
     */
    public $diamondBalance = 0;

    /**
     * Create an User Purse
     *
     * @TODO: Get User Left Habbo Club Days
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $userBalance = DB::table('users')->where('id', $userId)->select(['credits', 'pixels'])->first();

        $this->creditBalance = $userBalance->credits;
        $this->diamondBalance = $userBalance->pixels;
    }
}
