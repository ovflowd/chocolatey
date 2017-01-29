<?php

namespace App\Helpers;

use App\Models\User;

/**
 * Class Generators
 * @package App\Helpers
 */
class Generators
{
    /**
     * Return Random Username
     *
     * @param string $email
     * @return mixed|string
     */
    public function generateUserName($email)
    {
        $email = explode('@', $email);
        $email = $email[0];

        $username = '';
        $username .= $this->symbols(rand(0, 9));
        $username .= $this->symbols(rand(0, 9));

        $username .= (sizeof($email) > 10 ? substr($email, 0, 10) : $email);
        $username .= $this->symbols(rand(0, 9));
        $username .= $this->symbols(rand(0, 9));

        return User::query()->where('username', $username)->count() > 0
            ? $this->generateUserName($email) : $username;
    }
    
     /**
     * Generate User Auth Ticket
     * for Client usage only
     *
     * @return string
     */
    public function generateToken()
    {
        $data = '';

        for ($i = 1; $i <= 10; $i++)
            $data .= rand(0, 8);

        $data .= "d";
        $data .= rand(0, 4);
        $data .= "c";
        $data .= rand(0, 6);
        $data .= "c";
        $data .= rand(0, 8);
        $data .= "c";

        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 4);

        $data .= "d";

        for ($i = 1; $i <= 3; $i++)
            $data .= rand(0, 6);

        $data .= "ae";

        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 6);

        $data .= "bcb";
        $data .= rand(0, 4);
        $data .= "a";

        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 8);

        $data .= "c";

        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 4);

        $data .= "a";

        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 8);

        return $data;
    }

    /**
     * Random Symbols for Username
     *
     * @param int $rand
     * @return string
     */
    public function symbols($rand = 1)
    {
        switch ($rand):
            case 1:
                return '!';
            case 2:
                return '@';
            case 3:
                return '#';
            case 4:
                return '_';
            case 5:
                return '-';
            case 6:
                return '=';
            case 7:
                return '.';
            case 8:
                return '<';
            case 9:
                return '>';
            default:
                return '*';
        endswitch;
    }
}
