<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends BaseController
{
    /**
     * Render a HabboWEB Page
     *
     * @param string $pageCategory
     * @param string $pageFile
     * @return Response
     */
    public function show($pageCategory, $pageFile)
    {
        $pageLanguage = ($pageArray = explode('.', $pageFile))[1];

        $pageName = $pageArray[0];

        return response(view("habbo-web-pages.production.{$pageCategory}.{$pageLanguage}.$pageName",
            ['azure' => Config::get('chocolatey')]), 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Get Client View
     *
     * @param Request $request
     * @param string $clientType
     * @return Response
     */
    public function getClient(Request $request, $clientType)
    {
        User::find($request->user()->uniqueId)->update([
            'auth_ticket' => ($userToken = (new ClientController)->generateToken())]);

        $userData = ['id' => $request->user()->uniqueId, 'name' => $request->user()->name, 'token' => $userToken];

        return response(view($clientType, ['azure' => Config::get('chocolatey'), 'user' => $userData]));
    }
}
