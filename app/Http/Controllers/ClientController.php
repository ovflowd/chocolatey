<?php

namespace App\Http\Controllers;

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
        $hotelUrl = Config::get('chocolatey.url');

        $accountType = in_array('NEW_USER', $request->user()->traits)
            ? 'habbo-client-new-user' : 'habbo-client-user';

        return response()->json(['clienturl' => "{$hotelUrl}client/{$accountType}"],
            200, [], JSON_UNESCAPED_SLASHES);
    }
}
