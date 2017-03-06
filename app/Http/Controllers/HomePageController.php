<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
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
        if (Session::has('VotePolicy') && Config::get('chocolatey.vote.enabled')):
            Session::erase('VotePolicy');

            return redirect('https://findretros.com/rankings/vote/' . Config::get('chocolatey.vote.name'));
        endif;

        return response(view('habbo-web'));
    }
}
