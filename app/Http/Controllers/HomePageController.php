<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class HomePageController
 * @package App\Http\Controllers
 */
class HomePageController extends BaseController
{
    /**
     * Render the Home Page
     *
     * @return Response
     */
    public function show(): Response
    {
        return response(view('habbo-web'));
    }
}
