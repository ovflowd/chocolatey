<?php

namespace App\Http\Controllers;

use App\Facades\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ClientController.
 */
class ClientController extends BaseController
{
    /**
     * Returns the Client URL.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getUrl(Request $request)
    {
        $hotelUrl = Config::get('chocolatey.hotelUrl');

        return response()->json(['clienturl' => "{$hotelUrl}/client/habbo-client"], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get Client View.
     *
     * @return Response
     */
    public function showClient(): Response
    {
        User::updateSession(['auth_ticket' => ($userToken = uniqid('HabboWEB', true))]);

        return response(view('habbo-web-pages.habbo-client', ['token' => $userToken, 'newUser' => in_array('NEW_USER', User::getUser()->traits)]));
    }

    /**
     * Get HabboWEB Ads Interstitial.
     *
     * @param string $interstitialType
     *
     * @return Response
     */
    public function getInterstitial(string $interstitialType): Response
    {
        return response(view('habbo-web-ads.interstitial'));
    }
}
