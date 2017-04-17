<?php

namespace App\Models;

/**
 * Class Purse.
 */
class Purse
{
    /**
     * User Credits Balance.
     *
     * @var int
     */
    public $creditBalance = 0;

    /**
     * User Builders Club Furniture Limit.
     *
     * @var int
     */
    public $buildersClubFurniLimit = 0;

    /**
     * Remaining Builders Club Days.
     *
     * @var int
     */
    public $buildersClubDays = 0;

    /**
     * User Habbo Club Days.
     *
     * @var int
     */
    public $habboClubDays = 0;

    /**
     * User Diamond Balance.
     *
     * @var int
     */
    public $diamondBalance = 0;

    /**
     * Create an User Purse.
     *
     * @TODO: Get User Left Habbo Club Days
     * @TODO: Improve This
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $userDiamonds = UserCurrency::where('user_id', $userId)->where('type', 5)->first();
        $habboDays = floor(((UserSettings::where('user_id', $userId)->first()->club_expire_timestamp ?? 0) - time()) / 86400);

        $this->creditBalance = User::find($userId)->credits;
        $this->diamondBalance = $userDiamonds->amount ?? 0;
        $this->habboClubDays = $habboDays > 0 ? $habboDays : 0;
    }
}
