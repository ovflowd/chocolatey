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
     * Send an Email
     *
     * @param array $configuration
     * @param string $view
     */
    public function send(array $configuration, string $view = 'habbo-web-mail.confirm-mail')
    {
        Mail::send($view, $configuration, function ($message) use ($configuration) {
            $message->from(Config::get('chocolatey.contact'), Config::get('chocolatey.name'));
            $message->to($configuration['mail']);
        });
    }

    /**
     * Prepare the E-Mail
     *
     * @param string $email
     * @param string $url
     * @return string
     */
    public function prepare(string $email, string $url): string
    {
        (new MailModel)->store($token = uniqid('HabboMail', true), $url, $email)->save();

        return $token;
    }

    /**
     * Resend E-mail Verification
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        $this->send([
            'name' => $request->user()->name,
            'mail' => $request->user()->email,
            'url' => "/activate/{$this->prepare($request->user()->email, 'public/registration/activate')}"
        ]);

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

        $this->send([
            'name' => $user->name,
            'mail' => $user->email,
            'url' => "/activate/{$this->prepare($user->email, 'public/forgotPassword')}"
        ]);

        return response()->json('');
    }
}
