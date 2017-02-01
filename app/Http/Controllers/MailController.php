<?php

namespace App\Http\Controllers;

use App\Models\Mail as MailModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
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
     * @param Request $request
     * @return \Illuminate\Http\Response|ResponseFactory
     */
    public function verify(Request $request)
    {
        (new MailModel)->store($token = uniqid('HabboMail', true), 'public/registration/activate',
            $request->user()->email)->save();

        Mail::send('habbo-web-mail.confirm-mail', [
            'name' => $request->user()->name,
            'mail' => $request->user()->email,
            'url' => "/activate/{$token}"
        ], function ($message) use ($request) {
            $message->from(Config::get('chocolatey.contact'), Config::get('chocolatey.name'));
            $message->to($request->user()->email);
        });

        return response()->json('');
    }

    /**
     * Send User Forgot E-Mail
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        if (($user = User::where('mail', $request->json()->get('email'))->first()) == null)
            return response()->json('');

        (new MailModel)->store($token = uniqid('HabboMail', true), 'public/forgotPassword', $user->email)->save();

        Mail::send('habbo-web-mail.password-reset', [
            'name' => $user->name,
            'mail' => $user->email,
            'url' => "/reset-password/{$token}"
        ], function ($message) use ($user) {
            $message->from(Config::get('chocolatey.contact'), Config::get('chocolatey.name'));
            $message->to($user->email);
        });

        return response()->json('');
    }
}
