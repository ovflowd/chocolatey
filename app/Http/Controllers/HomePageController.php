<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
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
     * @return Response|Redirect
     */
    public function show()
    {
        return response(view('habbo-web'));
    }
}
