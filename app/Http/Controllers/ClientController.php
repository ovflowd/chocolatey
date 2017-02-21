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
        if (($newUser = in_array('NEW_USER', $request->user()->traits)) && Config::get('chocolatey.vote.enabled'))
            return redirect('https://findretros.com/rankings/vote/' . Config::get('chocolatey.vote.name'));

        $hotelUrl = Config::get('chocolatey.url');

        $accountType = $newUser ? 'habbo-client-new-user' : 'habbo-client-user';

        return response()->json(['clienturl' => "{$hotelUrl}client/{$accountType}"],
            200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get HabboWEB Ads Interstitial
     *
     * @param string $interstitialType
     * @return Response
     */
    public function getInterstitial(string $interstitialType): Response
    {
        return response(view('habbo-web-ads.interstitial'));
    }
}
