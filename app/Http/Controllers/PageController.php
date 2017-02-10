<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
    public function show(string $pageCategory, string $pageFile): Response
    {
        $pageLanguage = ($pageArray = explode('.', $pageFile))[1];

        return response(view("habbo-web-pages.production.{$pageCategory}.{$pageLanguage}.{$pageArray[0]}"));
    }

    /**
     * Render a HabboWEB Page
     *
     * @param string $pageCategory
     * @param string $subCategory
     * @param string $pageFile
     * @return Response
     */
    public function showWithSub(string $pageCategory, string $subCategory, string $pageFile): Response
    {
        $pageLanguage = ($pageArray = explode('.', $pageFile))[1];

        return response(view("habbo-web-pages.production.{$pageCategory}.{$subCategory}.{$pageLanguage}.{$pageArray[0]}"));
    }

    /**
     * Get Client View
     *
     * @param Request $request
     * @param string $clientType
     * @return Response
     */
    public function getClient(Request $request, $clientType): Response
    {
        $request->user()->update(['auth_ticket' => ($userToken = uniqid('HabboWEB', true))]);

        return response(view($clientType, ['token' => $userToken]));
    }
}
