<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class PageController.
 */
class PageController extends BaseController
{
    /**
     * Render a HabboWEB Page.
     *
     * @param string $pageCategory
     * @param string $pageFile
     *
     * @return Response
     */
    public function show(string $pageCategory, string $pageFile): Response
    {
        $pageArray = explode('.', $pageFile);

        return response(view("habbo-web-pages.{$pageCategory}.{$pageArray[0]}"));
    }

    /**
     * Render a HabboPage.
     *
     * @WARNING: Categories can still be pages
     *
     * @param string $category
     * @param string $page
     *
     * @return Response
     */
    public function habboPage(string $category, string $page = '')
    {
        return response(view(empty($page) ? "habbo-pages.{$category}" : "habbo-pages.{$category}.{$page}"));
    }
}
