<?php

namespace App\Http\Controllers;

use App\Facades\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends BaseController
{
    /**
     * Render a HabboWEB Page.
     *
     * @param string $pageCategory
     * @param string $pageFile
     * @return Response
     */
    public function show(string $pageCategory, string $pageFile): Response
    {
        $pageArray = explode('.', $pageFile);

        return response(view("habbo-web-pages.{$pageCategory}.{$pageArray[0]}"));
    }

    /**
     * Get Client View.
     *
     * @param string $clientType
     * @return Response
     */
    public function getClient($clientType): Response
    {
        User::updateSession(['auth_ticket' => ($userToken = uniqid('HabboWEB', true))]);

        return response(view($clientType, ['token' => $userToken]));
    }
}
