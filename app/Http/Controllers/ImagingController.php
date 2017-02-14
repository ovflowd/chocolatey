<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ImagingController
 * @package App\Http\Controllers
 */
class ImagingController extends BaseController
{
    /**
     * Get User Figure for Big Header
     * based on User Name
     *
     * @param Request $request
     * @return Redirector
     */
    public function getUserHead(Request $request)
    {
        return redirect('https://www.habbo.de/habbo-imaging/avatarimage?figure='
            . User::where('username', $request->input('user'))->first()->figureString . '&size=l&headonly=1');
    }
}
