<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class MailController
 * @package App\Http\Controllers
 */
class MailController extends BaseController
{
    /**
     * Resend E-mail Verification
     *
     * @TODO: Implement E-mail Sending
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|ResponseFactory
     */
    public function verify(Request $request)
    {
        $userData = $request->user();

        //Send E-mail

        return response(null, 200);
    }
}
