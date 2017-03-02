<?php

namespace App\Http\Controllers;

use App\Models\Mail as MailModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
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
     * Send an Email
     *
     * @param array $configuration
     * @param string $view
     */
    public function send(array $configuration, string $view = 'habbo-web-mail.confirm-mail')
    {
        @Mail::send($view, $configuration, function ($message) use ($configuration) {
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
     * Get E-Mail by Controller
     *
     * @param string $token
     * @return object
     */
    public function getMail(string $token)
    {
        $mailRequest = MailModel::where('token', $token)->where('used', '0')->first();

        if ($mailRequest !== null)
            $mailRequest->update(['used' => '1']);

        return $mailRequest;
    }
}
