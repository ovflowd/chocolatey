<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends BaseController
{
    /**
     * Returns the Client URL
     *
     * @param Request $request
     * @return Response
     */
    public function getUrl(Request $request)
    {
        $hotelUrl = Config::get('azure.url');

        $accountType = in_array('NEW_USER', $request->user()->traits)
            ? 'habbo-client-new-user' : 'habbo-client-user';

        if ($accountType == 'habbo-client-new-user'):
            $request->user()->traits = ["USER"];

            Session::set('azureWEB', $request->user());
        endif;

        return response()->json(['clienturl' => "{$hotelUrl}client/{$accountType}"], 200, array(), JSON_UNESCAPED_SLASHES);
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
}
