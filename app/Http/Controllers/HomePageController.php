<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        return response(view('habbo-web', ['request' => $request]), 200);
    }
}
