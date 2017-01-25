<?php

namespace App\Http\Controllers;

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
            ['azure' => Config::get('azure')]), 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
