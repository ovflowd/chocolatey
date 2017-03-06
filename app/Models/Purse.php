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
     * Remaining Builders Club Days
     *
     * @var int
     */
    public $buildersClubDays = 0;

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
        $userCredits = DB::table('users')->where('id', $userId)->select(['credits'])->first();
        $userDiamonds = DB::table('users_currency')->where('user_id', $userId)->where('type', 5)->first();
        $habboDays = DB::table('users_settings')->where('user_id', $userId)->select(['club_expire_timestamp'])->first();
        $habboDays = floor((($habboDays->club_expire_timestamp ?? 0) - time()) / 86400);

        $this->creditBalance = $userCredits->credits;
        $this->diamondBalance = $userDiamonds->amount ?? 0;
        $this->habboClubDays = $habboDays > 0 ? $habboDays : 0;
    }
}
