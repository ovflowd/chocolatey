<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class HomePageController.
 */
class HomePageController extends BaseController
{
    /**
     * Render the Home Page.
     *
     * @return Response|Redirect
     */
    public function show()
    {
        return response(view('habbo-web-pages.habbo-web'));
    }
}
